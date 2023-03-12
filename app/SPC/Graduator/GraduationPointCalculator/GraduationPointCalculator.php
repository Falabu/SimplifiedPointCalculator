<?php

namespace App\SPC\Graduator\GraduationPointCalculator;

use App\SPC\Graduator\DataObject\Classes;
use App\SPC\Graduator\DataObject\ClassResult;
use App\SPC\Graduator\DataObject\Points;
use App\SPC\Graduator\Enum\ClassLevel;
use App\SPC\Graduator\GraduatorValue;
use App\SPC\Util\GraduatorUtil;
use Exception;

class GraduationPointCalculator implements IGraduationPointCalculator
{
    /**
     * @param array<ClassResult> $classResults
     * @param Classes $classes
     * @return Points
     * @throws Exception
     */
    public function getPoints(array $classResults, Classes $classes): Points
    {
        $points = new Points();
        $chosenClassPoint = 0;
        foreach ($classResults as $classResult) {
            if ($classResult->tipus === ClassLevel::EMELT) {
                $points->additional += GraduatorValue::ADVANCED_POINT;
            }

            $result = GraduatorUtil::getResultFromPercent($classResult->eredmeny) * GraduatorValue::POINT_MULTIPLIER;
            if ($classResult->nev === $classes->required) {
                $points->base = $result;
            }

            if ($result > $chosenClassPoint && in_array($classResult->nev, $classes->chosen)) {
                $chosenClassPoint = $result;
            }
        }

        $points->base += $chosenClassPoint;
        return $points;
    }
}
