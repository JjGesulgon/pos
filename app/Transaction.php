<?php

namespace App;

use App\Traits\Filtering;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes, Filtering;

    /**
    * Transaction table.
    *
    * @var string
    */
    protected $table = 'transactions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'transaction_number', 'total_revenue'
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
            
            $latestTransaction = Transaction::orderBy('created_at', 'DESC')->first();

            if (!$latestTransaction) {
                return $model->transaction_number = '#'.str_pad(1, 8, "0", STR_PAD_LEFT);
            }

            return $model->transaction_number = '#'.str_pad($latestTransaction->id + 1, 8, "0", STR_PAD_LEFT);
        });

        static::updating(function ($model) {
            $model->user_id = auth('api')->user()->id;
        });
    }

    /**
    * The transaction belongs to a user.
    *
    * @return object
    */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The transaction has many transaction items
     *
     * @return array object
     */
    public function transactionItem()
    {
        return $this->hasMany(TransactionItem::class);
    }
}
