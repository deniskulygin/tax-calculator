<?php

declare(strict_types=1);

namespace App\Tax\Hydrator;

use App\Tax\DTO\TaxResultCollection;
use App\Tax\DTO\TaxResultDTO;

class TaxResultCollectionHydrate
{
    public static function hydrate(
        TaxResultCollection $taxResultCollection,
        TaxResultDTO $taxResultDTO
    ): TaxResultCollection {
        return $taxResultCollection->addResultDTO($taxResultDTO);
    }
}
