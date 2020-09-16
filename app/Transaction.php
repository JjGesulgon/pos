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
     * The transaction belongs to a contact.
     *
     * @return object
     */
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    /**
    * The transaction belongs to a corporation.
    *
    * @return object
    */
    public function corporation()
    {
        return $this->belongsTo(Corporation::class);
    }

    /**
     * The transaction belongs to either a warehouse or a branch.
     *
     * @return object
     */
    public function transactionableFrom()
    {
        return $this->morphTo();
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

    /**
    * The transaction belongs to a user.
    *
    * @return object
    */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
