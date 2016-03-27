<?php

namespace Kiberzauras\Translator\Eloquent\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kiberzauras\Translator\Translator;

/**
 * Class Value
 *
 * @package Kiberzauras\Translator\Eloquent\Models
 * @author Rytis Grincevičius <rytis.grincevicius@gmail.com>
 * @property integer $id
 * @property integer $language_id
 * @property integer $key_id
 * @property string $value
 * @property string $domain
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 */
class Value extends Model
{
    use SoftDeletes;
    protected $table = '_translator_values';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];

    /**
     * @author Rytis Grincevičius <rytis.grincevicius@gmail.com>
     */
    public static function boot()
    {
        parent::boot();
        //static::addGlobalScope('currentLocale', function(Builder $builder) {
         //   $builder->where('language_id', '=', Translator::getLocale());
        //});
    }

    public function key()
    {
        return $this->hasOne('Kiberzauras\Translator\Eloquent\Models\Key', 'id', 'key_id');
    }

    public function language()
    {
        return $this->hasOne('Kiberzauras\Translator\Eloquent\Models\Language', 'id', 'language_id');
    }
}
