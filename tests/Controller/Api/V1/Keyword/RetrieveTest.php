<?php

namespace App\Tests\Controller\Api\V1\Keyword;

use App\Tests\Controller\Api\ApiTestCase;
use Symfony\Component\HttpFoundation\Response;

class RetrieveTest extends ApiTestCase
{
    private const ENDPOINT_URI = '/api/v1/keyword/score/{source}/{term}';

    public function testSuccess(): void
    {
        $endpoint = str_replace('{source}', 'github', self::ENDPOINT_URI);
        $endpoint = str_replace('{term}', 'php', $endpoint);

        $this->client->request('GET', $endpoint);
        $response = $this->client->getResponse();

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('data', $content);
        $this->assertArrayHasKey('term', $content['data']);
        $this->assertArrayHasKey('score', $content['data']);
    }

    public function testInvalidSource(): void
    {
        $endpoint = str_replace('{source}', 'blabla', self::ENDPOINT_URI);
        $endpoint = str_replace('{term}', 'php', $endpoint);

        $this->client->request('GET', $endpoint);
        $response = $this->client->getResponse();

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('data', $content);
        $this->assertArrayHasKey('message', $content['data']);
    }
}