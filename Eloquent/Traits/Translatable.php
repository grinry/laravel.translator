<?php

namespace Kiberzauras\Translator\Eloquent\Traits;
use Illuminate\Database\Eloquent\Model;
use Kiberzauras\Translator\Eloquent\Translate;

/**
 * Class Translatable
 * @property array $translatable
 * @package Kiberzauras\Translator\Eloquent\Traits
 * @method static creating($model)
 * @method static updating($model)
 * @method static created($model)
 * @method static updated($model)
 * @author Rytis Grincevičius <rytis.grincevicius@gmail.com>
 */
trait Translatable {

    /**
     * @author Rytis Grincevičius <rytis.grincevicius@gmail.com>
     */
    protected static function bootTranslatable()
    {
        static::creating(function(Model $model) {
            if (config('translator.translatable_as_json', true)) {
                foreach ((array)with(new self)->translatable as $item) {
                    if ($model->{$item}) {
                        if (is_array($model->{$item})) {
                            $translations = array_filter($model->{$item}, function($var) {
                                return strlen(strip_tags(trim($var))) != 0;
                            });
                           $model->{$item} = count($translations) ? json_encode($translations) : '{}';
                        } elseif (is_string($model->{$item}) && !is_array(json_decode($model->{$item}, true))) {
                            $model->{$item} = json_encode([config('app.locale') => $model->{$item}]);
                        }
                    }
                }
            } else {
                //TODO: save strings to translation models
                $items = [];
                foreach ((array)with(new self)->translatable as $item) {
                    $items[$item] = $model->{$item};
                    $model->{$item} = isset($model->{$item}[config('app.locale')]) ? $model->{$item}[config('app.locale')] : '';
                }
            }
        });

        static::updating(function(Model $model) {
            //Check if string was json or translation key
            foreach ((array) with(new self)->translatable as $item) {
                if ($model->{$item}) {
                    $updated_locales = $model->{$item};

                    $original = $model->getOriginal($item);
                    $original_locales = json_decode($original, true);

                    if (!is_array($original_locales) && is_string($original)
                        || !$original_locales && is_string($original)
                        || !$original_locales && is_null($original)) {
                        $original_locales = [
                            config('app.fallback_locale') => $original
                        ];
                    }

                    if (is_string($updated_locales) && !is_array(json_decode($updated_locales, true))) {
                        $updated_locales = [config('app.locale') => $updated_locales];
                    } elseif(is_string($updated_locales)) {
                        $updated_locales = json_decode($updated_locales, true);
                    }

                    //If translations was in json, update locales in this models attribute
                    if (is_array($original_locales)) {
                        //Find and change only updated locales
                        foreach ($updated_locales as $locale => $value) {
                            if (strlen(strip_tags(trim($value))) != 0)
                                $original_locales[$locale] = $value;
                                
                            if ($value === '') //Remove translation if empty string given
                                unset($original_locales[$locale]);
                        }
                        //remove empty translations from array and save as json
                        $translations = array_filter($original_locales, function($var) {
                            return strlen(strip_tags(trim($var))) != 0;
                        });
                        $model->{$item} = count($translations) ? json_encode($translations) : '{}';
                    } else {
                        //TODO: update locales in translation model
                        //
                    }
                }
            }
        });

        static::created(function(Model $model) {
            foreach ((array) with(new self)->translatable as $item) {
                $model->{$item} = new Translate($model->{$item}, static::class);
            }
        });

        static::updated(function(Model $model) {
            foreach ((array) with(new self)->translatable as $item) {
                $model->{$item} = new Translate($model->{$item}, static::class);
            }
        });

    }

//    public function __get($key)
//    {
//        if (in_array($key, (array) $this->translatable)) {
//            if (array_key_exists($key, $this->attributes) || $this->hasGetMutator($key)) {
//                return new Translate($this->getAttributeValue($key), static::class);
//            }
//        }
//        // TODO: Implement __get() method.
//        return parent::__get($key);
//    }

    /**
     * @param array $attributes
     * @param null $connection
     * @return mixed
     * @author Rytis Grincevičius <rytis.grincevicius@gmail.com>
     */
    public function newFromBuilder($attributes = [], $connection = null)
    {
        $model = parent::newFromBuilder($attributes, $connection);

        foreach ($model->attributes AS $key => $value)
        {
            $override = in_array($key, (array) $this->translatable);

            if ($override) {
                $model->$key = new Translate($value, static::class);
            }
        }

        return $model;
    }

    /**
     * @return bool
     *
     * @author Rytis Grincevičius <rytis@inlu.net>
     */
    public static function hasTranslatableTrait()
    {
        return true;
    }

    /**
     * @return bool
     *
     * @author Rytis Grincevičius <rytis@inlu.net>
     */
    public static function hasTranslatableAttribute()
    {
        return count(self::getTranslatableAttributes()) > 0;
    }

    /**
     * @return array
     *
     * @author Rytis Grincevičius <rytis@inlu.net>
     */
    public static function getTranslatableAttributes()
    {
        return (array) with(new self)->translatable;
    }

    /**
     * @param string|array $attribute
     * @return bool
     *
     * @author Rytis Grincevičius <rytis@inlu.net>
     */
    public static function isAttributeTranslatable($attribute)
    {
        return count(array_diff((array) $attribute, self::getTranslatableAttributes())) === 0;
    }
}
