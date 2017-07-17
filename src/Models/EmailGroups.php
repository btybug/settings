<?php

namespace App\Modules\Settings\Models;

use Illuminate\Database\Eloquent\Model;
use App\helpers\setres;

use Response;

class EmailGroups extends Model
{
    protected $setres = '';
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'email_groups';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'name', 'slug'];


    /**
     * Delete emails on delete media
     *
     */
    public static function boot()
    {
        parent::boot();
        static::deleted(
        /**
         * @param $group
         */
            function ($group) {
                foreach ($group->emails as $email) {
                    $email->delete();
                }
            }
        );
    }

    public function emails()
    {
        return $this->hasMany('App\Modules\Settings\Models\Emails', 'group_id', 'id');
    }


    /**
     * @param array $request
     * @param string $rtype
     * @return \Illuminate\Http\JsonResponse
     */
    public function findGroups($request = [], $rtype = 'array')
    {
        $models = self::where('id', '>', 0);
        if (isset($request->type)) {
            $models->where('type', $request->type);
        }
        if (isset($request->find)) {
            $models->where('name', 'like', '%' . $request->find . '%');
            $models->orwhere('slug', 'like', '%' . $request->find . '%');
        }
        $models = $models->get();
        $response['code'] = '200';
        $response['msg'] = 'Find Data correctly';

        return setres::format_result($models, $rtype);
    }

    /**
     * @param $id
     * @param string $rtype
     * @return mixed
     */
    public function findGroup($id, $rtype = 'array')
    {
        $response = [];
        if (!$id) {
          return null;
        } else {
            $model = self::find($id);
            if (!$model) {
                return null;
            }
        }
        return setres::format_result($model, $rtype);
    }

}
