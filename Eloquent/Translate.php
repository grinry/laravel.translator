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
    private $enforce = false;

    /**
     * Translator constructor.
     * @param string $string
     * @param string $domain
     */
    public function __construct($string = '', $domain = '')
    {
        $decode = json_decode($string, true);
        $this->translations = $decode ? $decode : [
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
        return $this->get();
    }

    /**
     * @return string
     * @author Rytis Grincevičius <rytis.grincevicius@gmail.com>
     */
    public function get()
    {
        if ($this->enforce)
            return (string) array_key_exists($this->locale, $this->translations) ? $this->translations[$this->locale] : '';

        if (array_key_exists($this->locale, $this->translations))
            return (string) $this->translations[$this->locale];

        if (array_key_exists(config('app.fallback_locale'), $this->translations))
            return (string) $this->translations[config('app.fallback_locale')];

        return (string) array_values($this->translations)[0];
    }

    /**
     * @param string $locale
     * @param bool $enforce
     * @return $this
     * @author Rytis Grincevičius <rytis.grincevicius@gmail.com>
     */
    public function locale($locale = '', $enforce = false)
    {
        $this->locale = $locale;
        $this->enforce = $enforce;
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