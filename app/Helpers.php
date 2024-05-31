<?php

namespace App;

class Helpers
{
    public static function mb_ucfirst (string $string, string $encoding = "UTF-8") {
        return mb_strtoupper(mb_substr($string, 0, 1)) . mb_substr($string, 1);
    }
}
