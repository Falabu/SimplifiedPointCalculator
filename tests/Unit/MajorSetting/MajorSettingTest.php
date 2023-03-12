<?php

namespace Tests\Unit\MajorSetting;

use App\SPC\Graduator\DataObject\MajorSetting as MajorSettingData;
use App\SPC\Graduator\MajorSetting\MajorSetting;
use PHPUnit\Framework\TestCase;

class MajorSettingTest extends TestCase
{
    public function testMajorSettingGivesTheSettingWhenFoundOne()
    {
        $majorSetting = new MajorSetting();
        $setting = $majorSetting->get('Anglisztika');

        $this->assertInstanceOf(MajorSettingData::class, $setting);
    }

    public function testMajorSettingGivesNullWhenNotFound()
    {
        $majorSetting = new MajorSetting();
        $setting = $majorSetting->get('Cicafüst');

        $this->assertEquals(null, $setting);
    }
}
