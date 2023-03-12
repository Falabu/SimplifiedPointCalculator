<?php

namespace App\SPC\Graduator\Validator;

use App\SPC\Util\GraduatorUtil;
use Exception;

class MinPointPerClassValidator implements IValidator
{
    public function __construct(private readonly int $minPoints)
    {
    }

    /**
     * @param array $classResults
     * @return bool
     * @throws Exception
     */
    public function validate(array $classResults): bool
    {
        foreach ($classResults as $classResult) {
            $result = GraduatorUtil::getResultFromPercent($classResult->eredmeny);
            if ($result < $this->minPoints) {
                return false;
            }
        }

        return true;
    }

    public function errorMessage(): string
    {
        return 'not';
    }
}
