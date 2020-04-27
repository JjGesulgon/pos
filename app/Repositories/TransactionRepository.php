<?php

namespace App\Repositories;

use App\Transaction;

class TransactionRepository extends Repository
{
    /**
     * Create new instance of transaction repository.
     *
     * @param Transaction Transaction transaction model
     */
    public function __construct(Transaction $transaction)
    {
        parent::__construct($transaction);
        $this->transaction = $transaction;
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
