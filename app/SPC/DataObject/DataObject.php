<?php
namespace App\SPC\DataObject;

use App\SPC\DataObject\Attribute\ArrayOf;
use App\SPC\DataObject\Attribute\AttributeResolver;
use BackedEnum;
use ReflectionClass;
use ReflectionIntersectionType;
use ReflectionNamedType;
use ReflectionProperty;
use ReflectionUnionType;

/**
 * This is my older implementation of DTO it's out of scope from this assigment,
 * This is a stripped version of it because the original have a string casing check feature,
 * but that is dependent on Laravel
 * I really like to use DTO-s instead of simple array
 * I copied it from my other project
 */

/**
 * @psalm-suppress all
 */
class DataObject
{
    private array $nullables;

    public function getNullables(): array
    {
        if (isset($this->nullables)) {
            return $this->nullables;
        }

        $this->setNullables();
        return $this->nullables;
    }

    public function toArray(): array
    {
        return $this->only();
    }

    public function only(array $properties = ['*']): array
    {
        if (isset($properties[0]) && $properties[0] === '*') {
            $properties = array_keys(get_object_vars($this));
        }

        $values = [];
        foreach ($properties as $property) {
            if ($this->needToSkip($property)) {
                continue;
            }

            $value = $this->$property;

            if ($this->$property instanceof DataObject) {
                $value = $this->$property->toArray();
            }

            if ($this->$property instanceof BackedEnum) {
                $value = $this->$property->value;
            }

            if ($this->checkArrayOfObject($this->$property)) {
                $value = $this->getArrayValues($this->$property);
            }

            $values[$property] = $value;
        }

        return $values;
    }

    public static function fromArray(array $values): static
    {
        $dataObject = new static();

        foreach ($values as $property => $value) {
            //Added this line only for sample data, originally I used Laravel string helper here
            $property = lcfirst(str_replace('-', '', ucwords($property, '-')));
            if (!property_exists($dataObject, $property)) {
                continue;
            }

            $propertyType = self::getPropertyType($dataObject, $property)?->getName();
            if (is_subclass_of($propertyType, DataObject::class) && is_array($value)) {
                $dataObject->$property = $propertyType::fromArray($value);

                continue;
            }

            if (is_subclass_of($propertyType, BackedEnum::class)) {
                $dataObject->$property = $propertyType::tryFrom($value);

                continue;
            }

            $childDataObject = self::getDataObjectOfArray($dataObject, $property);
            if ($childDataObject) {
                $dataObject->$property = array_map(
                    fn(array|DataObject $values
                    ) => $values instanceof DataObject ? $values : $childDataObject::fromArray($values),
                    $value
                );

                continue;
            }

            $dataObject->$property = $value;
        }

        return $dataObject;
    }

    private function needToSkip(mixed $property): bool
    {
        return match (true) {
            !$this->isPropertyInitialized($property) => true,
            $property === 'nullables', !property_exists($this, $property) => true,
            is_null($this->$property) && !in_array($property, $this->getNullables()) => true,
            default => false,
        };
    }

    private function isPropertyInitialized(string $property): bool
    {
        $property = new ReflectionProperty($this, $property);
        return $property->isInitialized($this);
    }

    protected function checkArrayOfObject(mixed $dataToCheck): bool
    {
        if (!is_array($dataToCheck)) {
            return false;
        }

        foreach ($dataToCheck as $item) {
            if (!$item instanceof DataObject) {
                return false;
            }
        }

        return true;
    }

    private function setNullables(): void
    {
        $reflectionClass = new ReflectionClass($this);

        foreach ($reflectionClass->getProperties() as $property) {
            if ($property->getType()->allowsNull()) {
                $this->nullables[] = $property->getName();
            }
        }
    }

    private static function getDataObjectOfArray(DataObject $dataObject, string $property): ?DataObject
    {
        $attributeResolver = AttributeResolver::create($dataObject);
        if (!$attributeResolver->isPropertyAttributeExists($property, ArrayOf::class)) {
            return null;
        }

        $dtoClass = $attributeResolver->getPropertyAttributeProperty(ArrayOf::class, $property, ArrayOf::CLASS_STRING);
        return new $dtoClass();
    }

    private static function getPropertyType(DataObject $dataObject, string $propertyName): ?ReflectionNamedType
    {
        $reflection = new ReflectionClass($dataObject);
        $property = $reflection->getProperty($propertyName);

        $type = $property->getType();

        if ($type instanceof ReflectionUnionType || $type instanceof ReflectionIntersectionType) {
            return null;
        }

        return $type;
    }

    /**
     * @param mixed $propertyValues
     * @return array|array[]
     */
    protected function getArrayValues(mixed $propertyValues): array
    {
        return array_map(
            fn(DataObject $item) => $item->toArray(),
            $propertyValues
        );
    }
}
