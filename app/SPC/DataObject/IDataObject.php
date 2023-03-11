<?php

namespace SPC\DataObject;

interface IDataObject
{
    public static function fromArray(array $values): static;
}
