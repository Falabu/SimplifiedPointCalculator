<?php

namespace App\SPC\Graduator\AdditionalPointCalculators;

use App\SPC\Graduator\DataObject\LanguageResult;
use App\SPC\Graduator\Enum\LanguageExamPoint;
use App\SPC\Graduator\Enum\LanguageLevel;
use PHPUnit\Logging\Exception;

class LanguagePointCalculator implements IAdditionalPointCalculator
{
    /**
     * @param array<LanguageResult> $additionalPoints
     * @return int
     */
    public function getPoints(array $additionalPoints): int
    {
        $languagesToWeight = [];
        foreach ($additionalPoints as $additionalPoint) {
            if (!isset($languagesToWeight[$additionalPoint->nyelv])) {
                $languagesToWeight[$additionalPoint->nyelv] = 0;
            }

            $currentWeight = $this->getLevelWeight($additionalPoint->tipus);
            $previousWeight = $languagesToWeight[$additionalPoint->nyelv];
            if ($previousWeight > $currentWeight) {
                continue;
            }

            $languagesToWeight[$additionalPoint->nyelv] = $additionalPoint->tipus;
        }

        return array_reduce($languagesToWeight,
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
            LanguageLevel::B2 => LanguageExamPoint::B2->value,
            LanguageLevel::C1 => LanguageExamPoint::C1->value,
            default => 0
        };
    }
}
