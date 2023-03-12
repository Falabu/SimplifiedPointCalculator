<?php

namespace Tests\Unit\Point;

use App\SPC\Graduator\DataObject\Points;
use PHPUnit\Framework\TestCase;

class PointTest extends TestCase
{
    public function testPointsHaveDefaultValues()
    {
        $point = Points::fromArray([]);

        $this->assertEquals(0, $point->base);
        $this->assertEquals(0, $point->additional);
    }

    public function testPointsCanBeAdded()
    {
        $pointA = Points::fromArray([
            'base' => 10,
            'additional' => 10,
        ]);

        $pointB = Points::fromArray([
            'base' => 20,
            'additional' => 30,
        ]);

        $newPoint = $pointA->add($pointB);

        $this->assertEquals(30, $newPoint->base);
        $this->assertEquals(40, $newPoint->additional);
    }
}
