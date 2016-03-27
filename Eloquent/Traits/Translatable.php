<?php

namespace Kiberzauras\Translator\Eloquent\Traits;
use Kiberzauras\Translator\Eloquent\Translator;

/**
 * Class Translatable
 * @property array $translatable
 * @package Kiberzauras\Translator\Eloquent\Traits
 * @method static creating($model)
 * @method static updating($model)
 * @author Rytis Grincevičius <rytis.grincevicius@gmail.com>
 */
trait Translatable {
    protected static function bootTranslatable()
    {
        /*parent::boot();
        static::creating(function($model){
            $model->foo = 'foo';
        });*/
        static::creating(function($model) {
            if (config('translator.translatable_as_json')) {
                foreach ((array) with(new self)->translatable as $item) {
                    $model->{$item} = json_encode($model->{$item});
                }
            } else {
                $items = [];
                foreach ((array) with(new self)->translatable as $item) {
                    $items[$item] = $model->{$item};
                    $model->{$item} = isset($model->{$item}[config('app.locale')])?$model->{$item}[config('app.locale')]:'';
                }
            }
        });

        static::updating(function($model) {
//            Translate::update($model->name, $model->getOriginal('name'));
//            $model->name = $model->getOriginal('name');
//            Translate::update($model->description, $model->getOriginal('description'));
//            $model->description = $model->getOriginal('description');
        });

    }

    public function translate()
    {
        return $this->morphMany('Kiberzauras\Translator\Eloquent\Key', 'domain', 'key', 'domain');
    }

    public function newFromBuilder($attributes = [], $connection = null)
    {
        $model = parent::newFromBuilder($attributes, $connection);

        foreach ($model->attributes AS $key => $value)
        {
            $override = in_array($key, (array) $this->translatable);

            if ($override) {
                $model->$key = new Translator($value, static::class);
            }
        }

        return $model;
    }
}