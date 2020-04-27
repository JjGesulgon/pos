<?php

namespace App\Repositories;

use App\TransactionItem;

class TransactionItemRepository extends Repository
{
    /**
     * Create new instance of transactionItem repository.
     *
     * @param TransactionItem TransactionItem transactionItem model
     */
    public function __construct(TransactionItem $transactionItem)
    {
        parent::__construct($transactionItem);
        $this->transactionItem = $transactionItem;
    }
     /**
     * Get the transactions
     *
     * @return array json object
     */
    public function getAll()
    {
        return $this->model->all();
    }
}
