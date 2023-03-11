<?php

namespace SPC\GraduationParser;

use Generator;
use SPC\Graduator\DataObject\Graduation;

interface IGraduationsParser
{
    /**
     * @return Generator|array<Graduation>
     */
    public function parse(array $args): Generator;
}
