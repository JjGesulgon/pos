<?php

namespace App;

use App\Traits\Filtering;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use SoftDeletes, Filtering;

    /**
    * Items table.
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
    * The item belongs to a user.
    *
    * @return object
    */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The item has many transaction Item.
     *
     * @return object
     */
    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class);
    }
}
