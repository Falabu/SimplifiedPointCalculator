<?php

namespace App\SPC\Graduator\DataObject;

use App\SPC\DataObject\DataObject;

class Points extends DataObject
{
    public int $base = 0;
    public int $additional = 0;

    public function add(Points $point): Points
    {
        return Points::fromArray([
            'additional' => $this->additional + $point->additional,
            'base' => $this->base + $point->base
        ]);
    }
}
