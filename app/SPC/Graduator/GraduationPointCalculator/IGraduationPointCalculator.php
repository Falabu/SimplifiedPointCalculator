<?php

namespace App\SPC\Graduator\GraduationPointCalculator;

use App\SPC\Graduator\DataObject\Classes;
use App\SPC\Graduator\DataObject\ClassResult;
use App\SPC\Graduator\DataObject\Points;

interface IGraduationPointCalculator
{
    /**
     * @param array<ClassResult> $classResults
     * @param Classes $classes
     * @return Points
     */
    public function getPoints(array $classResults, Classes $classes): Points;
}
