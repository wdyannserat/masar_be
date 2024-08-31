<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SessionChecklistService;
use App\Http\Requests\SessionChecklistRequest;
use App\Http\Resources\SessionChecklistResource;
use App\Http\Controllers\Controller;

class SessionChecklistController extends BaseController
{

    public function __construct(private SessionChecklistService $sessionChecklistService)
    {
    }

    public function index()
    {
        return $this->successResponse(
            $this->resource($this->sessionChecklistService->getAll(), SessionChecklistResource::class),
            'DataSuccessfullyFetched',
            'SessionChecklists'
        );
    }


    public function store(SessionChecklistRequest $request)
    {
        return $this->successResponse(
            $this->sessionChecklistService->store($request->validated()),
            'AddedSuccessfully',
            'SessionChecklist'
        );
    }

    public function show(Request $request)
    {
        return $this->successResponse(
            $this->resource($this->sessionChecklistService->show($request->id), SessionChecklistResource::class),
            'DataSuccessfullyFetched',
            'SessionChecklist'
        );
    }

    public function update(SessionChecklistRequest $request, $id)
    {
        $this->sessionChecklistService->update($request->validated(), $id);

        return $this->successResponse(
            null,
            'UpdatedSuccessfully',
            'SessionChecklist'
        );
    }

    public function destroy($id)
    {
        $this->sessionChecklistService->destroy($id);

        return $this->successResponse(
            null,
            'DeletedSuccessfully',
            'SessionChecklist'
        );
    }
}
