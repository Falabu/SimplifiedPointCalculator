<?php

namespace App\SPC\Graduator\Validator;

use App\SPC\Graduator\MajorSetting\IMajorSetting;

class ValidatorsFactory implements IValidatorsFactory
{
    private array $defaultValidators = [
        MinPointPerClassValidator::class => [20],
        HaveAllRequiredClass::class => [['magyar nyelv és irodalom', 'történelem', 'matematika']],
    ];

    public function __construct(private readonly IMajorSetting $majorSetting)
    {
    }

    public function create(string $major): array
    {
        $majorValidators = $this->majorSetting->get($major)?->validators ?? [];
        $validators = [...$this->defaultValidators, ...$majorValidators];

        $validators = array_map(function (string $validatorClass, array $properties) {
            if (!is_subclass_of($validatorClass, IValidator::class)) {
                return null;
            }

            return new $validatorClass(...$properties);
        }, array_keys($validators), $validators);

        return array_filter($validators, fn(null|IValidator $validator) => $validator !== null);
    }
}
