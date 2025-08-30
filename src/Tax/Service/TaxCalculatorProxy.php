<?php

declare(strict_types=1);

namespace App\Tax\Service;

use App\Tax\Cache\TaxCacheInterface;
use App\Tax\DTO\TaxDTO;
use App\Tax\DTO\TaxResultCollection;

readonly class TaxCalculatorProxy implements TaxCalculatorInterface
{
    public function __construct(
        private TaxCalculator $taxService,
        private TaxCacheInterface $taxCacheService
    ) {
    }

    public function getTax(TaxDTO $data): TaxResultCollection
    {
        $cachedResult = $this->taxCacheService->getCachedTax($data);

        return $cachedResult ?: $this->taxService->getTax($data);
    }
}
