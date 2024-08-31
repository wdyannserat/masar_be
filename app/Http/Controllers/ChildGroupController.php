<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ChildGroupService;
use App\Http\Requests\ChildGroupRequest;
use App\Http\Resources\ChildGroupResource;
use App\Http\Controllers\Controller;

class ChildGroupController extends BaseController
{

    public function __construct(private ChildGroupService $childGroupService)
    {
    }

    public function index()
    {
        return $this->successResponse(
            $this->resource($this->childGroupService->getAll(), ChildGroupResource::class),
            'DataSuccessfullyFetched',
            'ChildGroups'
        );
    }


    public function store(ChildGroupRequest $request)
    {
        return $this->successResponse(
            $this->childGroupService->store($request->validated()),
            'AddedSuccessfully',
            'ChildGroup'
        );
    }

    public function show(Request $request)
    {
        return $this->successResponse(
            $this->resource($this->childGroupService->show($request->id), ChildGroupResource::class),
            'DataSuccessfullyFetched',
            'ChildGroup'
        );
    }

    public function update(ChildGroupRequest $request, $id)
    {
        $this->childGroupService->update($request->validated(), $id);

        return $this->successResponse(
            null,
            'UpdatedSuccessfully',
            'ChildGroup'
        );
    }

    public function destroy($id)
    {
        $this->childGroupService->destroy($id);

        return $this->successResponse(
            null,
            'DeletedSuccessfully',
            'ChildGroup'
        );
    }
}
