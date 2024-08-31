<?php

namespace App\Services;

use App\Models\ChildMission;
use Illuminate\Support\Facades\DB;


class ChildMissionService extends BaseService
{
    public function getAll()
    {
        return  ChildMission::all();
    }


    public function store($validatedData)
    {
        DB::beginTransaction();

        $childmission = ChildMission::create($validatedData);
        DB::commit();
        return $childmission;
    }

    public function show($id)
    {
        $childmission = $this->find($id);

        return $childmission;
    }


    public function update($validatedData, $id)
    {
        DB::beginTransaction();


        $childmission = $this->find($id);

        $childmission->update($validatedData);

        DB::commit();
        return $childmission;
    }


    public function destroy($id)
    {
        $childmission = $this->find($id);

        DB::beginTransaction();


        $childmission->delete();
        DB::commit();

        return true;
    }

    public function find($id)
    {
        return $this->findByIdOrFail(ChildMission::class, 'ChildMission', $id);
    }
}
