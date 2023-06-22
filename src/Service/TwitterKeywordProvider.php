<?php

namespace App\Service;

use App\Constant\KeywordConstant;

class TwitterKeywordProvider extends AbstractKeywordProvider
{

    public function getSource(): string
    {
        return KeywordConstant::SOURCE_TWITTER;
    }

    public function getHitsRocks(string $term): int
    {
        return 4231;
    }

    public function getHitsSucks(string $term): int
    {
        return 5988;
    }
}