<?php

declare(strict_types=1);

namespace App\Tax\DTO;

class TaxResultCollection
{
    public function __construct(private array $collection = [])
    {
    }

    public function addResultDTO(TaxResultDTO $taxResultDTO): self
    {
        $this->collection[] = $taxResultDTO;

        return $this;
    }

    public function getCollection(): array
    {
        return $this->collection;
    }

    public function toArray(): array
    {
        return array_map(fn(TaxResultDTO $taxResultDTO) => $taxResultDTO->toArray(), $this->collection);
    }
}
