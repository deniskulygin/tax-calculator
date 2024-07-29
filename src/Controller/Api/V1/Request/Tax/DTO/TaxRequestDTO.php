<?php

declare(strict_types=1);

namespace App\Controller\Api\V1\Request\Tax\DTO;

use App\Tax\TypeEnum\CountryEnum;
use App\Tax\TypeEnum\StateEnum;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class TaxRequestDTO
{
    public function __construct(
        #[Assert\NotBlank(message: 'Country is required')]
        #[Assert\NotNull(message: 'Country is required')]
        #[Assert\Type('string')]
        #[Assert\Length(
            min: 2,
            max: 2,
            exactMessage: 'Country name name must be  {{ limit }} characters long'
        )]
        private string $country,
        #[Assert\Type('string')]
        #[Assert\Length(
            min: 2,
            max: 50,
            minMessage: 'State name cannot be less than {{ limit }} characters',
            maxMessage: 'State name cannot be longer than {{ limit }} characters'
        )]
        private ?string $state,
    ) {
        $this->state = $state ? strtolower($state) : null;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    #[Assert\Callback]
    public function validate(ExecutionContextInterface $context): void
    {
        if ($this->getCountry() !== null && CountryEnum::tryFrom($this->getCountry()) === null) {
            $context->buildViolation('Country is not supported')->addViolation();
        }

        if ($this->getState() !== null && StateEnum::tryFrom($this->getState()) === null) {
            $context->buildViolation('State is not supported')->addViolation();
        }
    }
}
