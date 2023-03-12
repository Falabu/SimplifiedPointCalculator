<?php

namespace App\SPC\GraduationParser;

use Generator;

interface IGraduationsParser
{
    /**
     * @return Generator
     */
    public function parse(): Generator;
}
