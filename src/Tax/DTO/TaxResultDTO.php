<?php

declare(strict_types=1);

namespace App\Tax\DTO;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

final readonly class TaxResultDTO
{
    public function __construct(
        #[Groups(['tax_default'])]
        #[SerializedName('percentage')]
        private float $taxAmount,
        #[Groups(['tax_default'])]
        private string $taxType
    ) {
    }

    public function getTaxAmount(): float
    {
        return $this->taxAmount;
    }

    public function getTaxType(): string
    {
        return $this->taxType;
    }

    public function toArray(): array
    {
        return [
            'taxAmount' => $this->taxAmount,
            'taxType' => $this->taxType,
        ];
    }
}
