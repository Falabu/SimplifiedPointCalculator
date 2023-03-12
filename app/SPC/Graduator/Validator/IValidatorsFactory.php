<?php

namespace App\SPC\Graduator\Validator;

use App\SPC\Graduator\MajorSetting\IMajorSetting;

interface IValidatorsFactory
{

    /**
     * @param string $major
     * @return array<IValidator>
     */
    public function create(string $major): array;
}
