<?php

declare(strict_types=1);

namespace App\Tests\Unit\Tax;

use App\Tax\DTO\TaxResultDTO;
use PHPUnit\Framework\TestCase;

class TaxResultDTOTest extends TestCase
{
    public function testSetAndGetTaxType(): void
    {
        $dto = new TaxResultDTO();
        $taxType = 'VAT';

        $dto->setTaxType($taxType);

        $this->assertSame($taxType, $dto->getTaxType());
    }

    public function testSetAndGetTaxAmount(): void
    {
        $dto = new TaxResultDTO();
        $taxAmount = 15.5;

        $dto->setTaxAmount($taxAmount);

        $this->assertSame($taxAmount, $dto->getTaxAmount());
    }
}
