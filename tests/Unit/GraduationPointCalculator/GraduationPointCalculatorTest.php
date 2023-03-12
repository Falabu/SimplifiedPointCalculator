<?php

namespace Test\Unit\GraduationPointCalculator;

use App\SPC\Graduator\DataObject\Classes;
use App\SPC\Graduator\DataObject\ClassResult;
use App\SPC\Graduator\GraduationPointCalculator\GraduationPointCalculator;
use PHPUnit\Framework\TestCase;

class GraduationPointCalculatorTest extends TestCase
{
    public function testGraduationCalculatorWithoutAdvancedExam()
    {
        $classes = Classes::fromArray([
            'required' => 'matematika',
            'chosen' => ['biológia', 'fizika', 'informatika', 'kémia']
        ]);

        $items = [
            ClassResult::fromArray([
                'nev' => 'magyar nyelv és irodalom',
                'tipus' => 'közép',
                'eredmeny' => '70%',
            ]),
            ClassResult::fromArray([
                'nev' => 'történelem',
                'tipus' => 'közép',
                'eredmeny' => '80%',
            ]),
            ClassResult::fromArray([
                'nev' => 'matematika',
                'tipus' => 'emelt',
                'eredmeny' => '90%',
            ]),
            ClassResult::fromArray([
                'nev' => 'angol nyelv',
                'tipus' => 'közép',
                'eredmeny' => '94%',
            ]),
            ClassResult::fromArray([
                'nev' => 'informatika',
                'tipus' => 'közép',
                'eredmeny' => '95%',
            ]),
        ];

        $graduationCalc = new GraduationPointCalculator();

        $points = $graduationCalc->get($items, $classes);
        $this->assertEquals(370, $points->base);
    }

    public function testGraduationCalculatorWithAdvancedExam()
    {
        $classes = Classes::fromArray([
            'required' => 'informatika',
            'chosen' => ['angol nyelv', 'történelem']
        ]);

        $items = [
            ClassResult::fromArray([
                'nev' => 'informatika',
                'tipus' => 'emelt',
                'eredmeny' => '100%',
            ]),
            ClassResult::fromArray([
                'nev' => 'angol nyelv',
                'tipus' => 'közép',
                'eredmeny' => '50%',
            ]),
            ClassResult::fromArray([
                'nev' => 'történelem',
                'tipus' => 'közép',
                'eredmeny' => '80%',
            ]),
            ClassResult::fromArray([
                'nev' => 'orosz',
                'tipus' => 'közép',
                'eredmeny' => '50%',
            ]),
        ];
        $graduationCalc = new GraduationPointCalculator();

        $points = $graduationCalc->get($items, $classes);
        $this->assertEquals(360, $points->base);
        $this->assertEquals(50, $points->additional);
    }
}
