<?php

namespace App\Services;

use App\Models\Position;
use Illuminate\Support\Facades\DB;


class PositionService extends BaseService
{
    public function getAll()
    {
        return  Position::all();
    }


    public function store($validatedData)
    {
        DB::beginTransaction();

        $position = Position::create($validatedData);
        DB::commit();
        return $position;
    }

    public function show($id)
    {
        $position = $this->find($id);

        return $position;
    }


    public function update($validatedData, $id)
    {
        DB::beginTransaction();


        $position = $this->find($id);

        $position->update($validatedData);

        DB::commit();
        return $position;
    }


    public function destroy($id)
    {
        $position = $this->find($id);

        DB::beginTransaction();


        $position->delete();
        DB::commit();

        return true;
    }

    public function find($id)
    {
        return $this->findByIdOrFail(Position::class, 'Position', $id);
    }
}
