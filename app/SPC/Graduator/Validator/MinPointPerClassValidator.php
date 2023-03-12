<?php

namespace App\SPC\Graduator\Validator;

use App\SPC\Graduator\DataObject\ClassResult;
use App\SPC\Util\GraduatorUtil;
use Exception;

class MinPointPerClassValidator implements IValidator
{
    private string $invalidClass = '';

    public function __construct(private readonly int $minPoints)
    {
    }

    /**
     * @param array<ClassResult> $classResults
     * @return bool
     * @throws Exception
     */
    public function validate(array $classResults): bool
    {
        foreach ($classResults as $classResult) {
            $result = GraduatorUtil::getResultFromPercent($classResult->eredmeny);
            if ($result < $this->minPoints) {
                $this->invalidClass = $classResult->nev;
                return false;
            }
        }

        return true;
    }

    public function errorMessage(): string
    {
        return "$this->invalidClass not reached $this->minPoints%!";
    }
}
