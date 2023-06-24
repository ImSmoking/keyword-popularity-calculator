<?php

namespace App\Handler;

use App\Entity\Keyword;

class KeywordScoreHandler
{

    public function calculateScore(Keyword $keyword): Keyword
    {
        $hitsTotal = $keyword->getHitsPositive() + $keyword->getHitsNegative();

        if ($hitsTotal === 0) {
            $score = 0;
        } else {
            // formula: score = (hitsPositive / hitsNegative) * 10
            $score = round($keyword->getHitsPositive() / $hitsTotal, 3) * 10;
        }

        $keyword->setScore($score);
        $keyword->setHitsTotal($hitsTotal);

        return $keyword;
    }
}