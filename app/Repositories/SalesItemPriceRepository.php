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
}
