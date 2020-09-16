<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ItemTypeResource;
use App\Repositories\ItemTypeRepository;
use Illuminate\Support\Facades\Validator;

class ItemTypesController extends Controller
{
    /**
     * ItemType repository.
     *
     * @var App\Repositories\ItemTypeRepository
     */
    protected $itemTypeRepository;

    /**
     * Create new instance of item type controller.
     *
     * @param ItemTypeRepository $itemTypeRepository Item type repository
     */
    public function __construct(ItemTypeRepository $itemTypeRepository)
    {
        $this->itemTypeRepository = $itemTypeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $itemTypes = ItemTypeResource::collection(
            $this->itemTypeRepository->paginateWithFilters(
                request(),
                request()->per_page,
                request()->order_by
            )
        );

        if (! $itemTypes) {
            return response()->json([
                'message' => 'Failed to retrieve resource'
            ], 400);
        }

        return $itemTypes;
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
            'item_classification_id' => 'required|integer',
            'name'                   => 'required|string|max:255',
            'display_name'           => 'required|string|max:255',
            'description'            => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors'  => $validator->errors()
            ], 400);
        }

        if (! $this->itemTypeRepository->store($request)) {
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
        if (! $itemType = $this->itemTypeRepository->findOrFail($id)) {
            return response()->json([
                'message' => 'Resource does not exist'
            ], 400);
        }

        return response()->json([
            'message'   => 'Resource successfully retrieve',
            'item_type' => $itemType
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
            'item_classification_id' => 'required|integer',
            'name'                   => 'required|string|max:255',
            'display_name'           => 'required|string|max:255',
            'description'            => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors'  => $validator->errors()
            ], 400);
        }

        if (! $this->itemTypeRepository->update($request, $id)) {
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
        if (! $this->itemTypeRepository->findOrFail($id)->delete()) {
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
        if (! $this->itemTypeRepository->restore($id)) {
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
        if (! $this->itemTypeRepository->forceDestroy($id)) {
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
        $itemTypes = $this->itemTypeRepository->search($request);

        if (! $itemTypes) {
            return response()->json([
                'message' => 'Failed to retrieve resource'
            ], 400);
        }

        return $itemTypes;
    }
}
