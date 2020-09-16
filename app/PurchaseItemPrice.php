<?php

namespace App;

use App\Traits\FilterRelationships;
use App\Traits\Filtering;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseItemPrice extends Model
{
    use SoftDeletes, Filtering, FilterRelationships;

    /**
     * Purchase item prices table.
     *
     * @var string
     */
    protected $table = 'purchase_item_prices';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'corporation_id', 'user_id',
        'item_id', 'measuring_mass_id',
        'unit_of_measurement_id', 'price'
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
     * The purchase item price belongs to a corporation.
     *
     * @return object
     */
    public function corporation()
    {
        return $this->belongsTo(Corporation::class);
    }

    /**
     * The purchase item price has many bill items.
     *
     * @return array object
     */
    public function billItems()
    {
        return $this->hasMany(BillItem::class);
    }

    /**
     * The purchase item price has many debit memorandrum items.
     *
     * @return array object
     */
    public function debitMemorandumItems()
    {
        return $this->hasMany(DebitMemorandumItem::class);
    }

    /**
     * The purchase item price belongs to an item.
     *
     * @return object
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * The purchase item price belongs to a measuring mass.
     *
     * @return object
     */
    public function measuringMass()
    {
        return $this->belongsTo(MeasuringMass::class);
    }

    /**
     * The purchase item price has many purchase order items.
     *
     * @return array object
     */
    public function purchaseOrderItems()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    /**
     * The purchase item price has many receive order items.
     *
     * @return array object
     */
    public function receiveOrderItems()
    {
        return $this->hasMany(ReceiveOrderItem::class);
    }

    /**
     * The purchase item price belongs to a unit of measurement.
     *
     * @return object
     */
    public function unitOfMeasurement()
    {
        return $this->belongsTo(UnitOfMeasurement::class);
    }

    /**
     * The purchase item price belongs to a user.
     *
     * @return object
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
