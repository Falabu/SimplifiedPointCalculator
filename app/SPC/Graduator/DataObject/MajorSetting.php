<?php

namespace App\SPC\Graduator\DataObject;

use App\SPC\DataObject\DataObject;

class MajorSetting extends DataObject
{
    public int $requiredPoint;
    public array $validators = [];

    public Classes $classes;
}
