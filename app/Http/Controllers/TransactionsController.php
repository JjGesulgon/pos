<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Repositories\TransactionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionsController extends Controller
{
    /**
     * Transaction repository instance.
     *
     * @var App\Repositories\TransactionRepository
     */
    public $transactionRepository;
    
    /**
     * Create new instance of transactions controller.
     *
     * @param TransactionRepository $transactionRepository Transaction repository
     */
    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = TransactionResource::collection(
            $this->transactionRepository->paginateWithFilters(
                request(),
                request()->per_page,
                request()->order_by
            )
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
            'contact_id'                                 => 'required|integer',
            'transactionable_from_id'                    => 'required|integer',
            'transactionable_from_type'                  => 'required|string|max:255',
            'number'                                     => 'required|string|max:255',
            'reference_number'                           => 'required|string|max:255',
            'total_amount'                               => 'required|numeric|min:1',
            'transaction_items.*.item_id'                => 'required|integer',
            'transaction_items.*.measuring_mass_id'      => 'required|integer',
            'transaction_items.*.unit_of_measurement_id' => 'required|integer',
            'transaction_items.*.quantity'               => 'required|numeric|min:1',
            'transaction_items.*.sales_item_price_id'    => 'required|integer',
            'grand_total_amount'                         => 'required|numeric|min:1'
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors'  => $validator->errors()
            ], 400);
        }
    
        if (! $transaction = $this->transactionRepository->store($request)) {
            return response()->json([
                'message' => 'Failed to store resource'
            ], 500);
        }
    
        return response()->json([
            'message' => 'Resource successfully stored',
            'transaction' => $transaction
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
        if (! $transaction = $this->transactionRepository->findOrFail($id)) {
            return response()->json([
                'message' => 'Resource does not exist'
            ], 400);
        }
    
        return response()->json([
            'message' => 'Resource successfully retrieve',
            'transaction' => $transaction
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
            
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors'  => $validator->errors()
            ], 400);
        }
    
        if (! $this->transactionRepository->update($request, $id)) {
            return response()->json([
                'message' => 'Failed to update resource'
            ], 500);
        }
    
        return response()->json([
            'message' => 'Resource successfully updated'
        ], 200);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! $this->transactionRepository->findOrFail($id)->delete()) {
            return response()->json([
                'message' => 'Failed to delete resource'
            ], 400);
        }
    
        return response()->json([
            'message' => 'Resource successfully deleted'
        ], 200);
    }
    
    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! $this->transactionRepository->restore($id)) {
            return response()->json([
                'message' => 'Failed to restore resource'
            ], 400);
        }
    
        return response()->json([
            'message' => 'Resource successfully restored'
        ], 200);
    }
    
    /**
     * Forcefully remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function forceDestroy($id)
    {
        if (! $this->transactionRepository->forceDestroy($id)) {
            return response()->json([
                'message' => 'Failed to permanently delete resource'
            ], 400);
        }
    
        return response()->json([
            'message' => 'Resource successfully deleted permanently'
        ], 200);
    }
    
    /**
     * Search the specified data from the storage.
     *
     * @param  \Illuminate\Http\Request   $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $transactions = $this->transactionRepository->search($request);
    
        if (! $transactions) {
            return response()->json([
                'message' => 'Failed to retrieve resource'
            ], 400);
        }
    
        return $transactions;
    }

    /**
     * Search the specified data from the storage.
     *
     * @param  \Illuminate\Http\Request   $request
     * @return \Illuminate\Http\Response
     */
    public function getTotalTransactions(Request $request)
    {
        $totalTransactions = $this->transactionRepository->getTotalTransactions($request);
    
        if (! $totalTransactions) {
            return response()->json([
                'message' => 'Failed to retrieve resource'
            ], 400);
        }
    
        return $totalTransactions;
    }
}
