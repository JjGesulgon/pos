<?php

namespace App;

use App\Traits\FilterRelationships;
use App\Traits\Filtering;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemType extends Model
{
    use SoftDeletes, Filtering, FilterRelationships;

    /**
     * Item Types table.
     *
     * @var string
     */
    protected $table = 'item_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'corporation_id', 'user_id',
        'item_classification_id', 'name', 'display_name', 'description'
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
     * The item type belongs to a corporation.
     *
     * @return object
     */
    public function corporation()
    {
        return $this->belongsTo(Corporation::class);
    }

    /**
     * The item type has many items.
     *
     * @return array object
     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    /**
     * The item type belongs to an item classification.
     *
     * @return object
     */
    public function itemClassification()
    {
        return $this->belongsTo(ItemClassification::class);
    }

    /**
     * The item type belongs to a user.
     *
     * @return object
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
