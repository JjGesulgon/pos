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
        'corporation_id', 'user_id',
        'transactionable_from_id', 'transactionable_from_type', 'contact_id',
        'number', 'reference_number', 'total_amount',
        'is_discountable', 'discount_type', 'discount_percent', 'discount_amount',
        'is_taxable', 'is_tax_inclusive', 'tax_type', 'tax_percent', 'tax_amount',
        'grand_total_amount'
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
                return $model->number = '#'.str_pad(1, 8, "0", STR_PAD_LEFT);
            }

            return $model->number = '#'.str_pad($latestTransaction->id + 1, 8, "0", STR_PAD_LEFT);
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
    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class);
    }
}
