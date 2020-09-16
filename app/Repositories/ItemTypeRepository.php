<?php

namespace App\Repositories;

use App\ItemType;

class ItemTypeRepository extends Repository
{
    /**
     * Item type
     *
     * App\ItemType
     */
    protected $itemType;

    /**
     * Create new instance of item type repository.
     *
     * @param ItemType $itemType Item type model
     */
    public function __construct(ItemType $itemType)
    {
        parent::__construct($itemType);

        $this->itemType = $itemType;
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

        return $this->itemType->filter($request)
                            ->with('itemClassification')->orderBy('created_at', $orderBy)
                            ->paginate($length)
                            ->withPath(
                                $this->itemType->createPaginationUrl($request, $removePage)
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
        return $this->itemType->with('itemClassification')->findOrFail($id);
    }
}
