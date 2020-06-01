<?php

namespace App\Tests\Service;

use App\Service\SightingScorer;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SightingScorerTest extends WebTestCase
{
    public function testIntegration_serviceIsConfiguredProperly()
    {
        self::bootKernel();

        $r = new \ReflectionClass(SightingScorer::class);
        $factorsProperty = $r->getProperty('scoringFactors');
        $factorsProperty->setAccessible(true);

        $sightingScorer = self::$container->get(SightingScorer::class);

        $this->assertCount(3, $factorsProperty->getValue($sightingScorer));
    }
}
