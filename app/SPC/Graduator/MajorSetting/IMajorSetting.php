<?php

namespace App\SPC\Graduator\MajorSetting;

use App\SPC\Graduator\DataObject\MajorSetting;
use Exception;

interface IMajorSetting
{
    /**
     * @param string $major
     * @return MajorSetting
     * @throws Exception
     */
    public function get(string $major): MajorSetting;
}
