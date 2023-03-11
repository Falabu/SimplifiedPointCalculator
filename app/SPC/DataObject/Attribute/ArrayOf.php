<?php

namespace App\SPC\DataObject\Attribute;

use Attribute;

#[Attribute]
class ArrayOf
{
    public const CLASS_STRING = 'classString';

    public string $classString;

    /**
     * @param class-string $classString
     */
    public function __construct(string $classString)
    {
        $this->classString = $classString;
    }
}
