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
     * Find the resource using the specified id or else fail.
     *
     * @param  int $id
     * @return json object
     */
    public function findOrFail($id)
    {
        return $this->salesItemPrice->with(
            'item',
            'measuringMass',
            'unitOfMeasurement'
        )->findOrFail($id);
    }

    /**
     * Create pagination with filters for the resources.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string                    $orderBy
     * @param  integer                   $length
     * @param  boolean                   $removePage
     * @return array object
     */
    public function paginateWithFilters(
        $request = null,
        $length = 15,
        $orderBy = 'desc',
        $removePage = true
    ) {
        if ($orderBy == null) {
            $orderBy = 'desc';
        }

        return $this->salesItemPrice->filter($request)
        ->with(
            'item',
            'measuringMass',
            'unitOfMeasurement'
        )
        ->orderBy('created_at', $orderBy)
        ->paginate($length)
        ->withPath(
            $this->salesItemPrice->createPaginationUrl($request, $removePage)
        );
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return boolean
     */
    public function update($request, $id)
    {
        $salesItemPrice = $this->salesItemPrice->findOrFail($id);
        
        $salesItemPrice->fill($request->all());
        $salesItemPrice->save();
        $salesItemPrice->item->default_sales_item_price_id = $salesItemPrice->id;
        
        return $salesItemPrice->push();
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
