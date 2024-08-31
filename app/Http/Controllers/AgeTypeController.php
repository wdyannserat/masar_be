<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AgeTypeService;
use App\Http\Requests\AgeTypeRequest;
use App\Http\Resources\AgeTypeResource;
use App\Http\Controllers\Controller;

class AgeTypeController extends BaseController
{

    public function __construct(private AgeTypeService $ageTypeService)
    {
    }

    public function index()
    {
        return $this->successResponse(
            $this->resource($this->ageTypeService->getAll(), AgeTypeResource::class),
            'DataSuccessfullyFetched',
            'AgeTypes'
        );
    }


    public function store(AgeTypeRequest $request)
    {
        return $this->successResponse(
            $this->resource($this->ageTypeService->store($request->validated()), AgeTypeResource::class),
            'AddedSuccessfully',
            'AgeType'
        );
    }

    public function show(Request $request)
    {
        return $this->successResponse(
            $this->resource($this->ageTypeService->show($request->id), AgeTypeResource::class),
            'DataSuccessfullyFetched',
            'AgeType'
        );
    }

    public function update(AgeTypeRequest $request, $id)
    {
        $this->ageTypeService->update($request->validated(), $id);

        return $this->successResponse(
            null,
            'UpdatedSuccessfully',
            'AgeType'
        );
    }

    public function destroy($id)
    {
        $this->ageTypeService->destroy($id);

        return $this->successResponse(
            null,
            'DeletedSuccessfully',
            'AgeType'
        );
    }
}
