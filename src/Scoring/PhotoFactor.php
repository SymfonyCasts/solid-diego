<?php

namespace App\Scoring;

use App\Entity\BigFootSighting;

class PhotoFactor implements ScoringFactorInterface
{
    public function score(BigFootSighting $sighting): int
    {
        if (empty($sighting->getImages())) {
            return 0;
        }

        // some image analysis code here

        return rand(0, 100) / 100;
    }
}
