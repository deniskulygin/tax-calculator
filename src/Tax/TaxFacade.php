<?php

declare(strict_types=1);

namespace App\Tax;

use App\ExternalService\TaxBee\TaxResult;
use App\Tax\DTO\TaxDTO;
use App\Tax\DTO\TaxResultCollection;
use App\Tax\Hydrator\TaxHydrate;
use App\Tax\Hydrator\TaxResultCollectionHydrate;
use App\Tax\Hydrator\TaxResultHydrate;

class TaxFacade
{
    public static function hydrateSeriousTaxResult(float $amount, string $type): TaxResultCollection
    {
        return TaxResultCollectionHydrate::hydrate(
            new TaxResultCollection(),
            TaxResultHydrate::hydrate($amount, $type)
        );
    }

    public static function hydrateTaxBeeResult(array $results): TaxResultCollection
    {
        $collection = new TaxResultCollection();

        /** @var TaxResult $result */
        foreach ($results as $result) {
            TaxResultCollectionHydrate::hydrate(
                $collection,
                TaxResultHydrate::hydrate($result->taxPercentage, $result->type->value)
            );
        }

        return $collection;
    }

    public static function hydrateCachedResultCollection(array $results): TaxResultCollection
    {
        $collection = new TaxResultCollection();

        foreach ($results as $result) {
            TaxResultCollectionHydrate::hydrate(
                $collection,
                TaxResultHydrate::hydrate($result['taxAmount'], $result['taxType'])
            );
        }

        return $collection;
    }

    public static function hydrateTax(string $country, ?string $state): TaxDTO
    {
        return TaxHydrate::hydrate(new TaxDTO(), $country, $state);
    }
}
