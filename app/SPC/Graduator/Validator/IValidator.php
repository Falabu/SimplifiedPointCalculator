<?php

namespace SPC\Graduator\Validator;

use SPC\Graduator\DataObject\Graduation;

interface IValidator
{
    public function validate(Graduation $graduation): bool;
}
