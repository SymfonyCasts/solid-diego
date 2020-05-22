<?php

namespace App\Scoring;

use App\Entity\BigFootSighting;

class DescriptionFactor implements ScoringFactorInterface
{
    public function score(BigFootSighting $sighting): int
    {
        $score = 0;
        $title = strtolower($sighting->getTitle());

        if (strpos($title, 'hairy') !== false) {
            $score += 10;
        }

        if (strpos($title, 'chased me') !== false) {
            $score += 20;
        }

        if (strpos($title, 'using an Iphone') !== false) {
            $score -= 50;
        }

        return $score;
    }
}
