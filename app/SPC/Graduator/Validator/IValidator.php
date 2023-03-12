<?php

namespace App\SPC\Graduator\Validator;

use App\SPC\Graduator\DataObject\ClassResult;

interface IValidator
{
    /**
     * @param array<ClassResult> $classResults
     * @return bool
     */
    public function validate(array $classResults): bool;

    public function errorMessage(): string;
}
