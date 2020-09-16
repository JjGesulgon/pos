<?php

namespace App\Repositories;

use App\Transaction;
use Illuminate\Support\Facades\DB;

class TransactionRepository extends Repository
{
    /**
     * Transaction.
     *
     * App\Transaction
     */
    protected $transaction;

    /**
     * Create new instance of transaction repository.
     *
     * @param Transaction $transaction Transaction model
     */
    public function __construct(Transaction $transaction)
    {
        parent::__construct($transaction);

        $this->transaction = $transaction;
    }

    /**
     * Find the resource using the specified id or else fail.
     *
     * @param  int $id
     * @return json object
     */
    public function findOrFail($id)
    {
        return  $this->transaction->with([
            'transactionableFrom',
            'contact',
            'corporation',
            'user',
            'transactionItems' => function ($query) {
                $query->with('item', 'measuringMass', 'unitOfMeasurement', 'salesItemPrice');
            }
        ])->findOrFail($id);
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
        $length = 10,
        $orderBy = 'desc',
        $removePage = true
    ) {
        if ($orderBy == null) {
            $orderBy = 'desc';
        }

        return $this->transaction->with('contact', 'corporation', 'transactionableFrom', 'user')
        ->filter($request)
        ->orderBy('created_at', $orderBy)
        ->paginate($length)
        ->withPath(
            $this->transaction->createPaginationUrl($request, $removePage)
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
        return DB::transaction(function () use ($request) {
            $transaction = $this->transaction->create($request->all());
            $transactionItems = $transaction->transactionItems()->createMany($request->transaction_items);
            $this->updateStocks($transaction, $transactionItems);
            return $transaction;
        });
    }

    /**
     * Update stocs after successful transaction.
     *
     * @param  object $transaction
     * @param  array  $transactionItems
     * @return boolean
     */
    public function updateStocks($transaction, $transactionItems)
    {
        foreach ($transactionItems as $transactionItem) {
            $stockItem = $transaction->transactionableFrom->stocks()->where('item_id', $transactionItem->item_id)->first();
            $newQuantity = $stockItem->quantity - $transactionItem->quantity;
            $stockItem->update([
                'quantity' => $newQuantity
            ]);
        }
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
