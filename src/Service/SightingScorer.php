<?php

namespace App\Service;

use App\Entity\BigFootSighting;
use App\Scoring\ScoringFactorInterface;

class SightingScorer
{
    /**
     * @var ScoringFactorInterface[]
     */
    private $scoringFactors;

    public function __construct(iterable $scoringFactors)
    {
        $this->scoringFactors = $scoringFactors;
    }

    public function score(BigFootSighting $sighting): int
    {
        $score = 0;
        /** @var ScoringFactorInterface $scoringFactor */
        foreach ($this->scoringFactors as $scoringFactor) {
            $score += $scoringFactor->score($sighting);
        }

        return $score;
    }
}
