<?php

namespace Kiberzauras\Translator\Eloquent;
use JsonSerializable;
use Kiberzauras\Translator\Translator;

/**
 * Class Translate
 * @package Kiberzauras\Translator\Eloquent
 * @author Rytis Grincevičius <rytis.grincevicius@gmail.com>
 */
class Translate implements JsonSerializable {

    /**
     * @var string
     */
    private $translations = [];
    private $locale;
    private $enforce = false;

    /**
     * Translator constructor.
     * @param string $string
     * @param string $domain
     */
    public function __construct($string = '', $domain = '')
    {
        $decode = is_string($string) ? json_decode($string, true)  : $string;
        $this->translations = $decode ? $decode : [
            config('app.fallback_locale') => $string != '{}' ? $string : null
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
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
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
     * @return array
     */
    public function all()
    {
        return $this->translations;
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
