<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ChildTripChecklistService;
use App\Http\Requests\ChildTripChecklistRequest;
use App\Http\Resources\ChildTripChecklistResource;
use App\Http\Controllers\Controller;

class ChildTripChecklistController extends BaseController
{

    public function __construct(private ChildTripChecklistService $childTripChecklistService)
    {
    }

    public function index()
    {
        return $this->successResponse(
            $this->resource($this->childTripChecklistService->getAll(), ChildTripChecklistResource::class),
            'DataSuccessfullyFetched',
            'ChildTripChecklists'
        );
    }


    public function store(ChildTripChecklistRequest $request)
    {
        return $this->successResponse(
            $this->childTripChecklistService->store($request->validated()),
            'AddedSuccessfully',
            'ChildTripChecklist'
        );
    }

    public function show(Request $request)
    {
        return $this->successResponse(
            $this->resource($this->childTripChecklistService->show($request->id), ChildTripChecklistResource::class),
            'DataSuccessfullyFetched',
            'ChildTripChecklist'
        );
    }

    public function update(ChildTripChecklistRequest $request, $id)
    {
        $this->childTripChecklistService->update($request->validated(), $id);

        return $this->successResponse(
            null,
            'UpdatedSuccessfully',
            'ChildTripChecklist'
        );
    }

    public function destroy($id)
    {
        $this->childTripChecklistService->destroy($id);

        return $this->successResponse(
            null,
            'DeletedSuccessfully',
            'ChildTripChecklist'
        );
    }
}
