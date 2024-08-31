<?php

namespace App\Services;

use App\Models\ChildTripChecklist;
use Illuminate\Support\Facades\DB;


class ChildTripChecklistService extends BaseService
{
    public function getAll()
    {
        return  ChildTripChecklist::all();
    }


    public function store($validatedData)
    {
        DB::beginTransaction();

        $childtripchecklist = ChildTripChecklist::create($validatedData);
        DB::commit();
        return $childtripchecklist;
    }

    public function show($id)
    {
        $childtripchecklist = $this->find($id);

        return $childtripchecklist;
    }


    public function update($validatedData, $id)
    {
        DB::beginTransaction();


        $childtripchecklist = $this->find($id);

        $childtripchecklist->update($validatedData);

        DB::commit();
        return $childtripchecklist;
    }


    public function destroy($id)
    {
        $childtripchecklist = $this->find($id);

        DB::beginTransaction();


        $childtripchecklist->delete();
        DB::commit();

        return true;
    }

    public function find($id)
    {
        return $this->findByIdOrFail(ChildTripChecklist::class, 'ChildTripChecklist', $id);
    }
}
