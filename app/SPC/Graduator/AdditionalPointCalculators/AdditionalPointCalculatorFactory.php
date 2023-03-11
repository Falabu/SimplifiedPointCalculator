<?php

namespace App\SPC\Graduator\AdditionalPointCalculators;

use App\SPC\Graduator\Enum\AdditionalPointCategory;

class AdditionalPointCalculatorFactory
{
    public function create(AdditionalPointCategory $category): IAdditionalPointCalculator
    {
        return match ($category) {
            AdditionalPointCategory::NYELVVIZSGA => new LanguagePointCalculator(),
            default => new NullPointCalculator()
        };
    }
}
