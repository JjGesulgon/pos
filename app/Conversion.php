<?php

namespace App;

use App\Traits\Filtering;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Spatie\Activitylog\Traits\LogsActivity;

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
        'corporation_id', 'unit_of_measurement_from_id', 'from_value',
        'unit_of_measurement_to_id', 'to_value'
    ];

    // /**
    //  * The Log attributes that are mass assignable.
    //  *
    //  * @var array
    //  */
    // protected static $logAttributes = [
    //     'corporation_id', 'unit_of_measurement_from_id', 'from_value',
    //     'unit_of_measurement_to_id', 'to_value'
    // ];
    
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
}
