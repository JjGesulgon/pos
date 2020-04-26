<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ItemResource;
use App\Repositories\ItemRepository;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ItemsController extends Controller
{
    /**
     * Items repository.
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
        $item = ItemResource::collection(
            $this->item->paginateWithFilters(request(), request()->per_page, request()->order_by)
        );

        if (! $item) {
            return response()->json([
                'message' => 'Failed to retrieve resource'
            ], 400);
        }

        return $item;
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
            'name'    => 'required|string|max:255',
            'amount'  => 'required|numeric',
            'stocks_available'  => 'required|numeric',
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'    => 'required|string|max:255',
            'amount'  => 'required|numeric',
            'stocks_available'  => 'required|numeric',
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
            'response' => true,
            'message'  => 'Resource successfully retrieve',
            'item'    => $item
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $item
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
}
