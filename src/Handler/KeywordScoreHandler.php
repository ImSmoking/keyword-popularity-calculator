<?php

namespace App\Handler;

use App\Entity\Keyword;

class KeywordScoreHandler
{

    public function calculateScore(Keyword $keyword): Keyword
    {
        // formula: score = (hitsRocks / hitsTotal) * 10
        $hitsTotal = $keyword->getHitsSucks() + $keyword->getHitsRocks();
        $score = round($keyword->getHitsRocks() / $hitsTotal, 3) * 10;

        $keyword->setScore($score);
        $keyword->setHitsTotal($hitsTotal);

        return $keyword;
    }
}