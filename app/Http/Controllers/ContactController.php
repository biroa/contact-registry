<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContactResource;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new ContactResource(Contact::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Contact $contact, Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'firstName' => 'required|max:85',
                'lastName' => 'required|max:85',
            ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $validated = $validator->validate();
        $contact->create($validator->safe()->only(['firstName', 'lastName']));

        return new ContactResource($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new ContactResource(Contact::findOrFail((int) $id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
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
        $validated = $validator->validate();
        $contact->fill($validator->safe()->only(['firstName', 'lastName']))->save();

        return new ContactResource($validated);
    }

    /**
     * SoftDeleting a contact
     *
     * @return void
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();
    }
}
