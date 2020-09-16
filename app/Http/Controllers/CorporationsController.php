<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\CorporationResource;
use App\Repositories\CorporationRepository;

class CorporationsController extends Controller
{
    /**
     * Corporation repository.
     *
     * @var App\Repositories\CorporationRepository
     */
    protected $corporation;

    /**
     * Create new instance of corporation controller.
     *
     * @param CorporationRepository $corporation Corporation repository
     */
    public function __construct(CorporationRepository $corporation)
    {
        $this->corporation = $corporation;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = CorporationResource::collection(
            $this->corporation->paginateWithFilters(request(), request()->per_page, request()->order_by)
        );

        if (! $data) {
            return response()->json([
                'message' => 'Failed to retrieve resource'
            ], 400);
        }

        return $data;
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
            'name'        => 'required|string|min:2|max:255',
            'description' => 'required|string|min:2|max:255',
            'country'     => 'required|string|min:2|max:255',
            'street'      => 'required|string|min:2|max:255',
            'city'        => 'required|string|min:2|max:255',
            'state'       => 'required|string|min:2|max:255',
            'zip_code'    => 'required|integer',
            'fax'         => 'nullable|string|min:0|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'response' => false,
                'message'  => 'Validation failed.',
                'errors'   => $validator->errors()
            ], 400);
        }

        if (! $this->corporation->store($request)) {
            return response()->json([
                'response' => false,
                'message'  => 'Failed to store resource.'
            ], 500);
        }

        return response()->json([
            'response' => true,
            'message'  => 'Resource successfully stored.'
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
        if (! $corporation = $this->corporation->findOrFail($id)) {
            return response()->json([
                'response' => false,
                'message'  => 'Resource does not exist.'
            ], 200);
        }

        return response()->json([
            'response'    => true,
            'message'     => 'Resource successfully retrieve.',
            'corporation' => $corporation
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
            'name'        => 'required|string|min:2|max:255',
            'description' => 'required|string|min:2|max:255',
            'country'     => 'required|string|min:2|max:255',
            'street'      => 'required|string|min:2|max:255',
            'city'        => 'required|string|min:2|max:255',
            'state'       => 'required|string|min:2|max:255',
            'zip_code'    => 'required|integer',
            'fax'         => 'nullable|string|min:0|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'response' => false,
                'message'  => 'Validation failed.',
                'errors'   => $validator->errors()
            ], 400);
        }

        if (! $this->corporation->update($request, $id)) {
            return response()->json([
                'response' => false,
                'message'  => 'Failed to update resource.'
            ], 500);
        }

        return response()->json([
            'response' => true,
            'message'  => 'Resource successfully updated.'
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
        if (! $this->corporation->findOrFail($id)->delete()) {
            return response()->json([
                'response' => false,
                'message'  => 'Failed to delete resource.'
            ], 400);
        }

        return response()->json([
            'response' => true,
            'message'  => 'Resource successfully deleted.'
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
        if (! $this->corporation->restore($id)) {
            return response()->json([
                'response' => false,
                'message'  => 'Failed to restore resource.'
            ], 400);
        }

        return response()->json([
            'response' => true,
            'message'  => 'Resource successfully restored.'
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
        if (! $this->corporation->forceDestroy($id)) {
            return response()->json([
                'response' => false,
                'message'  => 'Failed to permanently delete resource.'
            ], 400);
        }

        return response()->json([
            'response' => true,
            'message'  => 'Resource successfully deleted permanently.'
        ], 200);
    }

    /**
     * Retrieve all resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllCorporations()
    {
        // if (cache()->has('corporations')) {
        //     return response()->json([
        //         'response'     => true,
        //         'message'      => 'Resources successfully retrieve.',
        //         'corporations' => cache('corporations')
        //     ], 200);
        // }

        if (! $corporations = $this->corporation->all()) {
            return response()->json([
                'response' => false,
                'message'  => 'Resources does not exist.'
            ], 400);
        }

        return response()->json([
            'response'     => true,
            'message'      => 'Resources successfully retrieve.',
            'corporations' => $corporations
        ], 200);
    }
}
