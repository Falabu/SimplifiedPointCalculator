<?php

namespace App\SPC\Graduator\PointCalculator;

use App\SPC\Graduator\DataObject\ClassResult;

interface IGraduationPointCalculator
{
    /**
     * @param array<ClassResult> $classResults
     * @return int
     */
    public function getPoints(array $classResults): int;
}
