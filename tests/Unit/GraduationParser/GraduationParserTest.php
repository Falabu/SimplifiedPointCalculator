<?php

namespace Tests\Unit\GraduationParser;

use App\SPC\GraduationParser\ArrayGraduationParser;
use App\SPC\Graduator\DataObject\Graduation;
use App\SPC\Graduator\DataObject\Major;
use App\SPC\Graduator\Enum\ClassLevel;
use App\SPC\Graduator\Enum\LanguageLevel;
use App\SPC\Graduator\TestData;
use PHPUnit\Framework\TestCase;

class GraduationParserTest extends TestCase
{
    public function testArrayParserParseArrayToGraduationDTO()
    {
        $parser = new ArrayGraduationParser();

        foreach ($parser->parse() as $index => $graduation) {
            $this->assertInstanceOf(Graduation::class, $graduation);
            $currentTestData = TestData::$graduations[$index];
            $currentValasztottSzak = TestData::$graduations[$index]['valasztott-szak'];

            $this->assertEquals($currentValasztottSzak['kar'], $graduation->valasztottSzak->kar);
            $this->assertEquals($currentValasztottSzak['szak'], $graduation->valasztottSzak->szak);
            $this->assertEquals($currentValasztottSzak['egyetem'], $graduation->valasztottSzak->egyetem);

            $this->assertInstanceOf(Major::class, $graduation->valasztottSzak);
            $this->assertIsArray($graduation->erettsegiEredmenyek);
            $this->assertIsArray($graduation->tobbletpontok);

            foreach ($graduation->erettsegiEredmenyek as $index2 => $eredmeny) {
                $currentEredmeny = $currentTestData['erettsegi-eredmenyek'][$index2];
                $eredmenyTipusEnum = ClassLevel::tryFrom($currentEredmeny['tipus']);
                $this->assertEquals($currentEredmeny['nev'], $eredmeny->nev);
                $this->assertEquals($currentEredmeny['eredmeny'], $eredmeny->eredmeny);
                $this->assertEquals($eredmenyTipusEnum, $eredmeny->tipus);
            }

            foreach ($graduation->tobbletpontok as $index3 => $tobbletpont) {
                $currentTobbletPont = $currentTestData['tobbletpontok'][$index3];
                $nyelvTipusEnum = LanguageLevel::tryFrom($currentTobbletPont['tipus']);

                $this->assertEquals('Nyelvvizsga', $tobbletpont->kategoria);
                $this->assertEquals($currentTobbletPont['nyelv'], $tobbletpont->nyelv);
                $this->assertEquals($nyelvTipusEnum, $tobbletpont->tipus);
            }
        };
    }
}
