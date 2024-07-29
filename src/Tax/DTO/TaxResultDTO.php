<?php

declare(strict_types=1);

namespace App\Tax\DTO;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

final readonly class TaxResultDTO
{
    #[Groups(['tax_default'])]
    #[SerializedName('percentage')]
    private float $taxAmount;

    #[Groups(['tax_default'])]
    private string $taxType;

    public function setTaxType(string $taxType): self
    {
        $this->taxType = $taxType;

        return $this;
    }

    public function setTaxAmount(float $taxAmount): self
    {
        $this->taxAmount = $taxAmount;

        return $this;
    }

    public function getTaxAmount(): float
    {
        return $this->taxAmount;
    }

    public function getTaxType(): string
    {
        return $this->taxType;
    }
}
