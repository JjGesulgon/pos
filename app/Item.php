<?php

namespace App;

use App\Traits\Filtering;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use SoftDeletes, Filtering;

     /**
     * Experience table.
     *
     * @var string
     */
    protected $table = 'items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'name', 'amount', 'stocks_available'
    ];

     /**
     * Run functions on boot.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->user_id = auth('api')->user()->id;
        });

        static::updating(function ($model) {
            $model->user_id = auth('api')->user()->id;
        });
    }

     /**
     * The experience belongs to a user.
     *
     * @return object
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

