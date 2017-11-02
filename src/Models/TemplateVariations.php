<?php
/**
 * Copyright (c) 2016.
 * *
 *  * Created by PhpStorm.
 *  * User: Edo
 *  * Date: 10/3/2016
 *  * Time: 10:44 PM
 *
 */

namespace Btybug\Settings\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed template_id
 * @property string variation_name
 */
class TemplateVariations extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'template_variations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes which using Carbon.
     *
     * @var array
     */
//    protected $dates = ['created_at', 'updated_at'];

    public function template()
    {
//        return $this->belongsTo('');
    }

}
