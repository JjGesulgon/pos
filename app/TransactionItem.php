<?php

namespace App;

use App\Traits\Filtering;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionItem extends Model
{
    use SoftDeletes, Filtering;

     /**
     * Items table.
     *
     * @var string
     */
    protected $table = 'transaction_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'transaction_id', 'item_id'
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
     * The Transaction Item belongs to a user.
     *
     * @return object
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

     /**
     * Transaction Item belongs to a transaction.
     * 
     * @return object
     */
    public function transactionItem()
    {
        return $this->belongsTo(Transaction::class);
    }

    /**
     * Transaction Item belongs to one item.
     * 
     * @return object
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}

