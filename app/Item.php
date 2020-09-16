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
        'corporation_id', 'user_id',
        'sales_account_id', 'cost_of_goods_sold_account_id', 'expense_account_id', 'asset_account_id',
        'brand_id', 'item_classification_id', 'item_type_id',
        'name', 'stock_keeping_unit', 'universal_product_code',
        'identifier', 'description',
        'default_purchase_item_price_id', 'default_sales_item_price_id',
        'purchase_discounts', 'sales_discounts'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['name_identifier'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'purchase_discounts' => 'array',
        'sales_discounts'    => 'array'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Get the item's name identifier.
     *
     * @return string
     */
    public function getNameIdentifierAttribute()
    {
        if ($this->identifier == null || $this->identifier == '') {
            return "{$this->brand->display_name} {$this->name} {$this->itemType->display_name}";
        }

        return "{$this->brand->display_name} {$this->name} {$this->identifier} {$this->itemType->display_name}";
    }

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

            if (auth('api')->check()) {
                $model->user_id = auth('api')->user()->id;
            }

            if (request()->headers->get('USER-ID')) {
                $model->user_id = request()->headers->get('USER-ID');
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
     * The item belongs to a credit memorandum item.
     *
     * @return array object
     */
    public function creditMemorandumItems()
    {
        return $this->hasMany(CreditMemorandumItem::class);
    }

    /**
     * The item belongs to a debit memorandum item.
     *
     * @return array object
     */
    public function debitMemorandumItems()
    {
        return $this->hasMany(DebitMemorandumItem::class);
    }

    /**
     * The item belongs to a default purchase item price.
     *
     * @return object
     */
    public function defaultPurchaseItemPrice()
    {
        return $this->belongsTo(PurchaseItemPrice::class, 'default_purchase_item_price_id');
    }

    /**
     * The item belongs to a default sales item price.
     *
     * @return object
     */
    public function defaultSalesItemPrice()
    {
        return $this->belongsTo(SalesItemPrice::class, 'default_sales_item_price_id');
    }

    /**
     * The item has many invoice items.
     *
     * @return array object
     */
    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
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
     * The item belongs to an item type.
     *
     * @return object
     */
    public function itemType()
    {
        return $this->belongsTo(ItemType::class);
    }

    /**
     * The item has many stocks.
     *
     * @return array object
     */
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    /**
     * The item has many purchase item prices.
     *
     * @return array object
     */
    public function purchaseItemPrices()
    {
        return $this->hasMany(PurchaseItemPrice::class);
    }

    /**
     * The item has many quotation items.
     *
     * @return array object
     */
    public function quotationItems()
    {
        return $this->hasMany(QuotationItem::class);
    }

    /**
     * The item has many sales item prices.
     *
     * @return array object
     */
    public function salesItemPrices()
    {
        return $this->hasMany(SalesItemPrice::class);
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

    /**
     * The item belongs to a user.
     *
     * @return object
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
