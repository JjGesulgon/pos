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
    protected $item;

    /**
     * Create new instance of item controller.
     *
     * @param ItemRepository item Item repository
     */
    public function __construct(ItemRepository $item)
    {
        $this->item = $item;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = ItemResource::collection(
            $this->item->paginateWithFilters(request(), request()->per_page, request()->order_by)
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
            'item_type_id'                   => 'required|integer',
            'item_classification_id'         => 'required|integer',
            'default_unit_of_measurement_id' => 'required|integer',
            'sales_account_id'               => 'integer|nullable',
            'cost_of_goods_sold_account_id'  => 'integer|nullable',
            'expense_account_id'             => 'integer|nullable',
            'asset_account_id'               => 'integer|nullable',
            'name'                           => 'required|string|max:255',
            'description'                    => 'required|string|max:255',
            'stock_keeping_unit'             => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors'  => $validator->errors()
            ], 400);
        }

        if (! $this->item->store($request)) {
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
        if (! $item = $this->item->findOrFail($id)) {
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
            'item_type_id'                   => 'required|integer',
            'item_classification_id'         => 'required|integer',
            'default_unit_of_measurement_id' => 'required|integer',
            'sales_account_id'               => 'integer|nullable',
            'cogs_account_id'                => 'integer|nullable',
            'expense_account_id'             => 'integer|nullable',
            'asset_account_id'               => 'integer|nullable',
            'name'                           => 'required|string|max:255',
            'description'                    => 'required|string|max:255',
            'stock_keeping_unit'             => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors'  => $validator->errors()
            ], 400);
        }

        if (! $this->item->update($request, $id)) {
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
        if (! $this->item->findOrFail($id)->delete()) {
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
        if (! $this->item->restore($id)) {
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
        if (! $this->item->forceDestroy($id)) {
            return response()->json([
                'message' => 'Failed to permanently delete resource'
            ], 400);
        }

        return response()->json([
            'message' => 'Resource successfully deleted permanently'
        ], 200);
    }

    /**
     * Retrieve all resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllItems()
    {
        if (cache()->has('items')) {
            return response()->json([
                'response' => true,
                'message'  => 'Resources successfully retrieve.',
                'items'    => cache('items', 5)
            ], 200);
        }

        if (! $items = $this->item->all()) {
            return response()->json([
                'response' => false,
                'message'  => 'Resources does not exist.'
            ], 400);
        }

        return response()->json([
            'response' => true,
            'message'  => 'Resources successfully retrieve.',
            'items'    => $items
        ], 200);
    }
}
