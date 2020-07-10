<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContactResource;
use App\Repositories\ContactRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactsController extends Controller
{
    /**
     * Contact repository.
     *
     * @var App\Repositories\ContactRepository
     */
    protected $contact;

    /**
     * Create new instance of contact controller.
     *
     * @param ContactRepository contact Contact repository
     */
    public function __construct(ContactRepository $contact)
    {
        $this->contact = $contact;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = ContactResource::collection(
            $this->contact->paginateWithFilters(request(), request()->per_page, request()->order_by)
        );

        if (! $contacts) {
            return response()->json([
                'message' => 'Failed to retrieve resource'
            ], 400);
        }

        return $contacts;
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
            'contact_type_id' => 'required|integer',
            'company'         => 'required|string|max:255',
            'company_address' => 'required|string|max:255',
            'name'            => 'required|string|max:255',
            'email'           => 'required|string|email|max:255|unique:contacts',
            'mobile_number'   => 'required|string',
            'credit_limit'    => 'numeric|nullable',
            'account_id'      => 'integer|nullable'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message'  => 'Validation failed.',
                'errors'   => $validator->errors()
            ], 400);
        }

        if (! $this->contact->store($request)) {
            return response()->json([
                'message'  => 'Failed to store resource.'
            ], 500);
        }

        return response()->json([
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
        if (! $contact = $this->contact->findOrFail($id)) {
            return response()->json([
                'message'  => 'Resource does not exist.'
            ], 400);
        }

        return response()->json([
            'message'  => 'Resource successfully retrieve.',
            'contact'  => $contact
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
            'contact_type_id'   =>  'required|integer',
            'company'           =>  'required|string|max:255',
            'company_address'   =>  'required|string|max:255',
            'person'            =>  'required|string|max:255',
            'mobile_number'     =>  'required|integer',
            'credit_limit'      =>  'numeric|nullable',
            'account_id'        =>  'integer|nullable'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message'  => 'Validation failed.',
                'errors'   => $validator->errors()
            ], 400);
        }

        if (! $this->contact->update($request, $id)) {
            return response()->json([
                'message'  => 'Failed to update resource.'
            ], 500);
        }

        return response()->json([
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
        if (! $this->contact->findOrFail($id)->delete()) {
            return response()->json([
                'message'  => 'Failed to delete resource.'
            ], 400);
        }

        return response()->json([
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
        if (! $this->contact->restore($id)) {
            return response()->json([
                'message'  => 'Failed to restore resource.'
            ], 400);
        }

        return response()->json([
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
        if (! $this->contact->forceDestroy($id)) {
            return response()->json([
                'message'  => 'Failed to permanently delete resource.'
            ], 400);
        }

        return response()->json([
            'message'  => 'Resource successfully deleted permanently.'
        ], 200);
    }

    /**
     * Retrieve all resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllContacts()
    {
        if (cache()->has('contacts')) {
            return response()->json([
                'message'  => 'Resources successfully retrieve.',
                'contacts' => cache('contacts', 5)
            ], 200);
        }

        if (! $contacts = $this->contact->all()) {
            return response()->json([
                'message'  => 'Resources does not exist.'
            ], 400);
        }

        return response()->json([
            'message'  => 'Resources successfully retrieve.',
            'contacts' => $contacts
        ], 200);
    }
}
