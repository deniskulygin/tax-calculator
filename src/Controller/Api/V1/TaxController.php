<?php

declare(strict_types=1);

namespace App\Controller\Api\V1;

use App\Controller\Api\V1\Request\Tax\DTO\TaxRequestDTO;
use App\Tax\Service\TaxCalculatorInterface;
use App\Tax\TaxFacade;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class TaxController extends AbstractController
{
    #[Route('/taxes')]
    public function getTaxes(
        #[MapQueryString] TaxRequestDTO $requestDTO,
        TaxCalculatorInterface $taxService
    ): Response {
        $tax = $taxService->getTax(TaxFacade::hydrateTax($requestDTO->getCountry(), $requestDTO->getState()));

        return $this->json(data: $tax, context: [AbstractNormalizer::GROUPS => ['tax_default']]);
    }
}
