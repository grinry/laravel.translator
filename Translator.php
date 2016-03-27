<?php

namespace Kiberzauras\Translator;

use Illuminate\Foundation\Application;
use Illuminate\Support\Str;
use Kiberzauras\Translator\Modules\Database;

class Translator {

    /**
     * @var Translator
     */
    private static $_instance = null;
    /**
     * @var bool
     */
    private $_database = true;

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
     * @param string $locale
     * @return string
     * @author Rytis Grincevičius <rytis.grincevicius@gmail.com>
     */
    public static function translate ($string = '', array $arguments = array(), $domain = 'default', $locale = '')
    {
        $locale = $locale ?: static::_instance()->getLocale();

        if (static::_instance()->_database) {
            $translation = Database::translate($string, $arguments, $domain, $locale);
        } else {
            $translation = 'file translations';
        }

        if ($translation === false)
            $translation = (static::$_instance->_debug ? '* ' : '') . $string;

        return Translator::applyArguments($translation, $arguments);
    }

    /**
     * @return Translator
     * @author Rytis Grincevičius <rytis.grincevicius@gmail.com>
     */
    protected static function _instance ()
    {
        if (!static::$_instance) {
            static::$_instance = new static;
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

    /**
     * @return string
     * @author Rytis Grincevičius <rytis.grincevicius@gmail.com>
     */
    public static function getLocale()
    {
        return Application::getInstance()->getLocale();
    }

    /**
     * @param $string
     * @param array $arguments
     * @return mixed
     * @author Rytis Grincevičius <rytis.grincevicius@gmail.com>
     */
    public static function applyArguments($string, array $arguments = array())
    {
        foreach ($arguments as $key => $value) {
            $string = str_replace(
                [':' . Str::upper($key), ':' . Str::ucfirst($key), ':'.$key],
                [Str::upper($value), Str::ucfirst($value), $value],
                $string
            );
        }
        return $string;
    }

    public static function applyPlurals($string = '', $number = 0, $split = '|')
    {

    }
}
