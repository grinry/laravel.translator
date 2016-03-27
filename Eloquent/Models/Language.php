<?php

namespace Kiberzauras\Translator\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Language
 *
 * @package Kiberzauras\Translator\Eloquent\Models
 * @author Rytis Grincevičius <rytis.grincevicius@gmail.com>
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property integer $active
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 */
class Language extends Model
{
    use SoftDeletes;
    protected $table = '_translator_languages';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];

    public function translate()
    {
        return $this->hasManyThrough(
            'Kiberzauras\Translator\Eloquent\Models\Key',
            'Kiberzauras\Translator\Eloquent\Models\Value',
            'language_id', 'id');
    }
    /**
     * @return int
     * @author Rytis Grincevičius <rytis.grincevicius@gmail.com>
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     * @author Rytis Grincevičius <rytis.grincevicius@gmail.com>
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int
     * @author Rytis Grincevičius <rytis.grincevicius@gmail.com>
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @return string
     * @author Rytis Grincevičius <rytis.grincevicius@gmail.com>
     */
    public function getCode()
    {
        return $this->code;
    }
}
