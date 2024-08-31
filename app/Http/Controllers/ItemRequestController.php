<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ItemRequestService;
use App\Http\Requests\ItemRequestRequest;
use App\Http\Resources\ItemRequestResource;
use App\Http\Controllers\Controller;

class ItemRequestController extends BaseController
{

    public function __construct(private ItemRequestService $itemRequestService)
    {
    }

    public function index()
    {
        return $this->successResponse(
            $this->resource($this->itemRequestService->getAll(), ItemRequestResource::class),
            'DataSuccessfullyFetched',
            'ItemRequests'
        );
    }


    public function store(ItemRequestRequest $request)
    {
        return $this->successResponse(
            $this->itemRequestService->store($request->validated()),
            'AddedSuccessfully',
            'ItemRequest'
        );
    }

    public function show(Request $request)
    {
        return $this->successResponse(
            $this->resource($this->itemRequestService->show($request->id), ItemRequestResource::class),
            'DataSuccessfullyFetched',
            'ItemRequest'
        );
    }

    public function update(ItemRequestRequest $request, $id)
    {
        $this->itemRequestService->update($request->validated(), $id);

        return $this->successResponse(
            null,
            'UpdatedSuccessfully',
            'ItemRequest'
        );
    }

    public function destroy($id)
    {
        $this->itemRequestService->destroy($id);

        return $this->successResponse(
            null,
            'DeletedSuccessfully',
            'ItemRequest'
        );
    }
}
