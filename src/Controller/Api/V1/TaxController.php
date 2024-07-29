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
        TaxCalculatorInterface $taxService,
        #[MapQueryString] TaxRequestDTO $requestDTO = null,
    ): Response {
        if ($requestDTO === null) {
            return $this->json(['message' => 'Country is required'], Response::HTTP_BAD_REQUEST);
        }

        $resultCollection = $taxService->getTax(
            TaxFacade::hydrateTax($requestDTO->getCountry(), $requestDTO->getState())
        );

        return $this->json(
            data: $resultCollection->getCollection(),
            context: [AbstractNormalizer::GROUPS => ['tax_default']]
        );
    }
}
