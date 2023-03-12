<?php

namespace Test\Unit\AdditionalPointCalculator;

use App\SPC\Graduator\AdditionalPointCalculators\AdditionalPointCalculatorFactory;
use App\SPC\Graduator\AdditionalPointCalculators\IAdditionalPointCalculator;
use App\SPC\Graduator\AdditionalPointCalculators\LanguagePointCalculator;
use App\SPC\Graduator\DataObject\LanguageResult;
use App\SPC\Graduator\Enum\AdditionalPointCategory;
use App\SPC\Graduator\GraduatorValue;
use PHPUnit\Framework\TestCase;

class AdditionalPointCalculatorTest extends TestCase
{
    public function testCanFactoryCreateCalculatorType()
    {
        $factory = new AdditionalPointCalculatorFactory();

        $calculator = $factory->create(AdditionalPointCategory::NYELVVIZSGA);

        $this->assertInstanceOf(IAdditionalPointCalculator::class, $calculator);
    }

    public function testLanguageCalculatorWithSameLanguageGetTheHigherScore()
    {
        $items = [
            LanguageResult::fromArray([
                'kategoria' => 'Nyelvvizsga',
                'tipus' => 'B2',
                'nyelv' => 'angol',
            ]),
            LanguageResult::fromArray([
                'kategoria' => 'Nyelvvizsga',
                'tipus' => 'C1',
                'nyelv' => 'angol',
            ]),
        ];

        $calculator = new LanguagePointCalculator();

        $points = $calculator->getPoints($items);
        $this->assertEquals(GraduatorValue::C1_POINT, $points->additional);
    }

    public function testLanguageCalculatorForMoreLanguage()
    {
        $items = [
            LanguageResult::fromArray([
                'kategoria' => 'Nyelvvizsga',
                'tipus' => 'B2',
                'nyelv' => 'angol',
            ]),
            LanguageResult::fromArray([
                'kategoria' => 'Nyelvvizsga',
                'tipus' => 'C1',
                'nyelv' => 'német',
            ]),
        ];

        $calculator = new LanguagePointCalculator();

        $points = $calculator->getPoints($items);
        $this->assertEquals(68, $points->additional);
    }

    public function testLanguageCalculatorForMoreLanguageWithOneLanguageWithDifferentExamLevel()
    {
        $items = [
            LanguageResult::fromArray([
                'kategoria' => 'Nyelvvizsga',
                'tipus' => 'B2',
                'nyelv' => 'angol',
            ]),
            LanguageResult::fromArray([
                'kategoria' => 'Nyelvvizsga',
                'tipus' => 'C1',
                'nyelv' => 'angol',
            ]),
            LanguageResult::fromArray([
                'kategoria' => 'Nyelvvizsga',
                'tipus' => 'C1',
                'nyelv' => 'német',
            ]),
        ];

        $calculator = new LanguagePointCalculator();

        $points = $calculator->getPoints($items);
        $this->assertEquals(80, $points->additional);
    }
}
