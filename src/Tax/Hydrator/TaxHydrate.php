<?php

declare(strict_types=1);

namespace App\Tax\Hydrator;

use App\Tax\DTO\TaxDTO;

class TaxHydrate
{
    public static function hydrate(TaxDTO $taxDTO, string $country, ?string $state): TaxDTO
    {
        return $taxDTO
            ->setCountry($country)
            ->setState($state);
    }
}
