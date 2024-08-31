<?php

namespace App\Services;

use App\Models\PositionTrip;
use Illuminate\Support\Facades\DB;


class PositionTripService extends BaseService
{
    public function getAll()
    {
        return  PositionTrip::all();
    }


    public function store($validatedData)
    {
        DB::beginTransaction();

        $positiontrip = PositionTrip::create($validatedData);
        DB::commit();
        return $positiontrip;
    }

    public function show($id)
    {
        $positiontrip = $this->find($id);

        return $positiontrip;
    }


    public function update($validatedData, $id)
    {
        DB::beginTransaction();


        $positiontrip = $this->find($id);

        $positiontrip->update($validatedData);

        DB::commit();
        return $positiontrip;
    }


    public function destroy($id)
    {
        $positiontrip = $this->find($id);

        DB::beginTransaction();


        $positiontrip->delete();
        DB::commit();

        return true;
    }

    public function find($id)
    {
        return $this->findByIdOrFail(PositionTrip::class, 'PositionTrip', $id);
    }
}
