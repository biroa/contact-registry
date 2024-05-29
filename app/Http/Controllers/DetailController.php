<?php

namespace App\Http\Controllers;

use App\Http\Resources\DetailIndexResource;
use App\Http\Resources\DetailRemoveResource;
use App\Http\Resources\DetailShowResource;
use App\Http\Resources\DetailStoreResource;
use App\Http\Resources\DetailUpdateResource;
use App\Models\Detail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class DetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): DetailIndexResource|JsonResponse
    {
        return new DetailIndexResource(Detail::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): DetailStoreResource |JsonResponse
    {
        $validator = Validator::make($request->all(),
            [
                'key' => 'required|max:100',
                'value' => 'required|max:255',
                'contact_id' => 'required|numeric',
            ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $validator->validate();
        $data = $validator->safe()->only(
            [
                'contact_id',
                'key',
                'value',
            ]
        );
        $details = new Detail($data);

        $details->save();

        return new DetailStoreResource($details);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): DetailShowResource|JsonResponse
    {
        return new DetailShowResource(Detail::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): DetailUpdateResource | JsonResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Detail $detail): DetailRemoveResource|JsonResponse
    {
        $softDeleted = $detail;
        Detail::destroy($detail->id);

        return new DetailRemoveResource($softDeleted);
    }
}
