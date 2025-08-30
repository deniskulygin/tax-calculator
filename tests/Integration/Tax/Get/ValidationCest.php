<?php

declare(strict_types=1);

namespace App\Tests\Integration\Tax\Get;

use App\Tests\Support\IntegrationTester;
use Codeception\Example;

class ValidationCest
{
    /**
     * @example {"country": "CAA", "message": "Country is not supported"}
     * @example {"country": 123, "message": "Country is not supported"}
     * @example {"country": null, "message": "Country is required"}
     */
    public function testNotSupportedCountries(IntegrationTester $I, Example $example): void
    {
        $I->sendGet('/api/v1/taxes', ['country' => $example['country']]);

        $I->seeResponseCodeIs(400);
        $I->seeResponseContainsJson(['message' => $example['message']]);

        $I->dontSeeInRedis((string) $example['country']);
    }

    /**
     * @example {"country": "CAA"}
     * @example {"country": "C"}
     */
    public function testCountryLengthLimit(IntegrationTester $I, Example $example): void
    {
        $I->sendGet('/api/v1/taxes', ['country' => $example['country']]);

        $I->seeResponseCodeIs(400);
        $I->seeResponseIsJson([
            ['message' => 'Country is not supported'],
            ['message' => 'Country name name must be 2 characters long'],
        ]);
    }

    /**
     * @dataProvider stateLengthLimitProvider
     */
    public function testStateLengthLimit(IntegrationTester $I, Example $example): void
    {
        $I->sendGet('/api/v1/taxes', ['country' => 'CA', 'state' => $example['state']]);

        $I->seeResponseCodeIs(400);
        $I->seeResponseContainsJson(['message' => $example['message']]);

        $I->seeResponseIsJson([
            ['message' => 'State is not supported'],
            ['message' => $example['state']],
        ]);
    }

    /**
     * @example {"country": "US", "state": "State"}
     * @example {"country": "US", "state": 342}
     */
    public function testNotSupportedState(IntegrationTester $I, Example $example): void
    {
        $I->sendGet('/api/v1/taxes', ['country' => $example['country'], 'state' => $example['state']]);

        $I->seeResponseCodeIs(400);
        $I->seeResponseContainsJson(['message' => 'State is not supported']);

        $I->dontSeeInRedis($example['country'] . '/' . $example['state']);
    }

    private function stateLengthLimitProvider(): array
    {
        return [
            ['state' => str_repeat('a', 51), 'message' => 'State name cannot be longer than 50 characters'],
            ['state' => 'a', 'message' => 'State name cannot be less than 2 characters'],
        ];
    }
}
