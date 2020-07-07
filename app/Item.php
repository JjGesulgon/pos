<?php

namespace App;

use App\Traits\FilterRelationships;
use App\Traits\Filtering;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use SoftDeletes, Filtering, FilterRelationships;

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
        'corporation_id', 'brand_id', 'item_type_id', 'item_classification_id','name',
        'description', 'stock_keeping_unit', 'identifier', 'default_unit_of_measurement_id',
        'sales_account_id', 'cost_of_goods_sold_account_id', 'expense_account_id', 'asset_account_id',
        'purchase_discounts', 'sales_discounts'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'purchase_discounts' => 'array',
        'sales_discounts' => 'array'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Eager load relationships.
     *
     * @var array
     */
    protected $with = [
        'brand', 'itemType', 'itemClassification', 'defaultUnitOfMeasurement'
    ];

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
                $model->asset_account_id              = 11;
                $model->cost_of_goods_sold_account_id = 9;
                $model->sales_account_id              = 6;
                $model->expense_account_id            = 8;
            }
        });
    }

    /**
     * The item belongs to a brand.
     *
     * @return object
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * The item belongs to a corporation.
     *
     * @return object
     */
    public function corporation()
    {
        return $this->belongsTo(Corporation::class);
    }

    /**
     * The item belongs to an item type.
     *
     * @return object
     */
    public function itemType()
    {
        return $this->belongsTo(ItemType::class);
    }

    /**
     * The item the belongs to an item classification.
     *
     * @return object
     */
    public function itemClassification()
    {
        return $this->belongsTo(ItemClassification::class);
    }

    /**
     * The item belongs to a default unit of measurement.
     *
     * @return object
     */
    public function defaultUnitOfMeasurement()
    {
        return $this->belongsTo(UnitOfMeasurement::class, 'default_unit_of_measurement_id');
    }

    /**
     * The item belongs to a credit memorandum item.
     *
     * @return object
     */
    public function creditMemorandumItems()
    {
        return $this->hasMany(CreditMemorandumItem::class);
    }

    /**
     * The item belongs to a debit memorandum item.
     *
     * @return object
     */
    public function debitMemorandumItems()
    {
        return $this->hasMany(DebitMemorandumItem::class);
    }

    /**
     * The item has many transaction items.
     *
     * @return array object
     */
    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class);
    }
}
