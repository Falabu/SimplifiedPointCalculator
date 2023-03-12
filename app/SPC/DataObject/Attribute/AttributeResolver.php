<?php

namespace App\SPC\DataObject\Attribute;

use Exception;
use ReflectionClass;

/**
 * @psalm-suppress all
 */
class AttributeResolver
{
    private ReflectionClass $reflectionClass;

    public function __construct(object $objectToCheck)
    {
        $this->reflectionClass = new ReflectionClass($objectToCheck);
    }

    /**
     * @param string $property
     * @param string $attribute
     * @return bool
     * @throws Exception
     */
    public function isPropertyAttributeExists(string $property, string $attribute): bool
    {
        $classProperty = $this->reflectionClass->getProperty($property);
        return count($classProperty->getAttributes($attribute)) > 0;
    }

    /**
     * @param string $attribute
     * @param string $classProperty
     * @param string $attributeProperty
     * @return mixed
     * @throws Exception
     */
    public function getPropertyAttributeProperty(
        string $attribute,
        string $classProperty,
        string $attributeProperty
    ): mixed {
        $classProperty = $this->reflectionClass->getProperty($classProperty);

        return $this->getAttributeProperty($classProperty, $attribute, $attributeProperty);
    }

    /**
     * @param $attributable
     * @param $attribute
     * @param $property
     * @return mixed
     * @throws Exception
     */
    private function getAttributeProperty($attributable, $attribute, $property): mixed
    {
        if (!method_exists($attributable, 'getAttributes')) {
            throw new Exception("getAttributes method not exists");
        }

        $attributes = $attributable->getAttributes($attribute);

        if (!isset($attributes[0])) {
            throw new Exception("Attribute {$attribute} not exists");
        }

        $attributeObject = $attributes[0]->newInstance();

        if (!isset($attributeObject->$property)) {
            throw new Exception("Property ({$property}) not exists on {$attribute} attribute");
        }

        return $attributeObject->$property;
    }

    public static function create(object $object): static
    {
        return new static($object);
    }
}
