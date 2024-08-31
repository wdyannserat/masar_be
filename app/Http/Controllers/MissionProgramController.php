<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MissionProgramService;
use App\Http\Requests\MissionProgramRequest;
use App\Http\Resources\MissionProgramResource;
use App\Http\Controllers\Controller;

class MissionProgramController extends BaseController
{

    public function __construct(private MissionProgramService $missionprogramService)
    {}

    public function index()
    {
        return $this->successResponse(
            $this->resource($this->missionprogramService->getAll(),MissionProgramResource::class),
            'DataSuccessfullyFetched',
            'MissionPrograms'
        );
    }


    public function store(MissionProgramRequest $request)
    {
        return $this->successResponse(
            $this->missionprogramService->store($request->validated()),
            'AddedSuccessfully',
            'MissionProgram'
        );
    }

    public function show(Request $request)
    {
        return $this->successResponse(
            $this->resource($this->missionprogramService->show($request->id),MissionProgramResource::class),
            'DataSuccessfullyFetched',
            'MissionProgram'
        );
    }

    public function update(MissionProgramRequest $request , $id)
    {
        $this->missionprogramService->update( $request->validated(),$id);

        return $this->successResponse(
            null,
            'UpdatedSuccessfully',
            'MissionProgram'
        );
    }

    public function destroy($id)
    {
        $this->missionprogramService->destroy($id);

        return $this->successResponse(
            null,
            'DeletedSuccessfully',
            'MissionProgram'
        );
    }
}
