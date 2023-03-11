<?php

namespace SPC\Graduator;

use SPC\Graduator\Validator\IValidatorsFactory;

interface IGraduator
{
    /**
     * @param array<IGraduationPointCalculator> $pointCalculators
     * @param IValidatorsFactory $validatorFactory
     */
    public function __construct(array $pointCalculators, IValidatorsFactory $validatorFactory);

    /**
     * @param IGraduationsParser $graduationsParser
     * @return array<Evaluation>
     */
    public function getEvaluations(IGraduationsParser $graduationsParser): array;
}
