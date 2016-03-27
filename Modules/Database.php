<?php

namespace Kiberzauras\Translator\Modules;

use Kiberzauras\Translator\Eloquent\Models\Value;
use Kiberzauras\Translator\Translator;

class Database {
    /**
     * @var Database
     */
    private static $_instance;

    /**
     * @return Database
     * @author Rytis Grincevičius <rytis.grincevicius@gmail.com>
     */
    public static function instance()
    {
        if (!static::$_instance)
            static::$_instance = new static;

        return static::$_instance;
    }

    public static function translate($string = '', array $arguments = array(), $domain = 'default', $locale = '')
    {
        $instance = static::instance();
        return static::instance()->getTranslation($string, $domain, $locale);

    }

    /**
     * @param $string
     * @param $domain
     * @param $locale
     * @return string|bool
     * @author Rytis Grincevičius <rytis.grincevicius@gmail.com>
     */
    public function getTranslation($string, $domain, $locale)
    {
        $value = Value::with('key')
            ->whereHas('key', function($t) use ($string, $domain) {
                $t->whereKey($string);
                $t->whereDomain($domain);
            })
            ->whereHas('language', function($t) use ($locale) {
                $t->whereCode($locale);
            })
            ->orderBy('id', 'asc')
            ->first(['value']);

        if (!empty($value)) {
            return $value->value;
        }

        return false;
    }


}