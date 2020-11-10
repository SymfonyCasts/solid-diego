<?php

namespace App\Model;

class DebuggableBigfootSightingScore extends BigfootSightingScore
{
    private $calculationTime;

    public function __construct(int $score, float $calculationTime)
    {
        parent::__construct($score);
        $this->calculationTime = $calculationTime;
    }

    public function getCalculationTime(): float
    {
        return $this->calculationTime;
    }
}
