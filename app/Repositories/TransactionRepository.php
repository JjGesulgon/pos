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

    /**
     * Get the transaction with transaction items with items
     *
     * @return array json object
     */
    public function getTransaction($id)
    {
        $transaction = $this->transaction::with('transactionItems.item')->findOrFail($id);
        return $transaction;
    }

    /**
     * Get the transaction filtered by date range
     *
     * @return array json object
     */
    public function getTotalTransaction($request)
    {        
        $transaction = $this->transaction
                            ->whereBetween('created_at', [$request->startDate, $request->endDate])
                            ->get();
        return $transaction;
    }
}
