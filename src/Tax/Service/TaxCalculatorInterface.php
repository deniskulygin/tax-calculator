<?php

declare(strict_types=1);

namespace App\Tax\Service;

use App\Tax\DTO\TaxDTO;
use App\Tax\DTO\TaxResultCollection;

interface TaxCalculatorInterface
{
    public function getTax(TaxDTO $data): TaxResultCollection;
}
