<?php

namespace Sahakavatar\Settings\Models;

use Illuminate\Database\Eloquent\Model;

class Emails extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'emails';

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
    protected $dates = ['created_at', 'updated_at'];

    public function getDates()
    {
        return ['created_at', 'updated_at'];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo('Sahakavatar\Settings\Models\EmailGroups', 'group_id');
    }


    public function scopePublic($query)
    {
        $query->where('is_public', '=', '1');
    }

    public function form()
    {
        return $this->belongsTo('Sahakavatar\Create\Forms', 'form_id');
    }
}
