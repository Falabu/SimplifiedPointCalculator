<?php

namespace App\SPC\Graduator\DataObject;

use App\SPC\DataObject\DataObject;

class Points extends DataObject
{
    public int $base = 0;
    public int $additional = 0;
}
