<?php

declare(strict_types=1);

namespace App\Tax\Service\Retriever;

use App\ExternalService\SeriousTax\Location;
use App\ExternalService\SeriousTax\SeriousTaxService;
use App\ExternalService\SeriousTax\TimeoutException;
use App\Tax\DTO\TaxDTO;
use App\Tax\DTO\TaxResultDTO;
use App\Tax\TaxFacade;

class SeriousTaxRetriever implements TaxRetrieverInterface
{
    private const TAX_TYPE = 'VAT';

    public function __construct(private readonly SeriousTaxService $seriousTaxService)
    {
    }

    /**
     * @throws TimeoutException
     */
    public function retrieveTax(TaxDTO $data): TaxResultDTO
    {
        $result = $this->seriousTaxService->getTaxesResult(new Location($data->getCountry(), $data->getState()));

        return TaxFacade::hydrateTaxResult($result, self::TAX_TYPE);
    }
}
