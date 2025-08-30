<?php

declare(strict_types=1);

namespace App\Tax\Cache;

use App\Tax\DTO\TaxDTO;
use App\Tax\DTO\TaxResultCollection;
use App\Tax\TaxFacade;
use Predis\Client as RedisClient;

readonly class TaxCacheRedisService implements TaxCacheInterface
{
    private const LIFETIME = 3600;

    public function __construct(
        private RedisClient $redisClient
    ) {
    }

    public function getCachedTax(TaxDTO $taxData): ?TaxResultCollection
    {
        $key = $this->makeKey($taxData);

        if ($this->redisClient->exists($key)) {
            $result = $this->redisClient->get($key);
            $dataArray = json_decode($result, true);

            return TaxFacade::hydrateCachedResultCollection($dataArray);
        }

        return null;
    }

    public function cacheTax(TaxDTO $taxData, TaxResultCollection $taxResultCollection): void
    {
        $key = $this->makeKey($taxData);
        $data = json_encode($taxResultCollection->toArray());

        $this->redisClient->setex($key, self::LIFETIME, $data);
    }

    private function makeKey(TaxDTO $taxData): string
    {
        return $taxData->getState() ? $taxData->getCountry() . '/' . $taxData->getState() : $taxData->getCountry();
    }
}
