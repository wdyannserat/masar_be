<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PositionTripService;
use App\Http\Requests\PositionTripRequest;
use App\Http\Resources\PositionTripResource;
use App\Http\Controllers\Controller;

class PositionTripController extends BaseController
{

    public function __construct(private PositionTripService $positionTripService)
    {
    }

    public function index()
    {
        return $this->successResponse(
            $this->resource($this->positionTripService->getAll(), PositionTripResource::class),
            'DataSuccessfullyFetched',
            'PositionTrips'
        );
    }


    public function store(PositionTripRequest $request)
    {
        return $this->successResponse(
            $this->positionTripService->store($request->validated()),
            'AddedSuccessfully',
            'PositionTrip'
        );
    }

    public function show(Request $request)
    {
        return $this->successResponse(
            $this->resource($this->positionTripService->show($request->id), PositionTripResource::class),
            'DataSuccessfullyFetched',
            'PositionTrip'
        );
    }

    public function update(PositionTripRequest $request, $id)
    {
        $this->positionTripService->update($request->validated(), $id);

        return $this->successResponse(
            null,
            'UpdatedSuccessfully',
            'PositionTrip'
        );
    }

    public function destroy($id)
    {
        $this->positionTripService->destroy($id);

        return $this->successResponse(
            null,
            'DeletedSuccessfully',
            'PositionTrip'
        );
    }
}
