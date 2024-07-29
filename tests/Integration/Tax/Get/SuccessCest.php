<?php

declare(strict_types=1);

namespace App\Tests\Integration\Tax\Get;

use App\Tests\Support\IntegrationTester;
use Codeception\Example;

class SuccessCest
{
    /**
     * @dataProvider countryWithStateDataProvider
     */
    public function testSuccessCountryWithSates(IntegrationTester $I, Example $example): void
    {
        $country = $example['country'];
        $state = $example['state'];

        $I->sendGet('/api/v1/taxes', ['country' => $country, 'state' => $state]);

        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson($example['response']);


        $I->dontSeeInRedis($country . '/' . $state, json_encode($example['cache_data']));

        $I->seeInRedis($country . '/' . mb_strtolower($state), json_encode($example['cache_data']));
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

        $I->seeInRedis($country, json_encode([['taxAmount' => $taxAmount, 'taxType' => $taxType]]));
    }

    public function testSuccessCountryCachedInUpperCase(IntegrationTester $I): void
    {
        $country = 'lv';

        $I->sendGet('/api/v1/taxes', ['country' => $country]);

        $I->seeResponseCodeIs(200);
        $I->dontSeeInRedis($country);
        $I->seeInRedis(strtoupper($country));
    }

    private function countryWithStateDataProvider(): array
    {
        return [
            [
                'country' => 'CA',
                'state' => 'Ontario',
                'response' => [
                    [
                        'percentage' => 13,
                        "taxType" => 'GST/HST',
                    ],
                ],
                'cache_data' => [
                    [
                        'taxAmount' => 13,
                        "taxType" => 'GST/HST',
                    ],
                ],
            ],
            [
                'country' => 'US',
                'state' => 'California',
                'response' => [
                    [
                        'percentage' => 7.25,
                        "taxType" => 'VAT',
                    ],
                ],
                'cache_data' => [
                    [
                        'taxAmount' => 7.25,
                        "taxType" => 'VAT',
                    ],
                ],
            ],
            [
                'country' => 'CA',
                'state' => 'Quebec',
                'response' => [
                    [
                        'percentage' => 5,
                        "taxType" => 'GST/HST',
                    ],
                    [
                        'percentage' => 9.975,
                        "taxType" => 'PST',
                    ],
                ],
                'cache_data' => [
                    [
                        'taxAmount' => 5,
                        "taxType" => 'GST/HST',
                    ],
                    [
                        'taxAmount' => 9.975,
                        "taxType" => 'PST',
                    ],
                ],
            ],
        ];
    }
}
