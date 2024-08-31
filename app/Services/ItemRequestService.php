<?php

namespace App\Services;

use App\Models\ItemRequest;
use Illuminate\Support\Facades\DB;


class ItemRequestService extends BaseService
{
    public function getAll()
    {
        return  ItemRequest::all();
    }


    public function store($validatedData)
    {
        DB::beginTransaction();

        $itemRequest = ItemRequest::create($validatedData);
        DB::commit();
        return $itemRequest;
    }

    public function show($id)
    {
        $itemRequest = $this->find($id);

        return $itemRequest;
    }


    public function update($validatedData, $id)
    {
        DB::beginTransaction();


        $itemRequest = $this->find($id);

        $itemRequest->update($validatedData);

        DB::commit();
        return $itemRequest;
    }


    public function destroy($id)
    {
        $itemRequest = $this->find($id);

        DB::beginTransaction();


        $itemRequest->delete();
        DB::commit();

        return true;
    }

    public function find($id)
    {
        return $this->findByIdOrFail(ItemRequest::class, 'ItemRequest', $id);
    }
}
