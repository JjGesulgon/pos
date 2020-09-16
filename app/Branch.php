<?php

namespace App;

use App\Traits\FilterRelationships;
use App\Traits\Filtering;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use SoftDeletes, Filtering, FilterRelationships;

    /**
     * Branches table.
     *
     * @var string
     */
    protected $table = 'branches';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'corporation_id', 'user_id',
        'name', 'address', 'city',
        'zip_code', 'country', 'telephone_number', 'status'
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
     * The branch has many bills.
     *
     * @return array object
     */
    public function bills()
    {
        return $this->morphMany(Bill::class, 'billable');
    }

    /**
     * The branch belongs to a corporation.
     *
     * @return object
     */
    public function corporation()
    {
        return $this->belongsTo(Corporation::class);
    }

    /**
     * The branch is a cost center.
     *
     * @return object
     */
    public function costCenter()
    {
        return $this->morphMany(CostCenter::class, 'cost_centable');
    }

    /**
     * The branch has many invoices.
     *
     * @return array object
     */
    public function invoices()
    {
        return $this->morphMany(Invoice::class, 'invoiceable');
    }

    /**
     * The branch has a journal.
     *
     * @return object
     */
    public function journal()
    {
        return $this->morphOne(Journal::class, 'journable_from');
    }

    /**
     * The branch has many stocks.
     *
     * @return object
     */
    public function stocks()
    {
        return $this->morphMany(Stock::class, 'stockable');
    }

    /**
     * The branch has many stock receive from.
     *
     * @return array object
     */
    public function stockReceiveFrom()
    {
        return $this->morphMany(StockReceive::class, 'stock_receivable_from');
    }

    /**
     * The branch has many stock receive to.
     *
     * @return array object
     */
    public function stockReceiveTo()
    {
        return $this->morphMany(StockReceive::class, 'stock_receivable_to');
    }

    /**
     * The branch has many stock request from.
     *
     * @return array object
     */
    public function stockRequestFrom()
    {
        return $this->morphMany(StockRequest::class, 'stock_requestable_from');
    }

    /**
     * The branch has many stock request to.
     *
     * @return array object
     */
    public function stockRequestTo()
    {
        return $this->morphMany(StockRequest::class, 'stock_requestable_to');
    }

    /**
     * The branch has many stock transfer from.
     *
     * @return array object
     */
    public function stockTransferableFrom()
    {
        return $this->morphMany(StockTransferable::class, 'stock_transferable_from');
    }

    /**
     * The branch has many stock transfer to.
     *
     * @return array object
     */
    public function stockTransferableTo()
    {
        return $this->morphMany(StockTransferable::class, 'stock_transferable_to');
    }

    /**
     * The branch belongs to a user.
     *
     * @return object
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
