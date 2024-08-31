<?php

namespace App\Services;

use App\Models\MissionProgram;
use Illuminate\Support\Facades\DB;


class MissionProgramService extends BaseService
{
    public function getAll()
    {
        return  MissionProgram::all();
    }


    public function store($validatedData)
    {
        DB::beginTransaction();

        $missionprogram = MissionProgram::create($validatedData);
        DB::commit();
        return $missionprogram;
    }

    public function show($id)
    {
        $missionprogram = $this->find($id);

        return $missionprogram;
    }


    public function update($validatedData , $id)
    {
        DB::beginTransaction();


        $missionprogram = $this->find($id);

        $missionprogram->update($validatedData);

        DB::commit();
        return $missionprogram;
    }


    public function destroy($id)
    {
        $missionprogram = $this->find($id);

        DB::beginTransaction();


        $missionprogram->delete();
        DB::commit();

        return true;
    }

    public function find($id){
        return $this->findByIdOrFail(MissionProgram::class, 'MissionProgram', $id);
    }

}
