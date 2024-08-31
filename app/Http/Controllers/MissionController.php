<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MissionService;
use App\Http\Requests\MissionRequest;
use App\Http\Resources\MissionResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\MissionChallangeResource;

class MissionController extends BaseController
{

    public function __construct(private MissionService $missionService)
    {
    }

    public function index()
    {
        return $this->successResponse(
            $this->resource($this->missionService->getAll(), MissionResource::class),
            'DataSuccessfullyFetched',
            'Missions'
        );
    }

    public function getCurrentProgramMissions()
    {
        return $this->successResponse(
            $this->resource($this->missionService->getCurrentProgramMissions(), MissionResource::class),
            'DataSuccessfullyFetched',
            'Missions'
        );
    }

    public function store(MissionRequest $request)
    {
        return $this->successResponse(
            $this->resource($this->missionService->store($request->validated()), MissionResource::class),
            'AddedSuccessfully',
            'Mission'
        );
    }

    public function show(MissionRequest $request)
    {
        return $this->successResponse(
            $this->resource($this->missionService->show($request->id), MissionResource::class),
            'DataSuccessfullyFetched',
            'Mission'
        );
    }

    public function update(MissionRequest $request, $id)
    {
        return $this->successResponse(
            $this->missionService->update($request->validated(), $id),
            'UpdatedSuccessfully',
            'Mission'
        );
    }

    public function destroy($id)
    {
        return $this->successResponse(
            $this->missionService->destroy($id),
            'DeletedSuccessfully',
            'Mission'
        );
    }
}
