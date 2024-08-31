<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ItemService;
use App\Http\Requests\ItemRequest;
use App\Http\Resources\ItemResource;
use App\Http\Controllers\Controller;

class ItemController extends BaseController
{

    public function __construct(private ItemService $itemService)
    {
    }

    public function index()
    {
        return $this->successResponse(
            $this->resource($this->itemService->getAll(), ItemResource::class),
            'DataSuccessfullyFetched',
            'Items'
        );
    }


    public function store(ItemRequest $request)
    {
        return $this->successResponse(
            $this->itemService->store($request->validated()),
            'AddedSuccessfully',
            'Item'
        );

    }

    public function show(Request $request)
    {
        return $this->successResponse(
            $this->resource($this->itemService->show($request->id), ItemResource::class),
            'DataSuccessfullyFetched',
            'Item'
        );
    }

    public function update(ItemRequest $request, $id)
    {
        $this->itemService->update($request->validated(), $id);

        return $this->successResponse(
            null,
            'UpdatedSuccessfully',
            'Item'
        );
    }

    public function destroy($id)
    {
        $this->itemService->destroy($id);

        return $this->successResponse(
            null,
            'DeletedSuccessfully',
            'Item'
        );
    }
}
