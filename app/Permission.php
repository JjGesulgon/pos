<?php

namespace App;

use App\Traits\Filtering;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use SoftDeletes, Filtering;

    /**
     * Permissions table.
     *
     * @var string
     */
    protected $table = 'permissions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'corporation_id', 'user_id',
        'name', 'display_name', 'description'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Run functions on boot.
     *
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (request()->headers->get('CORPORATION-ID')) {
                $model->corporation_id = request()->headers->get('CORPORATION-ID');
            }

            if (auth('api')->check()) {
                $model->user_id = auth('api')->user()->id;
            }

            if (request()->headers->get('USER-ID')) {
                $model->user_id = request()->headers->get('USER-ID');
            }
        });
    }

    /**
     * Permissions has many roles.
     *
     * @return array object
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
