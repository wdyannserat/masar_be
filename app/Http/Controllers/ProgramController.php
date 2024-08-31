<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProgramService;
use App\Http\Requests\ProgramRequest;
use App\Http\Resources\ProgramResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\GroupResource;

class ProgramController extends BaseController
{

    public function __construct(private ProgramService $programService)
    {
    }

    public function index()
    {
        return $this->successResponse(
            $this->resource($this->programService->getAll(), ProgramResource::class),
            'DataSuccessfullyFetched',
            'Programs'
        );
    }

    public function getProgramsRequests()
    {
        return $this->successResponse(
            $this->resource($this->programService->getProgramsRequests(), ProgramResource::class),
            'DataSuccessfullyFetched',
            'Programs'
        );
    }

    public function show(ProgramRequest $request)
    {
        return $this->successResponse(
            $this->resource($this->programService->show($request->id), ProgramResource::class),
            'DataSuccessfullyFetched',
            'Program'
        );
    }


    public function store(ProgramRequest $request)
    {
        return $this->successResponse(
            $this->resource($this->programService->store($request->validated()), ProgramResource::class),
            'AddedSuccessfully',
            'Program'
        );
    }

    public function assignMissions(ProgramRequest $request, $id)
    {
        return $this->successResponse(
            $this->programService->assignMissions($request->validated(), $id),
            'MissionAddedSuccessfullyToProgram',
            'Program'
        );
    }

    public function assignSessions(ProgramRequest $request, $id)
    {
        return $this->successResponse(
            $this->programService->assignSessions($request->validated(), $id),
            'SessionsAddedSuccessfullyToProgram',
            'Program'
        );
    }

    public function update(ProgramRequest $request, $id)
    {
        $this->programService->update($request->validated(), $id);

        return $this->successResponse(
            null,
            'UpdatedSuccessfully',
            'Program'
        );
    }

    public function destroy($id)
    {
        $this->programService->destroy($id);

        return $this->successResponse(
            null,
            'DeletedSuccessfully',
            'Program'
        );
    }

    public function endProgram($id)
    {
        $this->programService->endProgram($id);

        return $this->successResponse(
            null,
            'ProgramEndedSuccessfully',
            'Program'
        );
    }

    public function getGroupsByProgramId($id)
    {
        return $this->successResponse(
            $this->resource($this->programService->getGroupsByProgramId($id), GroupResource::class),
            'DataSuccessfullyFetched',
            'Groups'
        );
    }
}
