<?php

namespace App\SPC\DataObject\Attribute;

use Exception;
use ReflectionClass;

class AttributeResolver
{
    private ReflectionClass $reflectionClass;

    public function __construct(object $objectToCheck)
    {
        $this->reflectionClass = new ReflectionClass($objectToCheck);
    }

    public function isClassAttributeExists(string $attribute): bool
    {
        $attributes = $this->reflectionClass->getAttributes($attribute);

        return count($attributes) > 0;
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
     * @param string $method
     * @param string $attribute
     * @return bool
     * @throws Exception
     */
    public function isMethodAttributeExists(string $method, string $attribute): bool
    {
        $classMethod = $this->reflectionClass->getMethod($method);
        return count($classMethod->getAttributes($attribute)) > 0;
    }

    /**
     * @param string $attribute
     * @param string $property
     * @return mixed
     * @throws Exception
     */
    public function getClassProperty(string $attribute, string $property): mixed
    {
        $attributes = $this->reflectionClass->getAttributes($attribute);
        if (!isset($attributes[0])) {
            throw new Exception("Attribute {$attribute} not exists");
        }

        $attributeObject = $attributes[0]->newInstance();

        if (!isset($attributeObject->$property)) {
            throw new Exception("Property ({$property}) not exists on {$attribute} attribute");
        }

        return $attributeObject->$property;
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
     * @param string $attribute
     * @param string $method
     * @param string $property
     * @return mixed
     * @throws Exception
     */
    public function getMethodAttributeProperty(
        string $attribute,
        string $method,
        string $property
    ): mixed {
        $classMethod = $this->reflectionClass->getMethod($method);

        return $this->getAttributeProperty($classMethod, $attribute, $property);
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
