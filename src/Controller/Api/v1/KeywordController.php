<?php

namespace App\Controller\Api\v1;

use App\Controller\Api\ApiController;
use App\Container\KeywordProviderContainer;
use App\Entity\Keyword;
use App\Exception\KeywordException;
use Nelmio\ApiDocBundle\Annotation\Model;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

#[Route('/keyword', name: 'keyword_')]
class KeywordController extends ApiController
{
    /**
     * @throws ContainerExceptionInterface
     * @throws KeywordException
     * @throws NotFoundExceptionInterface
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
        response: Response::HTTP_BAD_REQUEST,
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
        KeywordProviderContainer $keywordProviderContainer
    ): JsonResponse
    {

        if (!in_array($source, KeywordProviderContainer::getAvailableKeywordProviders())) {
            KeywordException::invalidSource($source,KeywordProviderContainer::getAvailableKeywordProviders());
        }

        $keywordProvider = $keywordProviderContainer->get($source);
        return $this->getJsonResponse($keywordProvider->getKeyword($term), ['groups' => 'get_score']);

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