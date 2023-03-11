<?php

namespace Tests\Unit\DataObject;

use App\SPC\DataObject\Attribute\ArrayOf;
use App\SPC\DataObject\DataObject;

class TestObjectA extends DataObject
{
    public string $name;

    public int $age;

    public string $camelCase;

    public ?int $canNull;

    public TestObjectB $objectB;

    #[ArrayOf(TestObjectB::class)]
    public array $manyB;
}
