<?php

declare(strict_types=1);
require __DIR__ . '/../vendor/autoload.php';

use App\SPC\GraduationParser\ArrayGraduationParser;
use App\SPC\Graduator\AdditionalPointCalculators\AdditionalPointCalculatorFactory;
use App\SPC\Graduator\GraduationPointCalculator\GraduationPointCalculator;
use App\SPC\Graduator\Graduator;
use App\SPC\Graduator\MajorSetting\MajorSetting;
use App\SPC\Graduator\Validator\ValidatorsFactory;


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

foreach ($evaluationGenerator as $evaluation) {
    echo PHP_EOL;
    if ($evaluation->passed) {
        echo "output: {$evaluation->points->total()} ({$evaluation->points->base} alappont + {$evaluation->points->additional} töbletpont)";
    } else {
        echo "output: $evaluation->message";
    }
}

echo PHP_EOL;
