<?php

namespace App\SPC\GraduationParser;

use App\SPC\Graduator\DataObject\Graduation;
use App\SPC\Graduator\TestData;
use Generator;

class ArrayGraduationParser implements IGraduationsParser
{
    /**
     * @return Generator
     */
    public function parse(): Generator
    {
        foreach (TestData::$graduations as $graduation) {
            yield Graduation::fromArray($graduation);
        }
    }
}
