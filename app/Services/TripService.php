<?php

namespace App\Services;

use App\Models\Trip;
use Illuminate\Support\Facades\DB;


class TripService extends BaseService
{
    public function getAll()
    {
        return  Trip::all();
    }


    public function store($validatedData)
    {
        DB::beginTransaction();

        $trip = Trip::create($validatedData);
        DB::commit();
        return $trip;
    }

    public function show($id)
    {
        $trip = $this->find($id);

        return $trip;
    }


    public function update($validatedData, $id)
    {
        DB::beginTransaction();


        $trip = $this->find($id);

        $trip->update($validatedData);

        DB::commit();
        return $trip;
    }


    public function destroy($id)
    {
        $trip = $this->find($id);

        DB::beginTransaction();


        $trip->delete();
        DB::commit();

        return true;
    }

    public function find($id)
    {
        return $this->findByIdOrFail(Trip::class, 'Trip', $id);
    }
}
