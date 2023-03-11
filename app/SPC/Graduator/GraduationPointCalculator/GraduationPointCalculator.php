<?php

namespace App\SPC\Graduator\GraduationPointCalculator;

use App\SPC\Graduator\DataObject\ClassResult;
use App\SPC\Graduator\Enum\ClassLevel;
use App\SPC\Graduator\GraduatorValue;

class GraduationPointCalculator implements IGraduationPointCalculator
{
    /**
     * @param array<ClassResult> $classResults
     * @return int
     */
    public function getPoints(array $classResults): int
    {
        $points = 0;
        foreach ($classResults as $classResult) {
            preg_match('/\d+(?=\s*%)/', $classResult->eredmeny, $matches);
            if (!isset($matches[0])) {
                continue;
            }

            if ($classResult->tipus === ClassLevel::EMELT) {
                $points += GraduatorValue::ADVANCED_POINT;
            }

            $points += (int)$matches[0];
        }

        return $points;
    }
}
