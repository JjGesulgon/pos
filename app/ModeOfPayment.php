<?php

namespace App;

use App\Traits\Filtering;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModeOfPayment extends Model
{
    use SoftDeletes, Filtering;

    /**
     * Item Types table.
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
        'name', 'description'
    ];

    public function billPayments()
    {
        return $this->belongsToMany(BillPayment::class);
    }
}
