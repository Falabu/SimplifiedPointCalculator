<?php

namespace App\SPC\Graduator\Validator;

interface IValidatorsFactory
{
    /**
     * @param string $major
     * @return array<IValidator>
     */
    public function create(string $major): array;
}
