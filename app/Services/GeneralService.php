<?php

namespace App\Services;

class GeneralService
{
    public static function formatNum($num)
    {
        // 00001
        if ($num < 10) {
            return '0000' . $num;
        }

        // 00099
        if ($num < 100) {
            return '000' . $num;
        }

        // 00999
        if ($num < 1000) {
            return '00' . $num;
        }

        // 09999
        if ($num < 10000) {
            return '0' . $num;
        }

        return $num;
    }
}
