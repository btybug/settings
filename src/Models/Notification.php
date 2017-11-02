<?php

namespace Btybug\Settings\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Notification.
 *
 * @property int to_id
 * @property string to_type
 * @property int from_id
 * @property string from_type
 * @property int category_id
 * @property int read
 * @property string url
 * @property string extra
 *
 * Php spec complain when model is mocked
 * if I turn them on as php doc block
 *
 * @method wherePolymorphic
 * @method withNotRead
 */
class Notification extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'to_id',
        'to_type',
        'from_id',
        'from_type',
        'category_id',
        'read',
        'url',
        'extra',
        'expire_time',
        'stack_id',
    ];

    /**
     * Notification constructor.
     *
     * @param array $attributes
     */
    public function __construct()
    {
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function body()
    {
        return $this->belongsTo('Btybug\Settings\Models\NotificationCategory', 'category_id');
    }

    /**
     * Not read scope.
     *
     * @param $query
     * @return mixed
     */
    public function scopeWithNotRead($query)
    {
        return $query->where('read', 0);
    }

    /**
     * Only Expired Notification scope.
     *
     * @param $query
     * @return mixed
     */
    public function scopeOnlyExpired($query)
    {
        return $query->where('expire_time', '<', Carbon::now());
    }


    /**
     * Filter Scope by category.
     *
     * @param $query
     * @param $category
     * @return mixed
     */
    public function scopeByCategory($query, $category)
    {
        if (is_numeric($category)) {
            return $query->where('category_id', $category);
        }

        return $query->whereHas(
            'body',
            function ($categoryQuery) use ($category) {
                $categoryQuery->where('name', $category);
            }
        );
    }

}
