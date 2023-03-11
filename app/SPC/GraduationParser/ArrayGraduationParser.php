<?php

namespace App\SPC\GraduationParser;

use App\SPC\Graduator\DataObject\Graduation;
use Generator;

class ArrayGraduationParser implements IGraduationsParser
{
    /**
     * @return Generator|array<Graduation>
     */
    public function parse(array $args): Generator
    {
        foreach ($args as $arg) {
            yield Graduation::fromArray($arg);
        }
    }
}
