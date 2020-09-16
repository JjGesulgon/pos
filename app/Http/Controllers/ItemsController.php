<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ItemResource;
use App\Repositories\ItemRepository;
use Illuminate\Support\Facades\Validator;

class ItemsController extends Controller
{
    /**
     * Item repository.
     *
     * @var App\Repositories\ItemRepository
     */
    protected $itemRepository;

    /**
     * Create new instance of item controller.
     *
     * @param ItemRepository $itemRepository Item repository
     */
    public function __construct(ItemRepository $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = ItemResource::collection(
            $this->itemRepository->paginateWithFilters(
                request(),
                request()->per_page,
                request()->order_by
            )
        );

        if (! $items) {
            return response()->json([
                'message' => 'Failed to retrieve resource'
            ], 400);
        }

        return $items;
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
            'item_type_id'                  => 'required|integer',
            'item_classification_id'        => 'required|integer',
            'sales_account_id'              => 'integer|nullable',
            'cost_of_goods_sold_account_id' => 'integer|nullable',
            'expense_account_id'            => 'integer|nullable',
            'asset_account_id'              => 'integer|nullable',
            'name'                          => 'required|string|max:255',
            'description'                   => 'nullable|string|max:255',
            'stock_keeping_unit'            => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors'  => $validator->errors()
            ], 400);
        }

        if (! $this->itemRepository->store($request)) {
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
        if (! $item = $this->itemRepository->findOrFail($id)) {
            return response()->json([
                'message' => 'Resource does not exist'
            ], 400);
        }

        return response()->json([
            'message' => 'Resource successfully retrieve',
            'item' => $item
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
            'item_type_id'                  => 'required|integer',
            'item_classification_id'        => 'required|integer',
            'sales_account_id'              => 'integer|nullable',
            'cost_of_goods_sold_account_id' => 'integer|nullable',
            'expense_account_id'            => 'integer|nullable',
            'asset_account_id'              => 'integer|nullable',
            'name'                          => 'required|string|max:255',
            'description'                   => 'nullable|string|max:255',
            'stock_keeping_unit'            => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors'  => $validator->errors()
            ], 400);
        }

        if (! $this->itemRepository->update($request, $id)) {
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
        if (! $this->itemRepository->findOrFail($id)->delete()) {
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
        if (! $this->itemRepository->restore($id)) {
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
        if (! $this->itemRepository->forceDestroy($id)) {
            return response()->json([
                'message' => 'Failed to permanently delete resource'
            ], 400);
        }

        return response()->json([
            'message' => 'Resource successfully deleted permanently'
        ], 200);
    }

    /**
    * Search the specified data from the storage for purchase.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function searchForPurchase(Request $request)
    {
        $items = $this->itemRepository->searchForPurchase($request);

        if (! $items) {
            return response()->json([
                'message' => 'Failed to retrieve resource'
            ], 400);
        }

        return $items;
    }

    /**
    * Search the specified data from the storage for sales.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function searchForSales(Request $request)
    {
        $items = $this->itemRepository->searchForSales($request);

        if (! $items) {
            return response()->json([
                'message' => 'Failed to retrieve resource'
            ], 400);
        }

        return $items;
    }

    /**
     * Search the specified data from the storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $items = $this->itemRepository->search($request);

        if (! $items) {
            return response()->json([
                'message' => 'Failed to retrieve resource'
            ], 400);
        }

        return $items;
    }
}
