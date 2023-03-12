<?php

namespace Tests\Integration;

use App\SPC\GraduationParser\ArrayGraduationParser;
use App\SPC\Graduator\AdditionalPointCalculators\AdditionalPointCalculatorFactory;
use App\SPC\Graduator\DataObject\Evaluation;
use App\SPC\Graduator\GraduationPointCalculator\GraduationPointCalculator;
use App\SPC\Graduator\Graduator;
use App\SPC\Graduator\MajorSetting\MajorSetting;
use App\SPC\Graduator\TestData;
use App\SPC\Graduator\Validator\ValidatorsFactory;
use PHPUnit\Framework\TestCase;

class GraduatorTest extends TestCase
{
    public function testGraduatorCanEvaluateData()
    {
        $majorSetting = new MajorSetting();
        $validatorFactory = new ValidatorsFactory($majorSetting);
        $graduationPointCalculator = new GraduationPointCalculator();
        $additionalPointFactory = new AdditionalPointCalculatorFactory();

        $graduator = new Graduator(
            $graduationPointCalculator,
            $additionalPointFactory,
            $validatorFactory,
            $majorSetting
        );

        $evaluations = $graduator->getEvaluations(new ArrayGraduationParser());

        $expectedResult = TestData::getExpectedResult();
        foreach ($evaluations as $index => $evaluation) {
            $result = $expectedResult[$index];
            $this->assertInstanceOf(Evaluation::class, $evaluation);

            $this->assertEquals($result->points->base, $evaluation->points->base);
            $this->assertEquals($result->points->additional, $evaluation->points->additional);
            $this->assertEquals($result->passed, $evaluation->passed);
        }
    }
}
