<?php

declare(strict_types=1);

namespace App\Tax;

use App\Tax\DTO\TaxDTO;
use App\Tax\DTO\TaxResultDTO;
use App\Tax\Hydrator\TaxHydrate;
use App\Tax\Hydrator\TaxResultHydrate;

class TaxFacade
{
    public static function hydrateTaxResult(float $amount, string $type): TaxResultDTO
    {
        return TaxResultHydrate::hydrate(new TaxResultDTO(), $amount, $type);
    }

    public static function hydrateTax(string $country, ?string $state): TaxDTO
    {
        return TaxHydrate::hydrate(new TaxDTO(), $country, $state);
    }
}
