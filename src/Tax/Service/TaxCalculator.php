<?php

declare(strict_types=1);

namespace App\Tax\Service;

use App\Cache\TaxCacheInterface;
use App\Exception\TaxCountryNotSupportedException;
use App\ExternalService\SeriousTax\TimeoutException;
use App\ExternalService\TaxBee\TaxBeeException;
use App\Tax\DTO\TaxDTO;
use App\Tax\DTO\TaxResultDTO;
use App\Tax\Service\Retriever\TaxRetrieverInterface;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

class TaxCalculator implements TaxCalculatorInterface
{
    public function __construct(
        #[TaggedIterator('app.tax_retriever')] private readonly iterable $retrievers,
        private readonly TaxCacheInterface $taxCacheService
    ) {
    }

    public function getTax(TaxDTO $data): TaxResultDTO
    {
        /** @var TaxRetrieverInterface $retriever */
        foreach ($this->retrievers as $retriever) {
            try {
                $result = $retriever->retrieveTax($data);
                $this->taxCacheService->cacheTax($data, $result);

                return $result;
            } catch (TimeoutException | TaxBeeException) {
            }
        }
    }
}
