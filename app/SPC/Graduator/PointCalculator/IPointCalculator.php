<?php

namespace SPC\Graduator\PointCalculator;

use SPC\Graduator\DataObject\Graduation;

interface IPointCalculator
{
    public function getPoints(Graduation $graduation): int;
}
