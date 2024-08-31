<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProgramSessionService;
use App\Http\Requests\ProgramSessionRequest;
use App\Http\Resources\ProgramSessionResource;
use App\Http\Controllers\Controller;

class ProgramSessionController extends BaseController
{

    public function __construct(private ProgramSessionService $programsessionService)
    {}

    public function index()
    {
        return $this->successResponse(
            $this->resource($this->programsessionService->getAll(),ProgramSessionResource::class),
            'DataSuccessfullyFetched',
            'ProgramSessions'
        );
    }


    public function store(ProgramSessionRequest $request)
    {
        return $this->successResponse(
            $this->programsessionService->store($request->validated()),
            'AddedSuccessfully',
            'ProgramSession'
        );
    }

    public function show(Request $request)
    {
        return $this->successResponse(
            $this->resource($this->programsessionService->show($request->id),ProgramSessionResource::class),
            'DataSuccessfullyFetched',
            'ProgramSession'
        );
    }

    public function update(ProgramSessionRequest $request , $id)
    {
        $this->programsessionService->update( $request->validated(),$id);

        return $this->successResponse(
            null,
            'UpdatedSuccessfully',
            'ProgramSession'
        );
    }

    public function destroy($id)
    {
        $this->programsessionService->destroy($id);

        return $this->successResponse(
            null,
            'DeletedSuccessfully',
            'ProgramSession'
        );
    }
}
