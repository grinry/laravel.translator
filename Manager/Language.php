<?php

namespace Kiberzauras\Translator\Manager;

use Kiberzauras\Translator\Eloquent\Models\Language as LanguageEloquent;

/**
 * Class Language
 * @package Kiberzauras\Translator\Manager
 * @author Rytis Grincevičius <rytis.grincevicius@gmail.com>
 */
class Language {
    private $languages = [];
    private static $instance;

    public static function prepare()
    {
        if (!self::$instance) {
            self::$instance = new self;
            self::$instance->languages = LanguageEloquent::all(['id', 'code'])->pluck('code', 'id');
        }
        return self::$instance;
    }

    /**
     * @return array
     * @author Rytis Grincevičius <rytis.grincevicius@gmail.com>
     */
    public static function languages()
    {
        return self::prepare()->languages;
    }

    /**
     * @param int $id
     * @return string
     * @author Rytis Grincevičius <rytis.grincevicius@gmail.com>
     */
    public static function getCode($id = 1)
    {
        if (array_key_exists($id, self::languages()))
            return self::languages()[$id];
        return config('app.fallback_language');
    }

    /**
     * @param string $language_code
     * @return int
     * @author Rytis Grincevičius <rytis.grincevicius@gmail.com>
     */
    public static function getId($language_code = 'en')
    {
        $array = array_flip(self::languages());
        if (array_key_exists($language_code, $array))
            return $language_code[$language_code];
        return 0;
    }
}