<?php

namespace App\SPC\Graduator\MajorSetting;

use App\SPC\Graduator\DataObject\Classes;
use App\SPC\Graduator\DataObject\MajorSetting as MajorSettingData;
use App\SPC\Graduator\Enum\ClassLevel;
use App\SPC\Graduator\Validator\HaveRequiredChosenClass;
use App\SPC\Graduator\Validator\HaveRequiredClassValidator;
use Exception;

/**
 * These setting should come from other source (DB?)
 */
class MajorSetting implements IMajorSetting
{
    /**
     * @param string $major
     * @return MajorSettingData
     * @throws Exception
     */
    public function get(string $major): MajorSettingData
    {
        return $this->settings()[$major] ?? throw new Exception("No settings for $major");
    }

    /**
     * @return array<string, MajorSettingData>
     */
    private function settings(): array
    {
        return [
            'Anglisztika' => MajorSettingData::fromArray([
                'requiredPoint' => 400,
                'validators' => [
                    HaveRequiredChosenClass::class => [
                        $this->getClassesForMajor('Anglisztika')->chosen
                    ],
                    HaveRequiredClassValidator::class => [
                        $this->getClassesForMajor('Anglisztika')->required,
                        ClassLevel::EMELT
                    ]
                ],
                'classes' => $this->getClassesForMajor('Anglisztika')
            ]),
            'Programtervező informatikus' => MajorSettingData::fromArray([
                'requiredPoint' => 400,
                'validators' => [
                    HaveRequiredChosenClass::class => [
                        $this->getClassesForMajor('Programtervező informatikus')->chosen
                    ],
                    HaveRequiredClassValidator::class => [
                        $this->getClassesForMajor('Programtervező informatikus')->required,
                        ClassLevel::EMELT
                    ]
                ],
                'classes' => $this->getClassesForMajor('Programtervező informatikus')
            ]),
        ];
    }

    private function getClassesForMajor(string $major): Classes
    {
        $classes = [
            'Programtervező informatikus' => Classes::fromArray([
                'required' => 'matematika',
                'chosen' => ['biológia', 'fizika', 'informatika', 'kémia'],
            ]),
            'Anglisztika' => Classes::fromArray([
                'required' => 'matematika',
                'chosen' => ['francia', 'német', 'olasz', 'orosz', 'spanyol', 'történelem'],
            ]),
        ];

        return $classes[$major] ?? Classes::fromArray([]);
    }
}
