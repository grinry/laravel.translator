<?php

namespace Kiberzauras\Translator\Eloquent;

/**
 * Class Translator
 * @package Kiberzauras\Translator\Eloquent
 * @author Rytis Grincevičius <rytis.grincevicius@gmail.com>
 */
class Translator {

    /**
     * @var string
     */
    private $string = '';

    /**
     * Translator constructor.
     * @param string $string
     */
    public function __construct($string = '')
    {
        $this->string = $string;
    }

    /**
     * @return string
     * @author Rytis Grincevičius <rytis.grincevicius@gmail.com>
     */
    public function __toString()
    {
        return (string) $this->string . ' *';
    }

    public function locale($locale = '')
    {
        return $this->string . ' **';
    }
}