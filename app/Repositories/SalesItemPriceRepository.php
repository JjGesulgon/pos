<?php

namespace App\Repositories;

use App\SalesItemPrice;

class SalesItemPriceRepository extends Repository
{
    /**
     * Create new instance of sales item price repository.
     *
     * @param SalesItemPrice $salesItemPrice SalesItemPrice model
     */
    public function __construct(SalesItemPrice $salesItemPrice)
    {
        parent::__construct($salesItemPrice);
        $this->salesItemPrice = $salesItemPrice;
    }

    /**
     * Retrieve all sales item prices using specified id.
     *
     * @param  int $id id
     * @return array object
     */
    public function getSalesItemPrices($id)
    {
        return $this->salesItemPrice->where('item_id', $id)->get();
    }

    /**
     * Create pagination with filters for the resources.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string                    $orderBy
     * @param  integer                   $length
     * @param  boolean                   $removePage
     * @return array json object
     */
    public function salesItemPriceWithFilters(
        $request = null,
        $length = 10,
        $orderBy = 'desc',
        $removePage = true
    ) {
        if ($orderBy == null) {
            $orderBy = 'desc';
        }

        return $this->salesItemPrice->with(['item' => function($query){
                                        $query->select('id', 'name');
                                    }])
                                    ->filter($request)
                                    ->orderBy('created_at', $orderBy)
                                    ->paginate($length)
                                    ->withPath(
                                        $this->model->createPaginationUrl($request, $removePage)
                                    );
    }
}
