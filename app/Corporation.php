<?php

namespace App;

use App\Traits\Filtering;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Corporation extends Model
{
    use SoftDeletes, Filtering;

    /**
     * Corporations table.
     *
     * @var string
     */
    protected $table = 'corporations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'street', 'city',
        'state', 'zip_code', 'country', 'fax'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The corporation has many accounts.
     *
     * @return array object
     */
    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    /**
     * The corporation has many audit trails.
     *
     * @return array object
     */
    public function auditTrail()
    {
        return $this->hasMany(AuditTrail::class);
    }

    /**
     * The corporation has many branches.
     *
     * @return array object
     */
    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    /**
     * The corporation has many contacts.
     *
     * @return array object
     */
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    /**
     * The corporation has many contact types.
     *
     * @return array object
     */
    public function contactTypes()
    {
        return $this->hasMany(ContactType::class);
    }

    /**
     * The corporation has many conversions.
     *
     * @return array object
     */
    public function conversions()
    {
        return $this->hasMany(Conversion::class);
    }

    /**
     * The corporation has many invoices.
     *
     * @return array object
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * The corporation has many items.
     *
     * @return array object
     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    /**
     * The corporation has many item classifications.
     *
     * @return array object
     */
    public function itemClassifications()
    {
        return $this->hasMany(ItemClassification::class);
    }

    /**
     * The corporation has many item types.
     *
     * @return array object
     */
    public function itemTypes()
    {
        return $this->hasMany(ItemType::class);
    }

    /**
     * The corporation has many purchase item prices.
     *
     * @return array object
     */
    public function purchaseItemPrices()
    {
        return $this->hasMany(PurchaseItemPrice::class);
    }

    /**
     * The corporation has many purchase orders.
     *
     * @return array object
     */
    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }

    /**
     * The corporation has many receive orders.
     *
     * @return array object
     */
    public function receiveOrders()
    {
        return $this->hasMany(ReceiveOrder::class);
    }

    /**
     * The corporation has many sales item prices.
     *
     * @return array object
     */
    public function salesItemPrices()
    {
        return $this->hasMany(SalesItemPrice::class);
    }

    /**
     * The corporation has many stocks.
     *
     * @return array object
     */
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    /**
     * The corporation has many unit of measurements.
     *
     * @return array object
     */
    public function unitOfMeasurements()
    {
        return $this->hasMany(UnitOfMeasurement::class);
    }

    /**
     * The corporation has many warehouses.
     *
     * @return array object
     */
    public function warehouses()
    {
        return $this->hasMany(Warehouse::class);
    }
}
