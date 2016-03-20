<?php

namespace Kiberzauras\Translator;

class Translator {

    /**
     * @var Translator
     */
    private static $_instance = null;
    /**
     * @var array
     */
    private $_debug = false;

    /**
     * @var array
     */
    public $translations = array();

    /**
     * @param string $string
     * @param array|string $arguments
     * @param string $domain
     * @return string
     * @author Rytis Grincevičius <rytis.grincevicius@gmail.com>
     */
    public static function translate ($string = '', $arguments = array(), $domain = '')
    {
        static::_instance($domain);

        $arguments = (array) $arguments;

        if (array_key_exists($string, static::$_instance->translations)) {
            return static::$_instance->translations[$string];
        }

        return (static::$_instance->_debug ? '* ' : '') . $string;
    }

    /**
     * @param string $domain
     * @return Translator
     * @author Rytis Grincevičius <rytis.grincevicius@gmail.com>
     */
    protected static function _instance ($domain = '')
    {
        if (!static::$_instance) {
            static::$_instance = new static;
            static::$_instance->translations = static::getTranslations($domain);
            static::$_instance->_debug = config('app.debug', false);
        }

        return static::$_instance;
    }

    /**
     * @param string $domain
     * @return array
     * @author Rytis Grincevičius <rytis.grincevicius@gmail.com>
     */
    public static function getTranslations ($domain = '')
    {
        $domain = $domain ? $domain : 'default';

        $path = Path::translation_path($domain . '.php');

        if (file_exists($path))
            return include_once $path;
        return [];
    }
}
