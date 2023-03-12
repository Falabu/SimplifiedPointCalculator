<?php

namespace Tests\Unit\Util;

use App\SPC\Util\GraduatorUtil;
use Exception;
use PHPUnit\Framework\TestCase;

class UtilTest extends TestCase
{
    public function testResultUtilCanParsePercent()
    {
        $percent = '65%';
        $result = GraduatorUtil::getResultFromPercent($percent);

        $this->assertEquals(65, $result);
    }

    public function testResultUtilThrowExceptionIfCantParsePercent()
    {
        $percent = '65!';

        $this->expectException(Exception::class);
        GraduatorUtil::getResultFromPercent($percent);
    }
}
