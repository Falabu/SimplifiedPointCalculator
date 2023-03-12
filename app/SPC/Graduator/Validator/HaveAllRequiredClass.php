<?php

namespace App\SPC\Graduator\Validator;

use App\SPC\Graduator\DataObject\ClassResult;

class HaveAllRequiredClass implements IValidator
{
    public function __construct(private readonly array $requiredClasses)
    {
    }

    /**
     * @param array<ClassResult> $classResults
     * @return bool
     */
    public function validate(array $classResults): bool
    {
        $classes = array_map(fn(ClassResult $classResult) => $classResult->nev, $classResults);

        return count(array_diff($this->requiredClasses, $classes)) === 0;
    }

    public function errorMessage(): string
    {
        $imploded = implode(', ', $this->requiredClasses);
        return "You need all required classes: $imploded";
    }
}
