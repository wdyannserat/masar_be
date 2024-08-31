<?php

namespace App\Services;

use App\Models\AgeType;
use Illuminate\Support\Facades\DB;


class AgeTypeService extends BaseService
{
    public function getAll()
    {
        return  AgeType::all();
    }


    public function store($validatedData)
    {
        DB::beginTransaction();
        $ageType = AgeType::create($validatedData);
        DB::commit();
        return $ageType;
    }

    public function show($id)
    {
        $ageType = $this->find($id);

        return $ageType;
    }


    public function update($validatedData, $id)
    {
        DB::beginTransaction();

        $ageType = $this->find($id);

        $ageType->update($validatedData);

        DB::commit();
        return $ageType;
    }


    public function destroy($id)
    {
        $ageType = $this->find($id);

        DB::beginTransaction();


        $ageType->delete();
        DB::commit();

        return true;
    }

    public function find($id)
    {
        return $this->findByIdOrFail(AgeType::class, 'AgeType', $id);
    }
}
