<?php

namespace App\Scoring;

use App\Entity\BigFootSighting;

class PhotoFactor implements ScoringFactorInterface
{

    public function score(BigFootSighting $sighting): int
    {
        if (empty($sighting->getImages())) {
            throw new \RuntimeException('Invalid BigFootSighting, it should have at least one photo');
        }

        // some image analysis code here

        return rand(0, 100) / 100;
    }
}
