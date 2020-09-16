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
        'corporation_id', 'user_id',
        'transaction_id', 'item_id', 'measuring_mass_id',
        'unit_of_measurement_id', 'sales_item_price_id', 'quantity'
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
     * The transaction item belongs to a corporation.
     *
     * @return object
     */
    public function corporation()
    {
        return $this->belongsTo(Corporation::class);
    }
    

    /**
     * The transaction item belongs to an item.
     *
     * @return object
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * The transaction item belongs to a measuring mass.
     *
     * @return objct
     */
    public function measuringMass()
    {
        return $this->belongsTo(MeasuringMass::class);
    }

    /**
     * The transaction item belongs to a transaction.
     *
     * @return object
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    /**
     * The transaction item belongs to a sales item price.
     *
     * @return object
     */
    public function salesItemPrice()
    {
        return $this->belongsTo(SalesItemPrice::class);
    }

    /**
     * The transaction item belongs to a unit of measurement.
     *
     * @return object
     */
    public function unitOfMeasurement()
    {
        return $this->belongsTo(UnitOfMeasurement::class);
    }

    /**
     * The transaction item belongs to a user.
     *
     * @return object
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
