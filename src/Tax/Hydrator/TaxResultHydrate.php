<?php

declare(strict_types=1);

namespace App\Tax\Hydrator;

use App\Tax\DTO\TaxResultDTO;

class TaxResultHydrate
{
    public static function hydrate(float $amount, string $type): TaxResultDTO
    {
        return new TaxResultDTO($amount, $type);
    }
}
