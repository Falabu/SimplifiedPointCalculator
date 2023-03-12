<?php

namespace App\SPC\Graduator\AdditionalPointCalculators;

interface IAdditionalPointCalculatorFactory
{
    public function create(string $category): IAdditionalPointCalculator;
}
