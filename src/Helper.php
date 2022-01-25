<?php

namespace MJ\ModelingTest;

class Helper
{
    public static function itemGetter($array, $key)
    {
        return $array[$key];
    }

    public static function ucFirstLetter(string $string)
    {
        return ucfirst(strtolower($string));
    }

    public static function cleanString(string $string)
    {
        return substr($string, 0, strpos($string, "_"));
    }

    public static function getFromString(string $string)
    {
        list($old, $output) = explode("FROM", $string);

        return $output;
    }
}
