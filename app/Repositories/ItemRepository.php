<?php

namespace App\Repositories;

use App\Item;

class ItemRepository extends Repository
{
    /**
     * Create new instance of item repository.
     *
     * @param Item Item item model
     */
    public function __construct(Item $item)
    {
        parent::__construct($item);
        $this->item = $item;
    }
     /**
     * Get the items
     *
     * @return array json object
     */
    public function getAll()
    {
        return $this->model->all();
    }
}
