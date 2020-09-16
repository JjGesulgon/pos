<?php

namespace App\Repositories;

use App\Warehouse;
use Illuminate\Support\Facades\DB;

class WarehouseRepository extends Repository
{
    /**
     * Warehouse
     *
     * App\Warehouse
     */
    protected $warehouse;

    /**
     * Create new instance of warehouse repository.
     *
     * @param Warehouse $warehouse Warehouse model
     */
    public function __construct(Warehouse $warehouse)
    {
        parent::__construct($warehouse);

        $this->warehouse = $warehouse;
    }

    /**
     * Store the data in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return boolean
     */
    public function store($request)
    {
        return DB::transaction(function () use ($request) {
            $warehouse = $this->warehouse->create($request->all());
            $warehouse->costCenter()->create($warehouse->toArray());

            return $warehouse;
        });
    }
}
