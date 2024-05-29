<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContactRemoveResource;
use App\Http\Resources\ContactShowResource;
use App\Http\Resources\ContactsIndexResource;
use App\Http\Resources\ContactStoreResource;
use App\Http\Resources\ContactUpdateResource;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): ContactsIndexResource|JsonResponse
    {
        return new ContactsIndexResource(Contact::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): ContactStoreResource|JsonResponse
    {
        $validator = Validator::make($request->all(),
            [
                'firstName' => 'required|max:85',
                'lastName' => 'required|max:85',
            ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $validator->validate();
        $contact = new Contact($validator->safe()->only(['firstName', 'lastName']));
        $contact->save();

        return new ContactStoreResource($contact);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): ContactShowResource|JsonResponse
    {
        return new ContactShowResource(Contact::findOrFail((int) $id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): ContactUpdateResource|JsonResponse
    {

        $contact = Contact::findOrFail((int) $id);
        $validator = Validator::make($request->all(),
            [
                'firstName' => 'required|max:85',
                'lastName' => 'required|max:85',
            ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $validator->validate();
        $contact->fill($validator->safe()->only(['firstName', 'lastName']))->save();

        return new ContactUpdateResource($contact);
    }

    /**
     * SoftDeleting a contact
     */
    public function destroy(Contact $contact): ContactRemoveResource|JsonResponse
    {
        $softDeleted = $contact;
        Contact::destroy($contact->id);

        return new ContactRemoveResource($softDeleted);
    }
}
