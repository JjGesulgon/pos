<?php

namespace App\Http\Controllers;

use App\Http\Resources\SalesItemPriceResource;
use App\Repositories\SalesItemPriceRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SalesItemPricesController extends Controller
{
    /**
     * SalesItemPrice repository.
     *
     * @var App\Repositories\SalesItemPriceRepository
     */
    protected $salesItemPrice;
    
    /**
     * Create new instance of sales item price controller.
     *
     * @param SalesItemPriceRepository $salesItemPrice
     */
    public function __construct(SalesItemPriceRepository $salesItemPrice)
    {
        $this->salesItemPriceRepository = $salesItemPrice;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $salesItemPrices = SalesItemPriceResource::collection(
            $this->salesItemPriceRepository->paginateWithFilters(
                request(),
                request()->per_page,
                request()->order_by
            )
        );

        if (! $salesItemPrices) {
            return response()->json([
                'message' => 'Failed to retrieve resource'
            ], 400);
        }
    
        return $salesItemPrices;
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
            
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors'  => $validator->errors()
            ], 400);
        }
    
        if (! $this->salesItemPriceRepository->store($request)) {
            return response()->json([
                'message' => 'Failed to store resource'
            ], 500);
        }
    
        return response()->json([
            'message' => 'Resource successfully stored'
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
        if (! $salesItemPrice = $this->salesItemPriceRepository->findOrFail($id)) {
            return response()->json([
                'message' => 'Resource does not exist'
            ], 400);
        }
    
        return response()->json([
            'message'          => 'Resource successfully retrieve',
            'sales_item_price' => $salesItemPrice
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
    
        if (! $this->salesItemPriceRepository->update($request, $id)) {
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
        if (! $this->salesItemPriceRepository->findOrFail($id)->delete()) {
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
        if (! $this->salesItemPriceRepository->restore($id)) {
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
        if (! $this->salesItemPriceRepository->forceDestroy($id)) {
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $salesItemPrice = $this->salesItemPriceRepository->search($request);

        if (! $salesItemPrice) {
            return response()->json([
                'message' => 'Failed to retrieve resource'
            ], 400);
        }

        return $salesItemPrice;
    }
}
