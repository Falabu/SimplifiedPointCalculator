<?php

namespace Tests\Unit\Validator;

use App\SPC\Graduator\DataObject\ClassResult;
use App\SPC\Graduator\Enum\ClassLevel;
use App\SPC\Graduator\Validator\HaveRequiredChosenClass;
use App\SPC\Graduator\Validator\HaveRequiredClassValidator;
use App\SPC\Graduator\Validator\IValidator;
use App\SPC\Graduator\Validator\MinPointPerClassValidator;
use App\SPC\Graduator\Validator\ValidatorsFactory;
use PHPUnit\Framework\TestCase;

class ValidatorFactoryTest extends TestCase
{
    public function testThatFactoryGeneratesValidators()
    {
        $validatorFactory = new ValidatorsFactory();

        $validators = $validatorFactory->create('Programtervező informatikus');

        $this->assertCount(3, $validators);
        $this->assertIsArray($validators);

        foreach ($validators as $validator) {
            $this->assertInstanceOf(IValidator::class, $validator);
        }
    }

    public function testRequiredChosenClassValidatorValid()
    {
        $items = [
            ClassResult::fromArray([
                'nev' => 'informatika',
                'tipus' => 'emelt',
                'eredmeny' => '60%',
            ]),
            ClassResult::fromArray([
                'nev' => 'angol nyelv',
                'tipus' => 'közép',
                'eredmeny' => '70%',
            ]),
            ClassResult::fromArray([
                'nev' => 'történelem',
                'tipus' => 'közép',
                'eredmeny' => '80%',
            ]),
        ];

        $validator = new HaveRequiredChosenClass(['történelem', 'spanyol', 'matematika']);
        $validated = $validator->validate($items);

        $this->assertEquals(true, $validated);
    }

    public function testRequiredChosenClassValidatorNotValid()
    {
        $items = [
            ClassResult::fromArray([
                'nev' => 'informatika',
                'tipus' => 'emelt',
                'eredmeny' => '60%',
            ]),
            ClassResult::fromArray([
                'nev' => 'angol nyelv',
                'tipus' => 'közép',
                'eredmeny' => '70%',
            ]),
            ClassResult::fromArray([
                'nev' => 'történelem',
                'tipus' => 'közép',
                'eredmeny' => '80%',
            ]),
        ];

        $validator = new HaveRequiredChosenClass(['orosz', 'spanyol', 'matematika']);
        $validated = $validator->validate($items);

        $this->assertEquals(false, $validated);
    }

    public function testRequiredClassValidatorValid()
    {
        $items = [
            ClassResult::fromArray([
                'nev' => 'informatika',
                'tipus' => 'emelt',
                'eredmeny' => '60%',
            ]),
            ClassResult::fromArray([
                'nev' => 'angol nyelv',
                'tipus' => 'közép',
                'eredmeny' => '70%',
            ]),
            ClassResult::fromArray([
                'nev' => 'történelem',
                'tipus' => 'közép',
                'eredmeny' => '80%',
            ]),
        ];

        $validator = new HaveRequiredClassValidator('informatika');
        $validated = $validator->validate($items);

        $this->assertEquals(true, $validated);
    }

    public function testRequiredClassValidatorNotValid()
    {
        $items = [
            ClassResult::fromArray([
                'nev' => 'informatika',
                'tipus' => 'emelt',
                'eredmeny' => '60%',
            ]),
            ClassResult::fromArray([
                'nev' => 'angol nyelv',
                'tipus' => 'közép',
                'eredmeny' => '70%',
            ]),
            ClassResult::fromArray([
                'nev' => 'történelem',
                'tipus' => 'közép',
                'eredmeny' => '80%',
            ]),
        ];

        $validator = new HaveRequiredClassValidator('magyar');
        $validated = $validator->validate($items);

        $this->assertEquals(false, $validated);
    }

    public function testRequiredClassValidatorValidWithLevel()
    {
        $items = [
            ClassResult::fromArray([
                'nev' => 'informatika',
                'tipus' => 'emelt',
                'eredmeny' => '60%',
            ]),
            ClassResult::fromArray([
                'nev' => 'angol nyelv',
                'tipus' => 'közép',
                'eredmeny' => '70%',
            ]),
            ClassResult::fromArray([
                'nev' => 'történelem',
                'tipus' => 'közép',
                'eredmeny' => '80%',
            ]),
        ];

        $validator = new HaveRequiredClassValidator('informatika', ClassLevel::EMELT);
        $validated = $validator->validate($items);

        $this->assertEquals(true, $validated);
    }

    public function testRequiredClassValidatorNotValidWithLevel()
    {
        $items = [
            ClassResult::fromArray([
                'nev' => 'informatika',
                'tipus' => 'közép',
                'eredmeny' => '60%',
            ]),
            ClassResult::fromArray([
                'nev' => 'angol nyelv',
                'tipus' => 'közép',
                'eredmeny' => '70%',
            ]),
            ClassResult::fromArray([
                'nev' => 'történelem',
                'tipus' => 'közép',
                'eredmeny' => '80%',
            ]),
        ];

        $validator = new HaveRequiredClassValidator('informatika', ClassLevel::EMELT);
        $validated = $validator->validate($items);

        $this->assertEquals(false, $validated);
    }

    public function testMinPointPerClassValidatorValid()
    {
        $items = [
            ClassResult::fromArray([
                'nev' => 'informatika',
                'tipus' => 'közép',
                'eredmeny' => '60%',
            ]),
            ClassResult::fromArray([
                'nev' => 'angol nyelv',
                'tipus' => 'közép',
                'eredmeny' => '70%',
            ]),
            ClassResult::fromArray([
                'nev' => 'történelem',
                'tipus' => 'közép',
                'eredmeny' => '80%',
            ]),
        ];

        $validator = new MinPointPerClassValidator(20);
        $validated = $validator->validate($items);

        $this->assertEquals(true, $validated);
    }

    public function testMinPointPerClassValidatorNotValid()
    {
        $items = [
            ClassResult::fromArray([
                'nev' => 'informatika',
                'tipus' => 'közép',
                'eredmeny' => '10%',
            ]),
            ClassResult::fromArray([
                'nev' => 'angol nyelv',
                'tipus' => 'közép',
                'eredmeny' => '70%',
            ]),
            ClassResult::fromArray([
                'nev' => 'történelem',
                'tipus' => 'közép',
                'eredmeny' => '80%',
            ]),
        ];

        $validator = new MinPointPerClassValidator(20);
        $validated = $validator->validate($items);

        $this->assertEquals(false, $validated);
    }
}
