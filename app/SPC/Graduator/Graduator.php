<?php

namespace App\SPC\Graduator;

use App\SPC\GraduationParser\IGraduationsParser;
use App\SPC\Graduator\AdditionalPointCalculators\IAdditionalPointCalculatorFactory;
use App\SPC\Graduator\DataObject\Evaluation;
use App\SPC\Graduator\DataObject\Graduation;
use App\SPC\Graduator\DataObject\MajorSetting;
use App\SPC\Graduator\DataObject\Points;
use App\SPC\Graduator\DataObject\ValidationResult;
use App\SPC\Graduator\GraduationPointCalculator\IGraduationPointCalculator;
use App\SPC\Graduator\MajorSetting\IMajorSetting;
use App\SPC\Graduator\Validator\IValidatorsFactory;
use Exception;
use Generator;

class Graduator implements IGraduator
{
    public function __construct(
        private readonly IGraduationPointCalculator $graduationPointCalculator,
        private readonly IAdditionalPointCalculatorFactory $additionalPointCalculatorFactory,
        private readonly IValidatorsFactory $validatorsFactory,
        private readonly IMajorSetting $majorSetting,
    ) {
    }

    /**
     * @param IGraduationsParser $graduationsParser
     * @return Generator
     * @throws Exception
     */
    public function getEvaluations(IGraduationsParser $graduationsParser): Generator
    {
        foreach ($graduationsParser->parse() as $graduation) {
            $evaluation = Evaluation::fromArray([
                'passed' => false,
                'graduation' => $graduation,
                'points' => Points::fromArray([])
            ]);

            $validationResult = $this->validate($graduation);
            if (!$validationResult->validated) {
                $evaluation->message = $validationResult->errorMessage;

                yield $evaluation;
                continue;
            }

            $settings = $this->majorSetting->get($graduation->valasztottSzak->szak);
            $allPoints = $this->getAllPoints($graduation, $settings);

            $scoreReached = $allPoints->total() >= $settings->requiredPoint;
            if (!$scoreReached) {
                $evaluation->message = 'Minimum score not reached!';
            }

            $evaluation->passed = $scoreReached;
            $evaluation->points = $allPoints;

            yield $evaluation;
        }
    }

    /**
     * @param mixed $graduation
     * @param MajorSetting $settings
     * @return Points
     */
    private function getAllPoints(mixed $graduation, MajorSetting $settings): Points
    {
        $graduationPoints = $this->graduationPointCalculator
            ->get($graduation->erettsegiEredmenyek, $settings->classes);

        $additionalPoints = $this->getAdditionalPoints($graduation);

        return $this->calculatePoints([$graduationPoints, $additionalPoints]);
    }

    /**
     * @param array<Points> $points
     * @return Points
     */
    private function calculatePoints(array $points): Points
    {
        $newPoints = Points::fromArray([]);

        foreach ($points as $point) {
            $newPoints = $newPoints->add($point);
        }

        $newPoints->additional = min($newPoints->additional, GraduatorValue::MAX_ADDITIONAL_POINTS);
        return $newPoints;
    }

    /**
     * @param Graduation $graduation
     * @return ValidationResult
     */
    private function validate(Graduation $graduation): ValidationResult
    {
        $validators = $this->validatorsFactory->create($graduation->valasztottSzak->szak);
        $validationResult = ValidationResult::fromArray([]);

        foreach ($validators as $validator) {
            /**
             * @psalm-suppress RedundantCondition
             */
            if (isset($validationResult->validated) && $validationResult->validated === false) {
                return $validationResult;
            }

            $validationResult->validated = $validator->validate($graduation->erettsegiEredmenyek);
            if (!$validationResult->validated) {
                $validationResult->errorMessage = $validator->errorMessage();
            }
        }

        return $validationResult;
    }

    /**
     * @param Graduation $graduation
     * @return Points
     */
    private function getAdditionalPoints(Graduation $graduation): Points
    {
        $additionalPointsPerCategory = [];
        foreach ($graduation->tobbletpontok as $additionalPoint) {
            $additionalPointsPerCategory[$additionalPoint->kategoria][] = $additionalPoint;
        }

        $finalPoints = Points::fromArray([]);
        foreach ($additionalPointsPerCategory as $category => $additionalPoints) {
            $pointCalculator = $this->additionalPointCalculatorFactory->create($category);
            $currentPoints = $pointCalculator->getPoints($additionalPoints);

            $finalPoints = $finalPoints->add($currentPoints);
        }

        return $finalPoints;
    }
}
