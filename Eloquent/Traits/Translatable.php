<?php

namespace Kiberzauras\Translator\Eloquent\Traits;
use Kiberzauras\Translator\Eloquent\Translator;

/**
 * Class Translatable
 * @property array $translatable
 * @package Kiberzauras\Translator\Eloquent\Traits
 * @author Rytis Grincevičius <rytis.grincevicius@gmail.com>
 */
trait Translatable {

    protected static function boot()
    {
        /*parent::boot();
        static::creating(function($model){
            $model->foo = 'foo';
        });*/
    }

    public function newFromBuilder($attributes = [], $connection = null)
    {
        $model = parent::newFromBuilder($attributes, $connection);

        foreach ($model->attributes AS $key => $value)
        {
            $override = in_array($key, (array) $this->translatable);

            if ($override) {
                $model->$key = new Translator($value);
            }
        }

        return $model;
    }

    public function language($local = '')
    {
        return 'opa';
    }
}