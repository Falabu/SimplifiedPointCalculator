<?php

namespace App\SPC\Graduator\Validator;

use App\SPC\Graduator\DataObject\ClassResult;
use phpDocumentor\Reflection\Types\This;

class HaveRequiredChosenClass implements IValidator
{
    public function __construct(private readonly array $validClasses)
    {
    }

    /**
     * @param array<ClassResult> $classResults
     * @return bool
     */
    public function validate(array $classResults): bool
    {
        $classes = array_map(fn(ClassResult $classResult) => $classResult->nev, $classResults);

        $intersect = array_intersect($this->validClasses, $classes);
        return count($intersect) > 0;
    }

    public function errorMessage(): string
    {
        return 'not';
    }
}
