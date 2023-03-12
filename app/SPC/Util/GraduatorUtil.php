<?php

namespace App\SPC\Util;

use Exception;

class GraduatorUtil
{
    /**
     * @param string $percent
     * @return int
     * @throws Exception
     */
    public static function getResultFromPercent(string $percent): int
    {
        preg_match('/\d+(?=\s*%)/', $percent, $matches);
        if (!isset($matches[0])) {
            throw new Exception("Can't parse percentage");
        }
        
        return filter_var($matches[0], FILTER_VALIDATE_INT);
    }
}
