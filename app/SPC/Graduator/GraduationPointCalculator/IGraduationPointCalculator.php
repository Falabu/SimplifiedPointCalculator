<?php

namespace App\SPC\Graduator\GraduationPointCalculator;

use App\SPC\Graduator\DataObject\ClassResult;
use App\SPC\Graduator\DataObject\Points;

interface IGraduationPointCalculator
{
    /**
     * @param array<ClassResult> $classResults
     * @return int
     */
    public function getPoints(array $classResults): Points;
}
