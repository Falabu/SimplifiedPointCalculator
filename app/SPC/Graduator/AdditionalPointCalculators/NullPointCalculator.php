<?php

namespace App\SPC\Graduator\AdditionalPointCalculators;

use App\SPC\Graduator\DataObject\LanguageResult;

class NullPointCalculator implements IAdditionalPointCalculator
{
    /**
     * @param array<LanguageResult> $additionalPoints
     * @return int
     */
    public function getPoints(array $additionalPoints): int
    {
        return 0;
    }
}
