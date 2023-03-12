<?php

namespace App\SPC\Graduator\DataObject;

use App\SPC\DataObject\DataObject;

class Evaluation extends DataObject
{
    public bool $passed;

    public string $message;

    public Points $points;
    public Graduation $graduation;
}
