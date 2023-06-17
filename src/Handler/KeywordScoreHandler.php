<?php

namespace App\Handler;

use App\Entity\Keyword;

class KeywordScoreHandler
{

    public function calculateScore(Keyword $keyword): Keyword
    {
        // formula: score = (hitsRocks / hitsTotal) * 10
        $hitsTotal = $keyword->getSucksCount() + $keyword->getRocksCount();
        $score = round($keyword->getRocksCount() / $hitsTotal, 3) * 10;

        $keyword->setScore($score);
        $keyword->setTotalCount($hitsTotal);

        return $keyword;
    }
}