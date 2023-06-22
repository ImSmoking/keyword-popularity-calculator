<?php

namespace App\Handler;

use App\Entity\Keyword;

class KeywordScoreHandler
{

    public function calculateScore(Keyword $keyword): Keyword
    {
        // formula: score = (hitsPositive / hitsNegative) * 10
        $hitsTotal = $keyword->getHitsPositive() + $keyword->getHitsNegative();
        $score = round($keyword->getHitsPositive() / $hitsTotal, 3) * 10;

        $keyword->setScore($score);
        $keyword->setHitsTotal($hitsTotal);

        return $keyword;
    }
}