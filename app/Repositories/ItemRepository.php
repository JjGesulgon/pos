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
        $length = 10,
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
                'itemClassification',
                'defaultUnitOfMeasurement',
            )->orderBy('created_at', $orderBy)
            ->paginate($length)
            ->withPath(
                $this->model->createPaginationUrl($request, $removePage)
            );
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
            'defaultUnitOfMeasurement',
            'defaultPurchaseItemPrice',
            'defaultSalesItemPrice'
        )->findOrFail($id);
    }
}
