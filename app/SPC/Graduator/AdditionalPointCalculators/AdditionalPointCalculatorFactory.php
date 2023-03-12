<?php

namespace App\SPC\Graduator\AdditionalPointCalculators;

class AdditionalPointCalculatorFactory implements IAdditionalPointCalculatorFactory
{
    public function create(string $category): IAdditionalPointCalculator
    {
        return match ($category) {
            'Nyelvvizsga' => new LanguagePointCalculator(),
            default => new NullPointCalculator()
        };
    }
}
