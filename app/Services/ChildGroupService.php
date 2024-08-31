<?php

namespace App\Services;

use App\Models\ChildGroup;
use Illuminate\Support\Facades\DB;


class ChildGroupService extends BaseService
{
    public function getAll()
    {
        return  ChildGroup::all();
    }


    public function store($validatedData)
    {
        DB::beginTransaction();

        $childgroup = ChildGroup::create($validatedData);
        DB::commit();
        return $childgroup;
    }

    public function show($id)
    {
        $childgroup = $this->find($id);

        return $childgroup;
    }


    public function update($validatedData, $id)
    {
        DB::beginTransaction();


        $childgroup = $this->find($id);

        $childgroup->update($validatedData);

        DB::commit();
        return $childgroup;
    }


    public function destroy($id)
    {
        $childgroup = $this->find($id);

        DB::beginTransaction();


        $childgroup->delete();
        DB::commit();

        return true;
    }

    public function find($id)
    {
        return $this->findByIdOrFail(ChildGroup::class, 'ChildGroup', $id);
    }
}
