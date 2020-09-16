<?php

namespace App;

use App\Traits\Filtering;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conversion extends Model
{
    use SoftDeletes, Filtering;

    /**
     * Conversions table.
     *
     * @var string
     */
    protected $table = 'conversions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'corporation_id', 'user_id',
        'unit_of_measurement_from_id', 'from_value',
        'unit_of_measurement_to_id', 'to_value'
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
        'convertFrom', 'convertTo'
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

            if (auth('api')->check()) {
                $model->user_id = auth('api')->user()->id;
            }

            if (request()->headers->get('USER-ID')) {
                $model->user_id = request()->headers->get('USER-ID');
            }
        });
    }

    /**
     * The conversion belongs to a corporation.
     *
     * @return object
     */
    public function corporation()
    {
        return $this->belongsTo(Corporation::class);
    }

    /**
     * The conversion from belongs to a unit of measurement.
     *
     * @return object
     */
    public function convertFrom()
    {
        return $this->belongsTo(UnitOfMeasurement::class, 'unit_of_measurement_from_id');
    }

    /**
     * The conversion to belongs to a unit of measurement.
     *
     * @return object
     */
    public function convertTo()
    {
        return $this->belongsTo(UnitOfMeasurement::class, 'unit_of_measurement_to_id');
    }

    /**
     * The conversion belongs to a user.
     *
     * @return object
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
