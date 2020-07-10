<?php

namespace App\Repositories;

use App\Item;

class ItemRepository extends Repository
{
    /**
     * Create new instance of item repository.
     *
     * @param Item $item Item repository.
     */
    public function __construct(Item $item)
    {
        parent::__construct($item);
        $this->item = $item;
    }
}
