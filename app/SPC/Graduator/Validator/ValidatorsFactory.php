<?php

namespace App\SPC\Graduator\Validator;

use App\SPC\Graduator\Enum\ClassLevel;

class ValidatorsFactory implements IValidatorsFactory
{
    private array $defaultValidators = [
        MinPointPerClassValidator::class => [
            20
        ]
    ];

    private array $bluePrintsPerMajor = [
        'Programtervező informatikus' => [
            HaveRequiredChosenClass::class => [['biológia', 'fizika', 'informatika', 'kémia']],
            HaveRequiredClassValidator::class => ['matematika']
        ],
        'Anglisztika' => [
            HaveRequiredChosenClass::class => [['francia', 'német', 'olasz', 'orosz', 'spanyol', 'történelem']],
            HaveRequiredClassValidator::class => ['angol', ClassLevel::EMELT]
        ]
    ];

    public function create(string $major): array
    {
        $majorValidators = $this->bluePrintsPerMajor[$major] ?? [];

        $validators = [...$this->defaultValidators, ...$majorValidators];
        return array_map(function (string $validatorClass, array $properties) {
            if (!is_subclass_of($validatorClass, IValidator::class)) {
                return false;
            }

            return new $validatorClass(...$properties);
        }, array_keys($validators), $validators);
    }
}
