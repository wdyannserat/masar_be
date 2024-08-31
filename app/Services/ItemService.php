<?php

namespace App\Services;

use App\Models\Item;
use Illuminate\Support\Facades\DB;


class ItemService extends BaseService
{
    public function getAll()
    {
        return  Item::all();
    }


    public function store($validatedData)
    {
        DB::beginTransaction();

        $item = Item::create($validatedData);
        DB::commit();
        return $item;
    }

    public function show($id)
    {
        $item = $this->find($id);

        return $item;
    }


    public function update($validatedData, $id)
    {
        DB::beginTransaction();


        $item = $this->find($id);

        $item->update($validatedData);

        DB::commit();
        return $item;
    }


    public function destroy($id)
    {
        $item = $this->find($id);

        DB::beginTransaction();


        $item->delete();
        DB::commit();

        return true;
    }

    public function find($id)
    {
        return $this->findByIdOrFail(Item::class, 'Item', $id);
    }
}
