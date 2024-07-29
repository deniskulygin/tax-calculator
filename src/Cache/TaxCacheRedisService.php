<?php

declare(strict_types=1);

namespace App\Cache;

use App\Tax\DTO\TaxDTO;
use App\Tax\DTO\TaxResultDTO;
use App\Tax\TaxFacade;
use Predis\Client as RedisClient;

readonly class TaxCacheRedisService implements TaxCacheInterface
{
    private const LIFETIME = 3600;

    public function __construct(private RedisClient $redisClient)
    {
    }

    public function getCachedTax(TaxDTO $taxData): ?TaxResultDTO
    {
        $key = $this->makeKey($taxData);

        if ($this->redisClient->exists($key)) {
            $result = $this->redisClient->get($key);
            $result = json_decode($result, true);

            return TaxFacade::hydrateTaxResult($result['amount'], $result['type']);
        }

        return null;
    }

    public function cacheTax(TaxDTO $taxData, TaxResultDTO $resultData): void
    {
        $key = $this->makeKey($taxData);
        $value = json_encode(['type' => $resultData->getTaxType(), 'amount' => $resultData->getTaxAmount()]);

        $this->redisClient->setex($key, self::LIFETIME, $value);
    }

    private function makeKey(TaxDTO $taxData): string
    {
        return $taxData->getState() ? $taxData->getCountry() . '/' . $taxData->getState() : $taxData->getCountry();
    }
}
