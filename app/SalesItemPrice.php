<?php

namespace App;

use App\Traits\Filtering;
use App\Traits\FilterRelationships;
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
        'corporation_id', 'item_id', 'price'
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
        'item'
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
     * The sales item price belongs to an item.
     *
     * @return object
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function invoiceItems()
    {
        return $this->belongsToMany(InvoiceItem::class);
    }

    public function creditMemorandumItems()
    {
        return $this->belongsToMany(CreditMemorandumItem::class);
    }

}
