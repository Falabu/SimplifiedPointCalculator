<?php

namespace App\SPC\Graduator\GraduationPointCalculator;

use App\SPC\Graduator\Enum\ClassLevel;
use App\SPC\Graduator\GraduatorValue;
use App\SPC\Util\GraduatorUtil;
use Exception;

class GraduationPointCalculator implements IGraduationPointCalculator
{
    /**
     * @param array $classResults
     * @return int
     * @throws Exception
     */
    public function getPoints(array $classResults): int
    {
        $points = 0;
        foreach ($classResults as $classResult) {
            $result = GraduatorUtil::getResultFromPercent($classResult->eredmeny);

            if ($classResult->tipus === ClassLevel::EMELT) {
                $points += GraduatorValue::ADVANCED_POINT;
            }

            $points += $result;
        }

        return $points;
    }
}
