<?php

namespace Btybug\Settings\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class NotificationCategory.
 *
 * @property int id
 * @property string name
 * @property string text
 */
class NotificationCategory extends Model
{
    /**
     * @var string
     */
    protected $table = 'notification_categories';

    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Relation with the notifications.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notifications()
    {
        return $this->hasMany('Btybug\Settings\Models\Notification', 'category_id');
    }


}
