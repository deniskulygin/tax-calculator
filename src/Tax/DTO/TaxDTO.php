<?php

declare(strict_types=1);

namespace App\Tax\DTO;

class TaxDTO
{
    private string $country;
    private ?string $state = null;

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function setState(?string $state): self
    {
        $this->state = $state;

        return $this;
    }


    public function getCountry(): string
    {
        return $this->country;
    }

    public function getState(): ?string
    {
        return $this->state;
    }
}
