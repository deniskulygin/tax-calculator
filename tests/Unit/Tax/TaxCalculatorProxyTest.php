<?php

declare(strict_types=1);

namespace App\Tests\Unit\Tax;

use App\Cache\TaxCacheInterface;
use App\Exception\TaxCountryNotSupportedException;
use App\Tax\DTO\TaxDTO;
use App\Tax\DTO\TaxResultDTO;
use App\Tax\Service\TaxCalculator;
use App\Tax\Service\TaxCalculatorProxy;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class TaxCalculatorProxyTest extends TestCase
{
    /**
     * @throws TaxCountryNotSupportedException
     * @throws Exception
     */
    public function testGetTaxReturnsCachedResult(): void
    {
        $taxDTO = new TaxDTO();
        $taxResultDTO = new TaxResultDTO();

        $taxCacheService = $this->createMock(TaxCacheInterface::class);
        $taxService = $this->createMock(TaxCalculator::class);

        $taxCacheService->expects($this->once())
            ->method('getCachedTax')
            ->willReturn($taxResultDTO);

        $taxCalculatorProxy = new TaxCalculatorProxy($taxService, $taxCacheService);

        $result = $taxCalculatorProxy->getTax($taxDTO);

        $this->assertSame($taxResultDTO, $result);
    }

    /**
     * @throws TaxCountryNotSupportedException
     * @throws Exception
     */
    public function testGetTaxCallsTaxServiceWhenNoCachedResult(): void
    {
        $taxDTO = new TaxDTO();
        $taxResultDTO = new TaxResultDTO();

        $taxCacheService = $this->createMock(TaxCacheInterface::class);
        $taxService = $this->createMock(TaxCalculator::class);

        $taxCacheService->expects($this->once())
            ->method('getCachedTax')
            ->willReturn(null);

        $taxService->expects($this->once())
            ->method('getTax')
            ->willReturn($taxResultDTO);

        $taxCalculatorProxy = new TaxCalculatorProxy($taxService, $taxCacheService);

        $result = $taxCalculatorProxy->getTax($taxDTO);

        $this->assertSame($taxResultDTO, $result);
    }
}
