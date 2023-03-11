<?php

namespace App\SPC\Graduator\DataObject;

use App\SPC\DataObject\Attribute\ArrayOf;
use App\SPC\DataObject\DataObject;

class Graduation extends DataObject
{
    public Major $valasztottSzak;

    /**
     * @var array<ClassResult>
     */
    #[ArrayOf(ClassResult::class)]
    public array $erettsegiEredmenyek;
    /**
     * @var array<LanguageResult>
     */
    #[ArrayOf(LanguageResult::class)]
    public array $tobbletpontok;
}
