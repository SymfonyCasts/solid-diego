<?php

namespace App\Scoring;

use App\Entity\BigFootSighting;

class CoordinatesFactor implements ScoringFactorInterface
{
    public function score(BigFootSighting $sighting): int
    {
        $score = 0;
        $lat = (float)$sighting->getLatitude();
        $lng = (float)$sighting->getLongitude();

        // California edge to edge coordinates
        // It works like if the state has a rectangle shape
        if (true
            && $lat >= 32.5121 && $lat <= 42.0126
            && $lng >= -124.6509 && $lng <= -114.1315
        ) {
            $score += 30;
        }

        return $score;
    }
}
