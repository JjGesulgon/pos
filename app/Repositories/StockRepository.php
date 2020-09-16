<?php

namespace App\Repositories;

use App\Stock;
use App\Branch;
use App\WArehouse;

class StockRepository extends Repository
{
    protected $branch;
    protected $warehouse;

    /**
     * Create new instance of stock repository.
     *
     * @param Stock $stock Stock repository.
     */
    public function __construct(Stock $stock, Branch $branch, Warehouse $warehouse)
    {
        parent::__construct($stock);
        $this->stock = $stock;
        $this->branch = $branch;
        $this->warehouse = $warehouse;
    }

    public function paginateWithFilters(
        $request = null,
        $length = 10,
        $orderBy = 'desc',
        $removePage = true
    ) {
        return $this->model->filter($request)
            ->selectRaw('id, corporation_id, stockable_id, stockable_type, item_id, SUM(quantity) as quantity, unit_of_measurement_id')
            // comment out if need per location
            // ->where('stockable_id', $request->stockable_id)
            // ->where('stockable_type', $request->stockable_type)
            ->groupBy('stockable_type', 'stockable_id', 'item_id', 'corporation_id', 'unit_of_measurement_id', 'id')
            ->orderBy('item_id')
            ->paginate($length)
            ->withPath(
                $this->model->createPaginationUrl($request, $removePage)
            );
    }

    public function paginateWithFiltersPerLocationType(
        $request = null,
        $locationType = null, 
        $length = 10,
        $orderBy = 'desc',
        $removePage = true
    ) {

        if (mb_strtolower($locationType) == 'branch') {
            $locationClass = get_class($this->branch);
        }

        if (mb_strtolower($locationType) == 'warehouse') {
            $locationClass = get_class($this->warehouse);
        }

        return $this->model->filter($request)
        ->where('stockable_type', $locationClass)
        ->selectRaw('corporation_id, stockable_id, stockable_type, item_id, SUM(quantity) as quantity, unit_of_measurement_id')
        ->groupBy('stockable_type', 'stockable_id', 'item_id', 'corporation_id', 'unit_of_measurement_id')
        ->orderBy('item_id')
        ->paginate($length)
        ->withPath(
            $this->model->createPaginationUrl($request, $removePage)
        );
    }

    public function paginatePerItemWithFilters(
        $request = null,
        $id,
        $length = 10,
        $orderBy = 'desc',
        $removePage = true
    ) {
        return $this->model->filter($request)
            ->where('item_id', $id)
            // comment out if need per location
            // ->where('stockable_id', $request->stockable_id)
            // ->where('stockable_type', $request->stockable_type)
            ->orderBy('created_at', $orderBy)
            ->paginate($length)
            ->withPath(
                $this->model->createPaginationUrl($request, $removePage)
            );
    }
}
