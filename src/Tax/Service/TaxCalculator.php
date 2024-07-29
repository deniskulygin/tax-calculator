<?php

declare(strict_types=1);

namespace App\Tax\Service;

use App\ExternalService\SeriousTax\TimeoutException;
use App\ExternalService\TaxBee\TaxBeeException;
use App\Tax\Cache\TaxCacheInterface;
use App\Tax\DTO\TaxDTO;
use App\Tax\DTO\TaxResultCollection;
use App\Tax\Service\Retriever\TaxRetrieverInterface;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TaxCalculator implements TaxCalculatorInterface
{
    public function __construct(
        #[TaggedIterator('app.tax_retriever')] private iterable $retrievers,
        private TaxCacheInterface $taxCacheService
    ) {
    }

    public function getTax(TaxDTO $data): TaxResultCollection
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

        throw new NotFoundHttpException('Country is not found');
    }
}
