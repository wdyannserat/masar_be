<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GroupService;
use App\Http\Requests\GroupRequest;
use App\Http\Resources\GroupResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\GroupScheduleRequest;
use App\Services\ChildService;
use App\Services\GroupScheduleService;

class GroupController extends BaseController
{

    public function __construct(
        private GroupService $groupService,
        private GroupScheduleService $groupScheduleService
    ) {
    }

    public function index()
    {
        return $this->successResponse(
            $this->resource($this->groupService->getAll(), GroupResource::class),
            'DataSuccessfullyFetched',
            'Groups'
        );
    }

    public function show(Request $request)
    {
        return $this->successResponse(
            $this->resource($this->groupService->show($request->id), GroupResource::class),
            'DataSuccessfullyFetched',
            'Group'
        );
    }

    public function store(GroupRequest $request)
    {
        return $this->successResponse(
            $this->resource($this->groupService->store($request->validated()), GroupResource::class),
            'AddedSuccessfully',
            'Group'
        );
    }

    public function assignFacilitators(GroupRequest $request, $id)
    {
        return $this->successResponse(
            $this->groupService->assignFacilitator($request->validated(), $id),
            'FacilitatorsAddedForGroupSuccessfully',
            'Group'
        );
    }

    public function assignChildren(GroupRequest $request, $id)
    {
        return $this->successResponse(
            $this->groupService->assignChildren($request->validated(), $id),
            'ChildrenAddedForGroupSuccessfully',
            'Group'
        );
    }

    public function deleteChildFromGroup($groupId, $childId)
    {

        GroupService::find($groupId);
        ChildService::find($childId);
        
        return $this->successResponse(
            $this->groupService->deleteChildFromGroup($groupId, $childId),
            'ChildRemovedFromGroupSuccessfully',
            'Group'
        );
    }


    public function update(GroupRequest $request, $id)
    {
        $this->groupService->update($request->validated(), $id);

        return $this->successResponse(
            null,
            'UpdatedSuccessfully',
            'Group'
        );
    }

    public function destroy($id)
    {
        $this->groupService->destroy($id);

        return $this->successResponse(
            null,
            'DeletedSuccessfully',
            'Group'
        );
    }
}
