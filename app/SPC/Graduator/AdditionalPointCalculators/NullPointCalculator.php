<?php

namespace App\SPC\Graduator\AdditionalPointCalculators;

use App\SPC\Graduator\DataObject\LanguageResult;
use App\SPC\Graduator\DataObject\Points;

class NullPointCalculator implements IAdditionalPointCalculator
{
    /**
     * @param array<LanguageResult> $additionalPoints
     * @return int
     */
    public function getPoints(array $additionalPoints): Points
    {
        return Points::fromArray([]);
    }
}
