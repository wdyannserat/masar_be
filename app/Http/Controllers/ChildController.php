<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ChildService;
use App\Http\Requests\ChildRequest;
use App\Http\Resources\ChildResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\ChildDetailsResource;

class ChildController extends BaseController
{

    public function __construct(private ChildService $childService)
    {
    }

    public function index()
    {
        return $this->successResponse(
            $this->resource($this->childService->getAll(), ChildResource::class),
            'DataSuccessfullyFetched',
            'Children'
        );
    }


    public function store(ChildRequest $request)
    {
        return $this->successResponse(
            $this->resource($this->childService->store($request->validated()), ChildResource::class),
            'AddedSuccessfully',
            'Child'
        );
    }

    public function show(ChildRequest $request)
    {
        return $this->successResponse(
            $this->resource(($this->childService->show($request->id)), ChildResource::class),
            'DataSuccessfullyFetched',
            'Child'
        );
    }

    public function getChildInfoDetails(ChildRequest $request)
    {
        return $this->successResponse(
            $this->resource(($this->childService->getDetails($request->id)), ChildDetailsResource::class),
            // 'in maintenance mode',
            'DataSuccessfullyFetched',
            'Child',
            503
        );
    }
    public function update(ChildRequest $request, $id)
    {
        $this->childService->update($request->validated(), $id);

        return $this->successResponse(
            null,
            'UpdatedSuccessfully',
            'Child'
        );
    }

    public function destroy($id)
    {
        $this->childService->destroy($id);

        return $this->successResponse(
            null,
            'DeletedSuccessfully',
            'Child'
        );
    }
}
