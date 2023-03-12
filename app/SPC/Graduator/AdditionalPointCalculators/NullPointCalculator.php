<?php

namespace App\SPC\Graduator\AdditionalPointCalculators;

use App\SPC\Graduator\DataObject\Points;

class NullPointCalculator implements IAdditionalPointCalculator
{
    /**
     * @param array $additionalPoints
     * @return Points
     */
    public function getPoints(array $additionalPoints): Points
    {
        return Points::fromArray([]);
    }
}
