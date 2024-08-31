<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TripService;
use App\Http\Requests\TripRequest;
use App\Http\Resources\TripResource;
use App\Http\Controllers\Controller;

class TripController extends BaseController
{

    public function __construct(private TripService $tripService)
    {
    }

    public function index()
    {
        return $this->successResponse(
            $this->resource($this->tripService->getAll(), TripResource::class),
            'DataSuccessfullyFetched',
            'Trips'
        );
    }


    public function store(TripRequest $request)
    {
        return $this->successResponse(
            $this->tripService->store($request->validated()),
            'AddedSuccessfully',
            'Trip'
        );
    }

    public function show(Request $request)
    {
        return $this->successResponse(
            $this->resource($this->tripService->show($request->id), TripResource::class),
            'DataSuccessfullyFetched',
            'Trip'
        );
    }

    public function update(TripRequest $request, $id)
    {
        $this->tripService->update($request->validated(), $id);

        return $this->successResponse(
            null,
            'UpdatedSuccessfully',
            'Trip'
        );
    }

    public function destroy($id)
    {
        $this->tripService->destroy($id);

        return $this->successResponse(
            null,
            'DeletedSuccessfully',
            'Trip'
        );
    }
}
