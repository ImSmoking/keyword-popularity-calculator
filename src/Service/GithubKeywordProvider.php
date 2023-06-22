<?php

namespace App\Service;

use App\Constant\KeywordConstant;

class GithubKeywordProvider extends AbstractKeywordProvider
{

    public function getSource(): string
    {
        return KeywordConstant::SOURCE_GITHUB;
    }

    public function getHitsRocks(string $term): int
    {
        return 3306;
    }

    public function getHitsSucks(string $term): int
    {
        return 6208;
    }
}