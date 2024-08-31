<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ChildMissionService;
use App\Http\Requests\ChildMissionRequest;
use App\Http\Resources\ChildMissionResource;
use App\Http\Controllers\Controller;

class ChildMissionController extends BaseController
{

    public function __construct(private ChildMissionService $childMissionService)
    {
    }

    public function index()
    {
        return $this->successResponse(
            $this->resource($this->childMissionService->getAll(), ChildMissionResource::class),
            'DataSuccessfullyFetched',
            'ChildMissions'
        );
    }


    public function store(ChildMissionRequest $request)
    {
        return $this->successResponse(
            $this->childMissionService->store($request->validated()),
            'AddedSuccessfully',
            'ChildMission'
        );
    }

    public function show(Request $request)
    {
        return $this->successResponse(
            $this->resource($this->childMissionService->show($request->id), ChildMissionResource::class),
            'DataSuccessfullyFetched',
            'ChildMission'
        );
    }

    public function update(ChildMissionRequest $request, $id)
    {
        $this->childMissionService->update($request->validated(), $id);

        return $this->successResponse(
            null,
            'UpdatedSuccessfully',
            'ChildMission'
        );
    }

    public function destroy($id)
    {
        $this->childMissionService->destroy($id);

        return $this->successResponse(
            null,
            'DeletedSuccessfully',
            'ChildMission'
        );
    }
}
