<?php

declare(strict_types=1);

namespace App\Tax\Service\Retriever;

use App\Tax\DTO\TaxDTO;
use App\Tax\DTO\TaxResultDTO;

interface TaxRetrieverInterface
{
    public function retrieveTax(TaxDTO $data): TaxResultDTO;
}
