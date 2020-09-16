<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\UnitOfMeasurementResource;
use App\Repositories\UnitOfMeasurementRepository;

class UnitOfMeasurementsController extends Controller
{
    /**
     * UnitOfMeasurement repository.
     *
     * @var App\Repositories\UnitOfMeasurementRepository
     */
    protected $unitOfMeasurement;

    /**
     * Create new instance of unit of measurement controller.
     *
     * @param UnitOfMeasurementRepository unitOfMeasurement UnitOfMeasurement repository
     */
    public function __construct(UnitOfMeasurementRepository $unitOfMeasurement)
    {
        $this->unitOfMeasurementRepository = $unitOfMeasurement;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $unitOfMeasurements = UnitOfMeasurementResource::collection(
            $this->unitOfMeasurementRepository->paginateWithFilters(
                request(),
                request()->per_page,
                request()->order_by
            )
        );

        if (! $unitOfMeasurements) {
            return response()->json([
                'message' => 'Failed to retrieve resource'
            ], 400);
        }

        return $unitOfMeasurements;
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
            'name'          =>  'required|string|min:3|max:255',
            'abbreviation'  =>  'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors'  => $validator->errors()
            ], 400);
        }

        if (! $this->unitOfMeasurementRepository->store($request)) {
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
        if (! $unitOfMeasurement = $this->unitOfMeasurementRepository->findOrFail($id)) {
            return response()->json([
                'message' => 'Resource does not exist'
            ], 400);
        }

        return response()->json([
            'message' => 'Resource successfully retrieve',
            'unit_of_measurement' => $unitOfMeasurement
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
            'name'          =>  'required|string|min:3|max:255',
            'abbreviation'  =>  'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors'  => $validator->errors()
            ], 400);
        }

        if (! $this->unitOfMeasurementRepository->update($request, $id)) {
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
        if (! $this->unitOfMeasurementRepository->findOrFail($id)->delete()) {
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
        if (! $this->unitOfMeasurementRepository->restore($id)) {
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
        if (! $this->unitOfMeasurementRepository->forceDestroy($id)) {
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
        $unitOfMeasurements = $this->unitOfMeasurementRepository->search($request);

        if (! $unitOfMeasurements) {
            return response()->json([
                'message' => 'Failed to retrieve resource'
            ], 400);
        }

        return $unitOfMeasurements;
    }
}
