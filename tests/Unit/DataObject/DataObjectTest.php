<?php

namespace Tests\Unit\DataObject;

use App\SPC\DataObject\DataObject;
use App\SPC\Graduator\Enum\ClassLevel;
use PHPUnit\Framework\TestCase;

class DataObjectTest extends TestCase
{
    public function testCanCreateDataObjectFromArrayWithoutAllPropertySpecified()
    {
        $name = 'Test Name';
        $age = 12;

        $testObject = TestObjectA::fromArray([
            'name' => $name,
            'age' => $age,
        ]);

        $this->assertEquals($name, $testObject->name);
        $this->assertEquals($age, $testObject->age);
    }

    public function testCanCreateDataObjectFromArrayThatHaveOtherDataObjectProperty()
    {
        $name = 'Test Name';
        $age = 12;
        $animal = 'cat';
        $weight = 20;

        $testObject = TestObjectA::fromArray([
            'name' => $name,
            'age' => $age,
            'objectB' => [
                'animal' => $animal,
                'weight' => $weight,
            ]
        ]);

        $this->assertInstanceOf(TestObjectB::class, $testObject->objectB);
        $this->assertEquals($animal, $testObject->objectB->animal);
        $this->assertEquals($weight, $testObject->objectB->weight);
    }

    public function testCanCreateDataObjectFromArrayThatHaveArrayOfDataObjectProperty()
    {
        $name = 'Test Name';
        $age = 12;
        $animal1 = 'cat';
        $weight1 = 20;
        $animal2 = 'dog';
        $weight2 = 30;

        $testObject = TestObjectA::fromArray([
            'name' => $name,
            'age' => $age,
            'manyB' => [
                [
                    'animal' => $animal1,
                    'weight' => $weight1,
                ],
                [
                    'animal' => $animal2,
                    'weight' => $weight2,
                ],
            ]
        ]);

        $this->assertIsArray($testObject->manyB);
        $this->assertInstanceOf(DataObject::class, $testObject->manyB[0]);
        $this->assertInstanceOf(DataObject::class, $testObject->manyB[1]);

        $this->assertEquals($animal1, $testObject->manyB[0]->animal);
        $this->assertEquals($weight1, $testObject->manyB[0]->weight);

        $this->assertEquals($animal2, $testObject->manyB[1]->animal);
        $this->assertEquals($weight2, $testObject->manyB[1]->weight);
    }

    public function testCanCreateDataObjectWithEnum()
    {
        $testObject = TestObjectC::fromArray([
            'level' => 'közép'
        ]);

        $this->assertEquals(ClassLevel::KOZEP, $testObject->level);
    }

}
