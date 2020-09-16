<?php

namespace App;

use App\Traits\FilterRelationships;
use App\Traits\Filtering;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesItemPrice extends Model
{
    use SoftDeletes, Filtering, FilterRelationships;

    /**
     * Sales item prices table.
     *
     * @var string
     */
    protected $table = 'sales_item_prices';

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
     * The sales item price belongs to a corporation.
     *
     * @return object
     */
    public function corporation()
    {
        return $this->belongsTo(Corporation::class);
    }

    /**
     * The sales item price has many credit memorandum items.
     *
     * @return array object
     */
    public function creditMemorandumItems()
    {
        return $this->hasMany(CreditMemorandumItem::class);
    }

    /**
     * The sales item price belongs to an item.
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
     * The sales item price has many invoice items.
     *
     * @return array object
     */
    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    /**
     * The sales item price has many quotation items.
     *
     * @return array object
     */
    public function quotationItems()
    {
        return $this->hasMany(QuotationItem::class);
    }

    /**
     * The sales item price belongs to a unit of measurement.
     *
     * @return object
     */
    public function unitOfMeasurement()
    {
        return $this->belongsTo(UnitOfMeasurement::class);
    }

    /**
     * The sales item price belongs to a user.
     *
     * @return object
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
