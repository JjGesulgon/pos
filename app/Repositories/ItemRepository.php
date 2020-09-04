<?php

namespace App\Repositories;

use App\Item;

class ItemRepository extends Repository
{
    /**
     * Item
     *
     * App\Item
     */
    protected $item;

    /**
     * Create new instance of item repository.
     *
     * @param Item $item Item model
     */
    public function __construct(Item $item)
    {
        parent::__construct($item);

        $this->item = $item;
    }

    /**
     * Find the resource using the specified id or else fail.
     *
     * @param  int $id
     * @return json object
     */
    public function findOrFail($id)
    {
        return $this->item->with(
            'brand',
            'itemType',
            'itemClassification',
            'defaultPurchaseItemPrice',
            'defaultSalesItemPrice'
        )->findOrFail($id);
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
    public function paginateWithFilters(
        $request = null,
        $length = 15,
        $orderBy = 'desc',
        $removePage = true
    ) {
        if ($orderBy == null) {
            $orderBy = 'desc';
        }

        return $this->item->filter($request)
        ->with(
            'brand',
            'itemType',
            'itemClassification'
        )->orderBy('created_at', $orderBy)
        ->paginate($length)
        ->withPath(
            $this->item->createPaginationUrl($request, $removePage)
        );
    }

    /**
     * Search items for purchase.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string                    $orderBy
     * @param  integer                   $length
     * @param  boolean                   $removePage
     * @return array json object
     */
    public function searchForPurchase(
        $request = null,
        $length = 15,
        $orderBy = 'desc',
        $removePage = true
    ) {
        if ($orderBy == null) {
            $orderBy = 'desc';
        }

        return $this->item->filter($request)
        ->with(
            'brand',
            'defaultPurchaseItemPrice'
        )->orderBy('created_at', $orderBy)
        ->limit($length)
        ->get();
    }

    /**
     * Search items for sales.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string                    $orderBy
     * @param  integer                   $length
     * @param  boolean                   $removePage
     * @return array json object
     */
    public function searchForSales(
        $request = null,
        $length = 15,
        $orderBy = 'desc',
        $removePage = true
    ) {
        if ($orderBy == null) {
            $orderBy = 'desc';
        }

        if (count($request->all()) == 0) {
            return;
        }

        return $this->item->filter($request)
        ->with(
            'brand',
            'defaultSalesItemPrice'
        )
        ->whereHas('stocks', function ($query) {
            $query->where('quantity', '>=', 1);
        })
        ->orderBy('created_at', $orderBy)
        ->limit($length)
        ->get();
    }
}
