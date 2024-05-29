<?php

namespace App\Http\Controllers;

use App\Http\Resources\AddressIndexResource;
use App\Http\Resources\AddressRemoveResource;
use App\Http\Resources\AddressShowResource;
use App\Http\Resources\AddressStoreResource;
use App\Http\Resources\AddressUpdateResource;
use App\Models\Address;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AddressIndexResource|JsonResponse
    {
        return new AddressIndexResource(Address::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): AddressStoreResource|JsonResponse
    {

        $validator = Validator::make($request->all(),
            [
                'contact_id' => 'required|numeric',
                'country' => 'required|max:75',
                'county' => 'required|max:125',
                'settlement' => 'required|max:75',
                'street' => 'required',
                'streetNumber' => 'required|numeric',
            ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $validated = $validator->validate();
        $address = new Address($validator->safe()->only(
            [
                'contact_id',
                'country',
                'county',
                'settlement',
                'street',
                'streetNumber',
            ]
        ));
        $address->save();

        return new AddressStoreResource($address);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): AddressShowResource|JsonResponse
    {
        return new AddressShowResource(Address::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): AddressUpdateResource|JsonResponse
    {
        $contact = Address::findOrFail((int) $id);
        $validator = Validator::make($request->all(),
            [
                'country' => 'required|max:75',
                'county' => 'required|max:125',
                'settlement' => 'required|max:75',
                'street' => 'required',
                'streetNumber' => 'required|numeric',
            ]
        );
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $validator->validate();
        $contact->fill($validator->safe()->only(
            [
                'country',
                'county',
                'settlement',
                'street',
                'streetNumber',
            ]
        ))->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $address): AddressRemoveResource|JsonResponse
    {
        $softDeleted = $address;
        Address::destroy($address->id);

        return new AddressRemoveResource($softDeleted);
    }
}
