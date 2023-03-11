<?php

namespace App\SPC\Graduator\DataObject;

use App\SPC\DataObject\DataObject;
use App\SPC\Graduator\Enum\AdditionalPointCategory;
use App\SPC\Graduator\Enum\LanguageLevel;

class LanguageResult extends DataObject
{
    public AdditionalPointCategory $kategoria;
    public LanguageLevel $tipus;
    public string $nyelv;
}
