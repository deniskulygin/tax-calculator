<?php

declare(strict_types=1);

namespace App\Tax\Cache;

use App\Tax\DTO\TaxDTO;
use App\Tax\DTO\TaxResultCollection;

interface TaxCacheInterface
{
    public function getCachedTax(TaxDTO $taxData): ?TaxResultCollection;

    public function cacheTax(TaxDTO $taxData, TaxResultCollection $taxResultCollection): void;
}
