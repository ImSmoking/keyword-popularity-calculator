<?php

namespace App\Tests\Handler;

use App\Entity\Keyword;
use App\Handler\KeywordScoreHandler;
use PHPUnit\Framework\TestCase;

class KeywordScoreTest extends TestCase
{
    /**
     * Testing the logic for calculating Keyword score.
     */
    public function testCalculate(): void
    {
        $keywordScoreHandler = new KeywordScoreHandler();

        $keyword = (new Keyword())
            ->setHitsPositive(3306)
            ->setHitsNegative(6208);

        $keyword = $keywordScoreHandler->calculateScore($keyword);

        $this->assertSame('3.47', $keyword->getScore());
        $this->assertSame(9514, $keyword->getHitsTotal());
    }
}