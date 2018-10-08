<?php namespace App\Classes;

class Util{

    public static function encodeJsHex($string)
    {
        $field = bin2hex($string);
        $field = chunk_split($field, 2, '\\x');
        return '\\x'.substr($field, 0, -2);
    }
}
