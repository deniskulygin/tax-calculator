<?php

declare(strict_types=1);

namespace App\Tax\Service\Retriever;

use App\ExternalService\TaxBee\TaxBee;
use App\ExternalService\TaxBee\TaxBeeException;
use App\Tax\DTO\TaxDTO;
use App\Tax\DTO\TaxResultCollection;
use App\Tax\TaxFacade;

class TaxBeeRetriever implements TaxRetrieverInterface
{
    public function __construct(private readonly TaxBee $taxBeeService)
    {
    }

    /**
     * @throws TaxBeeException
     */
    public function retrieveTax(TaxDTO $data): TaxResultCollection
    {
        $state = $data->getState() ?: '';
        $result = $this->taxBeeService->getTaxes($data->getCountry(), $state, '', '', '');

        return TaxFacade::hydrateTaxBeeResult($result);
    }
}
