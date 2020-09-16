<?php

namespace App\Http\Controllers;

use App\Http\Resources\MeasuringMassResource;
use App\Repositories\MeasuringMassRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MeasuringMassController extends Controller
{
    /**
     * Measuring mass repository instance.
     *
     * @var App\Repositories\MeasuringMassRepository
     */
    public $meauringMasRepository;
    
    /**
     * Create new instance of measuring mass controller.
     *
     * @param MeasuringMassRepository $meauringMasRepository MeasuringMass repository
     */
    public function __construct(MeasuringMassRepository $meauringMasRepository)
    {
        $this->measuringMassRepository = $meauringMasRepository;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $measuringMass = MeasuringMassResource::collection(
            $this->measuringMassRepository->paginateWithFilters(
                request(),
                request()->per_page,
                request()->order_by
            )
        );
    
        if (! $measuringMass) {
            return response()->json([
                'message' => 'Failed to retrieve resource'
            ], 400);
        }
    
        return $measuringMass;
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
    
        if (! $measuringMass = $this->measuringMassRepository->store($request)) {
            return response()->json([
                'message' => 'Failed to store resource'
            ], 500);
        }
    
        return response()->json([
            'message' => 'Resource successfully stored',
            'measuring_mass' => $measuringMass
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
        if (! $measuringMass = $this->measuringMassRepository->findOrFail($id)) {
            return response()->json([
                'message' => 'Resource does not exist'
            ], 400);
        }
    
        return response()->json([
            'message' => 'Resource successfully retrieve',
            'measuring_mass' => $measuringMass
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
    
        if (! $this->measuringMassRepository->update($request, $id)) {
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
        if (! $this->measuringMassRepository->findOrFail($id)->delete()) {
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
        if (! $this->measuringMassRepository->restore($id)) {
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
        if (! $this->measuringMassRepository->forceDestroy($id)) {
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
        $measuringMass = $this->measuringMassRepository->search($request);
    
        if (! $measuringMass) {
            return response()->json([
                'message' => 'Failed to retrieve resource'
            ], 400);
        }
    
        return $measuringMass;
    }
}
