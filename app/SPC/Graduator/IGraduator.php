<?php

namespace SPC\Graduator;

use SPC\GraduationParser\IGraduationsParser;
use SPC\Graduator\DataObject\Evaluation;
use SPC\Graduator\PointCalculator\IPointCalculator;
use SPC\Graduator\Validator\IValidatorsFactory;

interface IGraduator
{
    /**
     * @param array<IPointCalculator> $pointCalculators
     * @param IValidatorsFactory $validatorFactory
     */
    public function __construct(array $pointCalculators, IValidatorsFactory $validatorFactory);

    /**
     * @param IGraduationsParser $graduationsParser
     * @return array<Evaluation>
     */
    public function getEvaluations(IGraduationsParser $graduationsParser): array;
}
