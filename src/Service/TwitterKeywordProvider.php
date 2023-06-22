<?php

namespace App\Service;

use App\Constant\KeywordConstant;

class TwitterKeywordProvider extends AbstractKeywordProvider
{

    public function getSource(): string
    {
        return KeywordConstant::SOURCE_TWITTER;
    }

    public function getHitsPositive(string $term): int
    {
        return 4231; // dummy data
    }

    public function getHitsNegative(string $term): int
    {
        return 5988; // dummy data
    }
}