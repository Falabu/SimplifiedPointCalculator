<?php

namespace App\SPC\Graduator\DataObject;

use App\SPC\DataObject\DataObject;

class Points extends DataObject
{
    public int $base = 0;
    public int $additional = 0;

    public function add(Points $point): Points
    {
        $points = new Points();
        $points->additional = $this->additional + $point->additional;
        $points->base = $this->base + $point->base;

        return $points;
    }

    public function total(): int
    {
        return $this->base + $this->additional;
    }
}
