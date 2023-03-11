<?php

namespace App\SPC\Graduator\AdditionalPointCalculators;

use App\SPC\DataObject\DataObject;

interface IAdditionalPointCalculator
{
    /**
     * @param array<DataObject> $additionalPoints
     * @return int
     */
    public function getPoints(array $additionalPoints): int;
}
