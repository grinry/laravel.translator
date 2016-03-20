<?php

namespace Kiberzauras\Translator;
use Illuminate\Foundation\Application;

/**
 * Class Path
 * @package Kiberzauras\Translator
 * @author Rytis Grincevičius <rytis.grincevicius@gmail.com>
 */
class Path {

    /**
     * @param string $path
     * @return string
     * @author Rytis Grincevičius <rytis.grincevicius@gmail.com>
     */
    public static function translations_path($path = '')
    {
        $path = self::parse_path($path);
        return resource_path('translations' . ($path ? DIRECTORY_SEPARATOR . $path : $path));
    }

    /**
     * @param string $path
     * @param string $locale
     * @return string
     * @author Rytis Grincevičius <rytis.grincevicius@gmail.com>
     */
    public static function translation_path($path = '', $locale = '')
    {
        $locale = $locale ? $locale : Application::getInstance()->getLocale();
        $path = self::parse_path($path);
        return self::translations_path($locale . ($path ? DIRECTORY_SEPARATOR . $path : $path));
    }

    /**
     * @param string $path
     * @return string
     * @author Rytis Grincevičius <rytis.grincevicius@gmail.com>
     */
    public static function parse_path($path = '')
    {
        return trim(str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $path), DIRECTORY_SEPARATOR);
    }
}
