<?php

namespace App;

use App\Traits\FilterRelationships;
use App\Traits\Filtering;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnitOfMeasurement extends Model
{
    use SoftDeletes, Filtering, FilterRelationships;

    /**
     * Unit Of Measurement table.
     *
     * @var string
     */
    protected $table = 'unit_of_measurements';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'corporation_id', 'user_id',
        'name', 'abbreviation'
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
     * The unif of measurement has many bill items.
     *
     * @return array object
     */
    public function billItems()
    {
        return $this->hasMany(BillItem::class);
    }

    /**
     * The unit of measurement belongs to a corporation.
     *
     * @return object
     */
    public function corporation()
    {
        return $this->belongsTo(Corporation::class);
    }

    /**
     * The unit of measurement has many credit memorandum items.
     *
     * @return array object
     */
    public function creditMemorandumItems()
    {
        return $this->hasMany(CreditMemorandumItems::class);
    }

    /**
     * The unif of measurement has many conversions.
     *
     * @return array object
     */
    public function conversions()
    {
        return $this->hasMany(Conversion::class);
    }

    /**
     * The unit of measurement has many debit memorandum items.
     *
     * @return array object
     */
    public function debitMemorandumItems()
    {
        return $this->hasMany(DebitMemorandumItems::class);
    }

    /**
     * The unit of measurement has many purchase item prices.
     *
     * @return array object
     */
    public function purchaseItemPrices()
    {
        return $this->hasMany(PurchaseItemPrices::class);
    }

    /**
     * The unit of measurement has many purchase order items.
     *
     * @return array object
     */
    public function purchaseOrderItems()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    /**
     * The unit of measurement has many receive order items.
     *
     * @return array object
     */
    public function receiveOrderItems()
    {
        return $this->hasMany(ReceiveOrderItem::class);
    }

    /**
     * The unit of measurement has many sales item prices.
     *
     * @return array object
     */
    public function salesItemPrices()
    {
        return $this->hasMany(SalesItemPrices::class);
    }

    /**
     * The unit of measurement belongs to a user.
     *
     * @return object
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
