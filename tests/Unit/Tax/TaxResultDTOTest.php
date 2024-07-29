<?php

declare(strict_types=1);

namespace App\Tests\Unit\Tax;

use App\Tax\DTO\TaxResultDTO;
use PHPUnit\Framework\TestCase;

class TaxResultDTOTest extends TestCase
{
    public function testFillAndGetData(): void
    {
        $taxAmount = 15.5;
        $taxType = 'VAT';
        $dto = new TaxResultDTO($taxAmount, $taxType);

        $this->assertSame($taxType, $dto->getTaxType());
        $this->assertSame($taxAmount, $dto->getTaxAmount());
    }

    public function testSetAllValuesAndGetAsArray(): void
    {
        $taxAmount = 15.5;
        $taxType = 'VAT';
        $dto = new TaxResultDTO($taxAmount, $taxType);

        $this->assertSame(
            [
                'taxAmount' => $taxAmount,
                'taxType' => $taxType,
            ],
            $dto->toArray()
        );
    }
}
