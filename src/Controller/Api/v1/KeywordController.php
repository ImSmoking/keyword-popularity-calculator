<?php

namespace App\Controller\Api\v1;

use App\Controller\Api\ApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/keyword', name: 'keyword_')]
class KeywordController extends ApiController
{
    #[Route('/score/{keyword}', name: 'score', methods: ['GET'])]
    public function scoreAction(): JsonResponse
    {
        return $this->getJsonResponse([
            "name" => "php",
            "score" => "3.47",
            "source" => "github",
            "searched_count" => 1
        ], ['groups' => 'get_score']);
    }
}