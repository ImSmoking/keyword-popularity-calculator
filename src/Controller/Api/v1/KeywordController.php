<?php

namespace App\Controller\Api\v1;

use App\Controller\Api\ApiController;
use App\Container\KeywordProviderContainer;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/keyword', name: 'keyword_')]
class KeywordController extends ApiController
{
    /**
     * @throws ContainerExceptionInterface
     */
    #[Route('/score/{source}/{term}', name: 'score', methods: ['GET'])]
    public function scoreAction(
        string                   $source,
        string                   $term,
        KeywordProviderContainer $keywordProviderContainer,
        TranslatorInterface      $translator
    ): JsonResponse
    {
        try {
            $keywordProvider = $keywordProviderContainer->get($source);
            $keyword = $keywordProvider->getKeyword($term);
            $response = $this->getJsonResponse(
                $keyword,
                ['groups' => 'get_score']
            );
        } catch (NotFoundExceptionInterface) {

            $availableSourceOptions = KeywordProviderContainer::getAvailableKeywordProviders(true);

            $message = $translator->trans('exception.invalid_source', [
                '%source%' => $source,
                '%valid_sources%' => $availableSourceOptions
            ], 'exceptions');

            $response = $this->getJsonResponse(['message' => $message], [], Response::HTTP_BAD_REQUEST
            );
        }

        return $response;
    }
}