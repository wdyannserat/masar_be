<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MonitorTripService;
use App\Http\Requests\MonitorTripRequest;
use App\Http\Resources\MonitorTripResource;
use App\Http\Controllers\Controller;

class MonitorTripController extends BaseController
{

    public function __construct(private MonitorTripService $monitorTripService)
    {
    }

    public function index()
    {
        return $this->successResponse(
            $this->resource($this->monitorTripService->getAll(), MonitorTripResource::class),
            'DataSuccessfullyFetched',
            'MonitorTrips'
        );
    }


    public function store(MonitorTripRequest $request)
    {
        return $this->successResponse(
            $this->monitorTripService->store($request->validated()),
            'AddedSuccessfully',
            'MonitorTrip'
        );
    }

    public function show(Request $request)
    {
        return $this->successResponse(
            $this->resource($this->monitorTripService->show($request->id), MonitorTripResource::class),
            'DataSuccessfullyFetched',
            'MonitorTrip'
        );
    }

    public function update(MonitorTripRequest $request, $id)
    {
        $this->monitorTripService->update($request->validated(), $id);

        return $this->successResponse(
            null,
            'UpdatedSuccessfully',
            'MonitorTrip'
        );
    }

    public function destroy($id)
    {
        $this->monitorTripService->destroy($id);

        return $this->successResponse(
            null,
            'DeletedSuccessfully',
            'MonitorTrip'
        );
    }
}
