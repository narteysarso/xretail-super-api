<?php

namespace App\Utility;

class Password
{
    public static function make(): string
    {
        $original_string = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
        $original_string = implode("", $original_string);
        $pass = substr(str_shuffle($original_string), 0, 10);
        return $pass;
    }
}
