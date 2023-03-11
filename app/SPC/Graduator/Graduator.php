<?php

namespace SPC\Graduator;

use SPC\GraduationParser\IGraduationsParser;
use SPC\Graduator\Validator\IValidatorsFactory;

class Graduator implements IGraduator
{
    public function __construct(array $pointCalculators, IValidatorsFactory $validatorFactory)
    {
    }

    public function getEvaluations(IGraduationsParser $graduationsParser): array
    {
        // TODO: Implement getEvaluations() method.
    }
}
