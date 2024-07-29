<?php

declare(strict_types=1);

namespace App\Cache;

use App\Tax\DTO\TaxDTO;
use App\Tax\DTO\TaxResultDTO;

interface TaxCacheInterface
{
    public function getCachedTax(TaxDTO $taxData): ?TaxResultDTO;

    public function cacheTax(TaxDTO $taxData, TaxResultDTO $resultData): void;
}
