<?php

namespace Kiberzauras\Translator\Eloquent;
use Kiberzauras\Translator\Translator;

/**
 * Class Translate
 * @package Kiberzauras\Translator\Eloquent
 * @author Rytis Grincevičius <rytis.grincevicius@gmail.com>
 */
class Translate {

    /**
     * @var string
     */
    private $translations = [
        'en'=>'empty'
    ];
    private $locale;

    /**
     * Translator constructor.
     * @param string $string
     * @param string $domain
     */
    public function __construct($string = '', $domain = '')
    {
        $decode = json_decode($string, true);
        $this->translations = $decode ? $decode : [
            config('app.locale') => $string,
            config('app.fallback_locale') => $string
        ];
        $this->locale = Translator::getLocale();
    }

    /**
     * @return string
     * @author Rytis Grincevičius <rytis.grincevicius@gmail.com>
     */
    public function __toString()
    {
        return (string) $this->translations[$this->locale];
    }

    /**
     * @param string $locale
     * @return $this
     * @author Rytis Grincevičius <rytis.grincevicius@gmail.com>
     */
    public function locale($locale = '')
    {
        $this->locale = $locale;
        return $this;
    }

    /**
     * @param array $arguments
     * @return $this
     * @author Rytis Grincevičius <rytis.grincevicius@gmail.com>
     */
    public function args(array $arguments)
    {
        $translations = [];
        foreach($this->translations as $key => $value):
            $translations[$key] = Translator::applyArguments($value, $arguments);
        endforeach;
        $this->translations = $translations;
        return $this;
    }

    /**
     * @param int $number
     * @return $this
     * @author Rytis Grincevičius <rytis.grincevicius@gmail.com>
     * @todo
     */
    public function plural($number = 0)
    {
        return $this;
    }
}