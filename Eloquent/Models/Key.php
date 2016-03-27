<?php

namespace Kiberzauras\Translator\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Key
 *
 * @package Kiberzauras\Translator\Eloquent\Models
 * @author Rytis Grincevičius <rytis.grincevicius@gmail.com>
 * @property integer $id
 * @property string $key
 * @property string $domain
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 */
class Key extends Model
{
    use SoftDeletes;
    protected $guarded = ['id'];
    protected $table = '_translator_keys';
    protected $dates = ['deleted_at'];
    //
}
