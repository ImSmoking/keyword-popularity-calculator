<?php

namespace App\Controller\Api\v1;

use App\Controller\Api\ApiController;
use App\Container\KeywordProviderContainer;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/keyword', name: 'keyword_')]
class KeywordController extends ApiController
{
    /**
     * @throws ContainerExceptionInterface
     */
    #[Route('/score/{source}/{term}', name: 'score', methods: ['GET'])]
    public function scoreAction(string $source, string $term, KeywordProviderContainer $keywordProviderContainer): JsonResponse
    {
        try {
            $keywordProvider = $keywordProviderContainer->get($source);

            $response = $this->getJsonResponse(
                $keywordProvider->getKeyword($term),
                ['groups' => 'get_score']
            );
        } catch (NotFoundExceptionInterface) {

            $availableSourceOptions = KeywordProviderContainer::getAvailableKeywordProviders(true);
            $message = "'{$source}' is not a valid 'source' parameter option! Valid options are " . $availableSourceOptions.'.';

            $response = $this->getJsonResponse(
                ['message' => $message],
                [],
                Response::HTTP_BAD_REQUEST
            );
        }

        return $response;
    }
}