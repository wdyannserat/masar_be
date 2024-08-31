<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FacilitatorTripService;
use App\Http\Requests\FacilitatorTripRequest;
use App\Http\Resources\FacilitatorTripResource;
use App\Http\Controllers\Controller;

class FacilitatorTripController extends BaseController
{

    public function __construct(private FacilitatorTripService $facilitatorTripService)
    {
    }

    public function index()
    {
        return $this->successResponse(
            $this->resource($this->facilitatorTripService->getAll(), FacilitatorTripResource::class),
            'DataSuccessfullyFetched',
            'FacilitatorTrips'
        );
    }


    public function store(FacilitatorTripRequest $request)
    {
        return $this->successResponse(
            $this->facilitatorTripService->store($request->validated()),
            'AddedSuccessfully',
            'FacilitatorTrip'
        );
    }

    public function show(Request $request)
    {
        return $this->successResponse(
            $this->resource($this->facilitatorTripService->show($request->id), FacilitatorTripResource::class),
            'DataSuccessfullyFetched',
            'FacilitatorTrip'
        );
    }

    public function update(FacilitatorTripRequest $request, $id)
    {
        $this->facilitatorTripService->update($request->validated(), $id);

        return $this->successResponse(
            null,
            'UpdatedSuccessfully',
            'FacilitatorTrip'
        );
    }

    public function destroy($id)
    {
        $this->facilitatorTripService->destroy($id);

        return $this->successResponse(
            null,
            'DeletedSuccessfully',
            'FacilitatorTrip'
        );
    }
}
