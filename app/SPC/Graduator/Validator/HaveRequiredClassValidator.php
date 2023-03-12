<?php

namespace App\SPC\Graduator\Validator;

use App\SPC\Graduator\DataObject\ClassResult;
use App\SPC\Graduator\Enum\ClassLevel;

class HaveRequiredClassValidator implements IValidator
{
    public function __construct(
        private readonly string $requiredClass,
        private readonly ClassLevel $requiredLevel = ClassLevel::KOZEP
    ) {
    }

    /**
     * @param array<ClassResult> $classResults
     * @return bool
     */
    public function validate(array $classResults): bool
    {
        $classesWithLevel = $this->getClassToLevelMap($classResults);
        if (!isset($classesWithLevel[$this->requiredClass])) {
            return false;
        }

        $requiredLevelWeight = $this->getLevelWeight($this->requiredLevel);
        $classLevelWeight = $this->getLevelWeight($classesWithLevel[$this->requiredClass]);

        return $classLevelWeight >= $requiredLevelWeight;
    }

    public function errorMessage(): string
    {
        return 'not';
    }

    private function getLevelWeight(ClassLevel $level): int
    {
        return match ($level) {
            ClassLevel::KOZEP => 10,
            ClassLevel::EMELT => 20,
            default => 0
        };
    }

    /**
     * @param array $classResults
     * @return mixed
     */
    private function getClassToLevelMap(array $classResults): mixed
    {
        return array_reduce(
            $classResults,
            function (array $result, ClassResult $classResult) {
                $result[$classResult->nev] = $classResult->tipus;
                return $result;
            },
            []
        );
    }
}
