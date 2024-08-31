<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GroupSessionService;
use App\Http\Requests\GroupSessionRequest;
use App\Http\Resources\GroupSessionResource;
use App\Http\Controllers\Controller;

class GroupSessionController extends BaseController
{

    public function __construct(private GroupSessionService $groupSessionService)
    {
    }

    public function index()
    {
        return $this->successResponse(
            $this->resource($this->groupSessionService->getAll(), GroupSessionResource::class),
            'DataSuccessfullyFetched',
            'GroupSessions'
        );
    }


    public function store(GroupSessionRequest $request)
    {
        return $this->successResponse(
            $this->groupSessionService->store($request->validated()),
            'AddedSuccessfully',
            'GroupSession'
        );
    }

    public function show(Request $request)
    {
        return $this->successResponse(
            $this->resource($this->groupSessionService->show($request->id), GroupSessionResource::class),
            'DataSuccessfullyFetched',
            'GroupSession'
        );
    }

    public function update(GroupSessionRequest $request, $id)
    {
        $this->groupSessionService->update($request->validated(), $id);

        return $this->successResponse(
            null,
            'UpdatedSuccessfully',
            'GroupSession'
        );
    }

    public function destroy($id)
    {
        $this->groupSessionService->destroy($id);

        return $this->successResponse(
            null,
            'DeletedSuccessfully',
            'GroupSession'
        );
    }
}
