<?php

namespace CheckItOnUs\Cachet\Helpers;

use Cocur\Slugify\Slugify;

class Slug
{
    private static $slug;

    /**
     * Generates a slug.
     *
     * @param string $string The string
     *
     * @return string The slugged value
     */
    public static function generate($string)
    {
        if (static::$slug === null) {
            static::$slug = Slugify::create();
        }

        if (is_string($string)) {
            return static::$slug->slugify($string);
        }

        if (is_array($string)) {
            foreach ($string as $key => $value) {
                $string[$key] = static::$slug->slugify($value);
            }

            return implode('_', $string);
        }
    }
}
