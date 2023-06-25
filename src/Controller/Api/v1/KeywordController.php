<?php

namespace App\Controller\Api\v1;

use App\Controller\Api\ApiController;
use App\Container\KeywordProviderContainer;
use App\Entity\Keyword;
use Nelmio\ApiDocBundle\Annotation\Model;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use OpenApi\Attributes as OA;

#[Route('/keyword', name: 'keyword_')]
class KeywordController extends ApiController
{
    /**
     * @throws ContainerExceptionInterface
     */
    #[Route('/score/{source}/{term}', name: 'score', methods: ['GET'])]
    #[OA\Get(summary: "Get score for the passed keyword(term)", tags: ['Keyword'])]
    #[OA\Parameter(name: 'source', in: 'path', required: true, example: 'github')]
    #[OA\Parameter(name: 'term', in: 'path', required: true, example: 'php')]
    #[OA\Response(
        response: 200,
        description: 'Returns the term score',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(
                    property: 'data',
                    ref: new Model(type: Keyword::class, groups: ['get_score'])
                )
            ],
            type: 'object'
        )
    )]
    #[OA\Response(
        response: 403,
        description: "Bad request",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(
                    property: 'data',
                    example: ['message' => "'%source%' is not a valid 'source' parameter option! Valid options are %valid_sources%"]
                )
            ]
        )
    )]
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

            $response = $this->getJsonResponse(['message' => $message], [], Response::HTTP_BAD_REQUEST);
        }

        return $response;
    }

    #[Route('/sources', name: 'sources', methods: ['GET'])]
    #[OA\Get(summary: "Get available keyword sources", tags: ['Keyword'])]
    #[OA\Response(
        response: 200,
        description: 'Lists out available keyword sources',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(
                    property: 'data',
                    properties: [
                        new OA\Property(
                            property: 'sources',
                            example: ["source_01", "source_02"]
                        )
                    ],
                )
            ]
        )
    )]
    public function sourcesAction(): JsonResponse
    {
        $availableSources = KeywordProviderContainer::getAvailableKeywordProviders();
        return $this->getJsonResponse(['sources' => $availableSources]);
    }
}