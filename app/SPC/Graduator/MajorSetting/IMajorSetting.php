<?php

namespace App\SPC\Graduator\MajorSetting;

use App\SPC\Graduator\DataObject\MajorSetting;

interface IMajorSetting
{
    public function get(string $major): ?MajorSetting;
}
