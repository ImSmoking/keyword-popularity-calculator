<?php

namespace App\Controller\Api\v1;

use App\Controller\Api\ApiController;
use App\Service\GithubKeywordProvider;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/keyword', name: 'keyword_')]
class KeywordController extends ApiController
{
    #[Route('/score/{term}', name: 'score', methods: ['GET'])]
    public function scoreAction(string $term, GithubKeywordProvider $gitHubKeywordScoreProvider): JsonResponse
    {
        $keyword = $gitHubKeywordScoreProvider->getKeyword($term);
        return $this->getJsonResponse($keyword, ['groups' => 'get_score']);
    }
}