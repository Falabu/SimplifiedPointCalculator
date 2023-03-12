<?php

namespace Test\Unit\GraduationPointCalculator;

use App\SPC\Graduator\DataObject\ClassResult;
use App\SPC\Graduator\GraduationPointCalculator\GraduationPointCalculator;
use PHPUnit\Framework\TestCase;

class GraduationPointCalculatorTest extends TestCase
{
    public function testGraduationCalculatorWithoutAdvancedExam()
    {
        $items = [
            ClassResult::fromArray([
                'nev' => 'informatika',
                'tipus' => 'közép',
                'eredmeny' => '60%',
            ]),
            ClassResult::fromArray([
                'nev' => 'angol nyelv',
                'tipus' => 'közép',
                'eredmeny' => '70%',
            ]),
            ClassResult::fromArray([
                'nev' => 'történelem',
                'tipus' => 'közép',
                'eredmeny' => '80%',
            ]),
        ];

        $graduationCalc = new GraduationPointCalculator();

        $points = $graduationCalc->getPoints($items);
        $this->assertEquals(210, $points->base);
    }

    public function testGraduationCalculatorWithAdvancedExam()
    {
        $items = [
            ClassResult::fromArray([
                'nev' => 'informatika',
                'tipus' => 'emelt',
                'eredmeny' => '60%',
            ]),
            ClassResult::fromArray([
                'nev' => 'angol nyelv',
                'tipus' => 'közép',
                'eredmeny' => '70%',
            ]),
            ClassResult::fromArray([
                'nev' => 'történelem',
                'tipus' => 'közép',
                'eredmeny' => '80%',
            ]),
        ];

        $graduationCalc = new GraduationPointCalculator();

        $points = $graduationCalc->getPoints($items);
        $this->assertEquals(210, $points->base);
        $this->assertEquals(50, $points->additional);
    }
}
