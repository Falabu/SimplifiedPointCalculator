<?php

declare(strict_types=1);

use App\SPC\GraduationParser\ArrayGraduationParser;
use App\SPC\Graduator\AdditionalPointCalculators\AdditionalPointCalculatorFactory;
use App\SPC\Graduator\GraduationPointCalculator\GraduationPointCalculator;
use App\SPC\Graduator\Graduator;
use App\SPC\Graduator\MajorSetting\MajorSetting;
use App\SPC\Graduator\Validator\ValidatorsFactory;

require __DIR__ . '/../vendor/autoload.php';

//Normally these are instantiated from the service container
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

$graduationsParser = new ArrayGraduationParser();
$evaluationGenerator = $graduator->getEvaluations($graduationsParser);

