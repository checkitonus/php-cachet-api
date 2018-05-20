<?php

namespace CheckItOnUs\Cachet\Helpers;

class Text
{
    public static function toCamelCase($string)
    {
        $result = '';
        $parts = explode('_', $string);

        foreach ($parts as $part) {
            $result .= ucfirst($part);
        }

        return $result;
    }
}
