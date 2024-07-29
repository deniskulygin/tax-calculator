<?php

declare(strict_types=1);

namespace App\Tests\Unit\Tax;

use App\Tax\DTO\TaxDTO;
use PHPUnit\Framework\TestCase;

class TaxDTOTest extends TestCase
{
    public function testSetAndGetCountry(): void
    {
        $dto = new TaxDTO();
        $country = 'US';

        $dto->setCountry($country);

        $this->assertSame($country, $dto->getCountry());
    }

    public function testSetAndGetState(): void
    {
        $dto = new TaxDTO();
        $state = 'CA';

        $dto->setState($state);

        $this->assertSame($state, $dto->getState());
    }

    public function testSetStateCanBeNull(): void
    {
        $dto = new TaxDTO();

        $this->assertNull($dto->getState());
    }
}
