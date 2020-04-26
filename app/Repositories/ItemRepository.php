<?php

namespace App\Repositories;

use App\Item;

class ItemRepository extends Repository
{
    /**
     * Create new instance of skill repository.
     *
     * @param Item Skill skill model
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
