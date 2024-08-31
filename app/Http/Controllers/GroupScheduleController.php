<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GroupScheduleService;
use App\Http\Requests\GroupScheduleRequest;
use App\Http\Resources\GroupScheduleResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\GroupResource;
use App\Http\Resources\GroupScheduleSessionResource;

class GroupScheduleController extends BaseController
{

    public function __construct(private GroupScheduleService $groupScheduleService)
    {
    }

    public function index()
    {
        return $this->successResponse(
            $this->resource($this->groupScheduleService->getAll(), GroupScheduleResource::class),
            'DataSuccessfullyFetched',
            'GroupSchedules'
        );
    }

    public function getSessionForGroupSchedule($groupScheduleId)
    {
        // return $this->groupScheduleService->getSessionForGroupSchedule($groupScheduleId);

        return $this->successResponse(
            $this->resource($this->groupScheduleService->getSessionForGroupSchedule($groupScheduleId), GroupScheduleSessionResource::class),
            'DataSuccessfullyFetched',
            'Sessions'
        );
    }


    public function store(GroupScheduleRequest $request, $groupId)
    {
        return $this->successResponse(
            $this->resource($this->groupScheduleService->store($request->validated(), $groupId), GroupScheduleResource::class),
            'AddedSuccessfully',
            'GroupSchedule'
        );
    }

    public function assignSessions(GroupScheduleRequest $request, $id)
    {
        return $this->successResponse(
            $this->groupScheduleService->assignSessions($request->validated(), $id),
            'AddedSuccessfully',
            'GroupSchedule'
        );
    }

    public function show(Request $request)
    {
        return $this->successResponse(
            $this->resource($this->groupScheduleService->show($request->id), GroupScheduleResource::class),
            'DataSuccessfullyFetched',
            'GroupSchedule'
        );
    }

    public function update(GroupScheduleRequest $request, $id)
    {
        $this->groupScheduleService->update($request->validated(), $id);

        return $this->successResponse(
            null,
            'UpdatedSuccessfully',
            'GroupSchedule'
        );
    }

    public function destroy($id)
    {
        $this->groupScheduleService->destroy($id);

        return $this->successResponse(
            null,
            'DeletedSuccessfully',
            'GroupSchedule'
        );
    }
}
