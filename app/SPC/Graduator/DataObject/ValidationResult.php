<?php

namespace App\SPC\Graduator\DataObject;

use App\SPC\DataObject\DataObject;

class ValidationResult extends DataObject
{
    public bool $validated;
    public string $errorMessages;
}
