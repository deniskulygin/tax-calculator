<?php

declare(strict_types=1);

namespace App\Tax\Service\Retriever;

use App\Tax\DTO\TaxDTO;
use App\Tax\DTO\TaxResultCollection;

interface TaxRetrieverInterface
{
    public function retrieveTax(TaxDTO $data): TaxResultCollection;
}
