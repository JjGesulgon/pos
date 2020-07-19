<?php

namespace App\Repositories;

use App\SalesItemPrice;

class SalesItemPriceRepository extends Repository
{
    /**
     * Sales item price
     *
     * App\SalesItemPrice
     */
    protected $salesItemPrice;

    /**
     * Create new instance of sales item price repository.
     *
     * @param SalesItemPrice $salesItemPrice Sales item price model
     */
    public function __construct(SalesItemPrice $salesItemPrice)
    {
        parent::__construct($salesItemPrice);

        $this->salesItemPrice = $salesItemPrice;
    }

    /**
     * Store the data in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return boolean
     */
    public function store($request)
    {
        $salesItemPrice = $this->salesItemPrice->create($request->all());

        $salesItemPrice->item->default_sales_item_price_id = $salesItemPrice->id;
        $salesItemPrice->push();

        return $salesItemPrice;
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
}
