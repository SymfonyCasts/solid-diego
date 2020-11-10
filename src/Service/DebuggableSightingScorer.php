<?php

namespace App\Service;

use App\Entity\BigFootSighting;
use App\Model\BigfootSightingScore;
use App\Model\DebuggableBigfootSightingScore;

class DebuggableSightingScorer extends SightingScorer
{
    public function score(BigFootSighting $sighting): DebuggableBigfootSightingScore
    {
        $startTime = microtime(true);
        $bfsScore = parent::score($sighting);
        $calculationTime = microtime(true) - $startTime;

        return new DebuggableBigfootSightingScore($bfsScore->getScore(), $calculationTime);
    }
}
