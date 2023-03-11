<?php

namespace App\SPC\Graduator\DataObject;

use App\SPC\DataObject\DataObject;
use App\SPC\Graduator\Enum\ClassLevel;

class ClassResult extends DataObject
{
    public string $nev;
    public ClassLevel $tipus;
    public string $eredmeny;
}
