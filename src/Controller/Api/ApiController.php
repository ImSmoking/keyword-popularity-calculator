<?php

namespace App\Controller\Api;

use App\Interface\ApiResponseObjectInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

class ApiController extends AbstractController
{
    private SerializerInterface $serializer;

    public function __construct(
        SerializerInterface $serializer,
    )
    {
        $this->serializer = $serializer;
    }

    protected function getJsonResponse(array|ApiResponseObjectInterface $content, array $context = [], int $status = 200): JsonResponse
    {
        if (is_object($content)) {
            $jsonContent = $this->serializer->serialize($content, 'json', $context);
            $arrayContent = json_decode($jsonContent, true);
        } else {
            $arrayContent = $content;
        }

        return new JsonResponse(['data' => $arrayContent], $status);
    }
}