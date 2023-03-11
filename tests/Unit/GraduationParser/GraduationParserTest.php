<?php

namespace Tests\Unit\GraduationParser;

use App\SPC\GraduationParser\ArrayGraduationParser;
use App\SPC\Graduator\DataObject\Graduation;
use App\SPC\Graduator\DataObject\Major;
use PHPUnit\Framework\TestCase;

class GraduationParserTest extends TestCase
{
    public function testArrayParserParseArrayToGraduationDTO()
    {
        $parser = new ArrayGraduationParser();

        foreach ($parser->parse(TestData::$exampleData) as $index => $graduation) {
            $this->assertInstanceOf(Graduation::class, $graduation);
            $currentTestData = TestData::$exampleData[$index];
            $currentValasztottSzak = TestData::$exampleData[$index]['valasztott-szak'];

            $this->assertEquals($currentValasztottSzak['kar'], $graduation->valasztottSzak->kar);
            $this->assertEquals($currentValasztottSzak['szak'], $graduation->valasztottSzak->szak);
            $this->assertEquals($currentValasztottSzak['egyetem'], $graduation->valasztottSzak->egyetem);

            $this->assertInstanceOf(Major::class, $graduation->valasztottSzak);
            $this->assertIsArray($graduation->erettsegiEredmenyek);
            $this->assertIsArray($graduation->tobbletpontok);
            $this->assertCount(5, $graduation->erettsegiEredmenyek);
            $this->assertCount(2, $graduation->tobbletpontok);

            foreach ($graduation->erettsegiEredmenyek as $index2 => $eredmeny) {
                $currentEredmeny = $currentTestData['erettsegi-eredmenyek'][$index2];
                $this->assertEquals($currentEredmeny['nev'], $eredmeny->nev);
                $this->assertEquals($currentEredmeny['eredmeny'], $eredmeny->eredmeny);
                $this->assertEquals($currentEredmeny['tipus'], $eredmeny->tipus);
            }

            foreach ($graduation->tobbletpontok as $index3 => $tobbletpont) {
                $currentTobbletPont = $currentTestData['tobbletpontok'][$index3];
                $this->assertEquals($currentTobbletPont['kategoria'], $tobbletpont->kategoria);
                $this->assertEquals($currentTobbletPont['nyelv'], $tobbletpont->nyelv);
                $this->assertEquals($currentTobbletPont['tipus'], $tobbletpont->tipus);
            }
        };
    }
}
