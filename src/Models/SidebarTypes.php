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

/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 7/18/2016
 * Time: 10:51 PM
 */

namespace Sahakavatar\Settings\Models;

use Illuminate\Database\Eloquent\Model;


class SidebarTypes extends Model
{
    protected $table = 'sidebar_types';

    protected $fillable = ['title', 'status'];

    protected $dates = ['created_at', 'updated_at'];

    public function sidebars()
    {
        return $this->hasMany('Sahakavatar\Settings\Models\Sidebar', 'sidebar_type_id');
    }

    public function scopeExtra($model)
    {
        return $model->where('status', 1);
    }
}