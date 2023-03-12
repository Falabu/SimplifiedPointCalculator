<?php

namespace App\SPC\Graduator;

use App\SPC\GraduationParser\IGraduationsParser;
use Generator;

interface IGraduator
{
    /**
     * @param IGraduationsParser $graduationsParser
     * @return Generator
     */
    public function getEvaluations(IGraduationsParser $graduationsParser): Generator;
}
