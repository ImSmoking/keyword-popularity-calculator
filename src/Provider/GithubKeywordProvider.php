<?php

namespace App\Provider;

use App\Constant\KeywordConstant;
use App\Handler\KeywordScoreHandler;
use App\Repository\KeywordRepository;
use Github\Client as GithubClient;
use Symfony\Component\HttpClient\HttplugClient;

class GithubKeywordProvider extends AbstractKeywordProvider
{
    private GithubClient $githubClient;

    public function __construct(
        KeywordRepository   $keywordRepository,
        KeywordScoreHandler $keywordScoreHandler,
    )
    {
        $this->githubClient = GithubClient::createWithHttpClient(new HttplugClient());

        parent::__construct(
            $keywordRepository,
            $keywordScoreHandler
        );
    }

    public function getSource(): string
    {
        return KeywordConstant::SOURCE_GITHUB;
    }

    public function getHitsPositive(string $term): int
    {
        $response = $this->githubClient->api('search')->issues($term . ' ' . self::POSITIVE_CONTEXT);
        return $response['total_count'];
    }

    public function getHitsNegative(string $term): int
    {
        $response = $this->githubClient->api('search')->issues($term . ' ' . self::NEGATIVE_CONTEXT);
        return $response['total_count'];
    }
}