<?php

namespace App\SPC\Graduator\GraduationPointCalculator;

use App\SPC\Graduator\DataObject\Points;
use App\SPC\Graduator\Enum\ClassLevel;
use App\SPC\Graduator\GraduatorValue;
use App\SPC\Util\GraduatorUtil;
use Exception;

class GraduationPointCalculator implements IGraduationPointCalculator
{
    /**
     * @param array $classResults
     * @return Points
     * @throws Exception
     */
    public function getPoints(array $classResults): Points
    {
        $points = new Points();
        foreach ($classResults as $classResult) {
            $result = GraduatorUtil::getResultFromPercent($classResult->eredmeny);

            if ($classResult->tipus === ClassLevel::EMELT) {
                $points->additional += GraduatorValue::ADVANCED_POINT;
            }

            $points->base += $result;
        }

        return $points;
    }
}
