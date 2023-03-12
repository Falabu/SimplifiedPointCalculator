<?php

namespace App\SPC\Graduator\AdditionalPointCalculators;

use App\SPC\DataObject\DataObject;
use App\SPC\Graduator\DataObject\Points;

interface IAdditionalPointCalculator
{
    /**
     * @param array<DataObject> $additionalPoints
     * @return Points
     */
    public function getPoints(array $additionalPoints): Points;
}
