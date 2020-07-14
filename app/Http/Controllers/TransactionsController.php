<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Repositories\TransactionRepository;
use App\TransactionItem;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionsController extends Controller
{
    /**
     * Transactions repository.
     *
     * @var App\Repositories\TransactionRepository
     */
    protected $transaction;

    /**
     * Create new instance of transaction controller.
     *
     * @param TransactionRepository transaction Transaction repository
     */
    public function __construct(TransactionRepository $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = TransactionResource::collection(
            $this->transaction->paginateWithFilters(request(), request()->per_page, request()->order_by)
        );

        if (! $transactions) {
            return response()->json([
                'message' => 'Failed to retrieve resource'
            ], 400);
        }

        return $transactions;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'total_amount'  => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors'  => $validator->errors()
            ], 400);
        }

        $trans = $this->transaction->store($request);
        
        for ($ctr = 0; $ctr < count($request->cart); $ctr++) {
            $transItem = new TransactionItem;
            $transItem->transaction_id = $trans->id;
            $transItem->item_id = $request->cart[$ctr]['id'];
            $transItem->quantity = $request->cart[$ctr]['qty'];

            $trans->transactionItems()->save($transItem);
        }

        return response()->json([
            'message' => 'Resource successfully stored'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'amount'  => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors'  => $validator->errors()
            ], 400);
        }

        if (! $this->transaction->update($request, $id)) {
            return response()->json([
                'message' => 'Failed to update resource'
            ], 500);
        }

        return response()->json([
            'message' => 'Resource successfully updated'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! $transaction = $this->transaction->getTransaction($id)) {
            return response()->json([
                'message' => 'Resource does not exist'
            ], 400);
        }

        return response()->json([
            'response' => true,
            'message'  => 'Resource successfully retrieve',
            'transaction'    => $transaction
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! $this->transaction->findOrFail($id)->delete()) {
            return response()->json([
                'message' => 'Failed to delete resource'
            ], 400);
        }

        return response()->json([
            'message' => 'Resource successfully deleted'
        ], 200);
    }
}
