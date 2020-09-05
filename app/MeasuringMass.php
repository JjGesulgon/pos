<?php

namespace App;

use App\Traits\Filtering;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MeasuringMass extends Model
{
    use Filtering, SoftDeletes;
    
    /**
     * Measuring mass table.
     *
     * @var string
     */
    protected $table = 'measuring_mass';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'corporation_id', 'user_id' , 'mass'
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
     * The measuring mass belongs to a corporation.
     *
     * @return object
     */
    public function corporation()
    {
        return $this->belongsTo(Corporation::class);
    }

    /**
     * The measuring mass has many credit memorandum items.
     *
     * @return array object
     */
    public function creditMemorandumItems()
    {
        return $this->hasMany(CreditMemorandumItem::class);
    }

    /**
     * The measuring mass has many debit memorandum items.
     *
     * @return array object
     */
    public function debitMemorandumItems()
    {
        return $this->hasMany(DebitMemorandumItem::class);
    }

    /**
     * The measuring mass has many invoice items.
     *
     * @return array object
     */
    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    /**
     * The measuring mass has many purchase item prices.
     *
     * @return array object
     */
    public function purchaseItemPrices()
    {
        return $this->hasMany(PurchaseItemPrice::class);
    }

    /**
     * The measuring mass has many purchase order items.
     *
     * @return array object
     */
    public function purchaseOrderItems()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    /**
     * The measuring mass has many quotation items.
     *
     * @return array object
     */
    public function quotationItems()
    {
        return $this->hasMany(QuotationItem::class);
    }

    /**
     * The measuring mass has many receive order items.
     *
     * @return array object
     */
    public function receiveOrderItems()
    {
        return $this->hasMany(ReceiveOrderItem::class);
    }

    /**
     * The measuring mass has many sales item prices.
     *
     * @return array object
     */
    public function salesItemPrices()
    {
        return $this->hasMany(SalesItemPrice::class);
    }

    /**
     * The measuring mass has many stock receive items.
     *
     * @return array object
     */
    public function stockReceiveItems()
    {
        return $this->hasMany(StockReceiveItem::class);
    }

    /**
     * The measuring mass has many stock request items.
     *
     * @return array object
     */
    public function stockRequestItems()
    {
        return $this->hasMany(StockRequestItem::class);
    }

    /**
     * The measuring mass has many stock transfer items.
     *
     * @return array object
     */
    public function stockTransferItems()
    {
        return $this->hasMany(StockTransferItem::class);
    }

    /**
     * The measuring mass belongs to a user.
     *
     * @return object
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
