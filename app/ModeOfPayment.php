<?php

namespace App;

use App\Traits\Filtering;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModeOfPayment extends Model
{
    use SoftDeletes, Filtering;

    /**
     * Mode of payments table.
     *
     * @var string
     */
    protected $table = 'mode_of_payments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'corporation_id', 'user_id',
        'name', 'description'
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
     * The mode of payment has many bill payment.
     *
     * @return array object
     */
    public function billPayments()
    {
        return $this->hasMany(BillPayment::class);
    }

    /**
     * The mode of payment belongs to a corporation.
     *
     * @return object
     */
    public function corporation()
    {
        return $this->belongsTo(Corporation::class);
    }

    /**
     * The mode of payment has many invoice payments.
     *
     * @return array object
     */
    public function invoicePayments()
    {
        return $this->hasMany(InvoicePayment::class);
    }
}
