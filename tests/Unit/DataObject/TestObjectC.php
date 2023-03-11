<?php

namespace Tests\Unit\DataObject;

use App\SPC\DataObject\DataObject;
use App\SPC\Graduator\Enum\ClassLevel;

class TestObjectC extends DataObject
{
    public ClassLevel $level;
}
