<?php

declare(strict_types=1);

namespace App\Tax\Hydrator;

use App\Tax\DTO\TaxResultDTO;

class TaxResultHydrate
{
    public static function hydrate(TaxResultDTO $taxResultDTO, float $amount, string $type): TaxResultDTO
    {
        return $taxResultDTO
            ->setTaxType($type)
            ->setTaxAmount($amount);
    }
}
