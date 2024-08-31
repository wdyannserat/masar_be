<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PositionService;
use App\Http\Requests\PositionRequest;
use App\Http\Resources\PositionResource;
use App\Http\Controllers\Controller;

class PositionController extends BaseController
{

    public function __construct(private PositionService $positionService)
    {
    }

    public function index()
    {
        return $this->successResponse(
            $this->resource($this->positionService->getAll(), PositionResource::class),
            'DataSuccessfullyFetched',
            'Positions'
        );
    }


    public function store(PositionRequest $request)
    {
        return $this->successResponse(
            $this->positionService->store($request->validated()),
            'AddedSuccessfully',
            'Position'
        );
    }

    public function show(Request $request)
    {
        return $this->successResponse(
            $this->resource($this->positionService->show($request->id), PositionResource::class),
            'DataSuccessfullyFetched',
            'Position'
        );
    }

    public function update(PositionRequest $request, $id)
    {
        $this->positionService->update($request->validated(), $id);

        return $this->successResponse(
            null,
            'UpdatedSuccessfully',
            'Position'
        );
    }

    public function destroy($id)
    {
        $this->positionService->destroy($id);

        return $this->successResponse(
            null,
            'DeletedSuccessfully',
            'Position'
        );
    }
}
