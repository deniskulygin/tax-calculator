<?php

declare(strict_types=1);

namespace App\Tests\Integration\Tax\Get;

use App\Tests\Support\IntegrationTester;
use Codeception\Example;

class SuccessCest
{
    /**
     * @example {"country": "CA", "state": "Quebec", "tax_type":"GST/HST", "tax_amount": 5}
     * @example {"country": "CA", "state": "Ontario", "tax_type":"GST/HST", "tax_amount": 13}
     * @example {"country": "US", "state": "California", "tax_type":"VAT", "tax_amount": 7.25}
     */
    public function testSuccessCountryWithSates(IntegrationTester $I, Example $example): void
    {
        $country = $example['country'];
        $state = $example['state'];
        $taxType = $example['tax_type'];
        $taxAmount = $example['tax_amount'];

        $I->sendGet('/api/v1/taxes', ['country' => $country, 'state' => $state]);

        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson([
            'taxType' => $taxType,
            'percentage' => $taxAmount,
        ]);

        $I->dontSeeInRedis(
            $country . '/' . $state,
            json_encode(['type' => $taxType, 'amount' => $taxAmount])
        );

        $I->seeInRedis(
            $country . '/' . mb_strtolower($state),
            json_encode(['type' => $taxType, 'amount' => $taxAmount])
        );
    }

    /**
     * @example {"country": "LT", "tax_type":"VAT", "tax_amount": 21}
     * @example {"country": "LV", "tax_type":"VAT", "tax_amount": 22}
     * @example {"country": "EE", "tax_type":"VAT", "tax_amount": 20}
     * @example {"country": "DE", "tax_type":"VAT", "tax_amount": 19}
     */
    public function testSuccessCountryWithoutSates(IntegrationTester $I, Example $example): void
    {
        $country = $example['country'];
        $taxType = $example['tax_type'];
        $taxAmount = $example['tax_amount'];

        $I->sendGet('/api/v1/taxes', ['country' => $country]);

        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson([
            'taxType' => $taxType,
            'percentage' => $taxAmount,
        ]);

        $I->seeInRedis($country, json_encode(['type' => $taxType, 'amount' => $taxAmount]));
    }
}
