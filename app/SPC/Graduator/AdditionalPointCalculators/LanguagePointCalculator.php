<?php

namespace App\SPC\Graduator\AdditionalPointCalculators;

use App\SPC\Graduator\DataObject\LanguageResult;
use App\SPC\Graduator\Enum\LanguageLevel;
use App\SPC\Graduator\GraduatorValue;
use PHPUnit\Logging\Exception;

class LanguagePointCalculator implements IAdditionalPointCalculator
{
    /**
     * @param array<LanguageResult> $additionalPoints
     * @return int
     */
    public function getPoints(array $additionalPoints): int
    {
        $examToWeight = [];
        foreach ($additionalPoints as $additionalPoint) {
            if (!isset($examToWeight[$additionalPoint->nyelv])) {
                $examToWeight[$additionalPoint->nyelv] = 0;
            }

            $currentWeight = $this->getLevelWeight($additionalPoint->tipus);
            $previousWeight = $examToWeight[$additionalPoint->nyelv];
            if ($previousWeight > $currentWeight) {
                continue;
            }

            $examToWeight[$additionalPoint->nyelv] = $additionalPoint->tipus;
        }

        return array_reduce($examToWeight,
            fn(int $sum, LanguageLevel $level) => $sum + $this->getLevelPoint($level), 0);
    }

    private function getLevelWeight(LanguageLevel $level): int
    {
        return match ($level) {
            LanguageLevel::A1 => 10,
            LanguageLevel::A2 => 20,
            LanguageLevel::B1 => 30,
            LanguageLevel::B2 => 40,
            LanguageLevel::C1 => 50,
            LanguageLevel::C2 => 60,
            default => throw new Exception("No weight specified for $level->value")
        };
    }

    private function getLevelPoint(LanguageLevel $level): int
    {
        return match ($level) {
            LanguageLevel::B2 => GraduatorValue::B2_POINT,
            LanguageLevel::C1 => GraduatorValue::C1_POINT,
            default => 0
        };
    }
}
