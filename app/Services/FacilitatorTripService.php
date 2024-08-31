<?php

namespace App\Services;

use App\Models\FacilitatorTrip;
use Illuminate\Support\Facades\DB;


class FacilitatorTripService extends BaseService
{
    public function getAll()
    {
        return  FacilitatorTrip::all();
    }


    public function store($validatedData)
    {
        DB::beginTransaction();

        $facilitatortrip = FacilitatorTrip::create($validatedData);
        DB::commit();
        return $facilitatortrip;
    }

    public function show($id)
    {
        $facilitatortrip = $this->find($id);

        return $facilitatortrip;
    }


    public function update($validatedData, $id)
    {
        DB::beginTransaction();


        $facilitatortrip = $this->find($id);

        $facilitatortrip->update($validatedData);

        DB::commit();
        return $facilitatortrip;
    }


    public function destroy($id)
    {
        $facilitatortrip = $this->find($id);

        DB::beginTransaction();


        $facilitatortrip->delete();
        DB::commit();

        return true;
    }

    public function find($id)
    {
        return $this->findByIdOrFail(FacilitatorTrip::class, 'FacilitatorTrip', $id);
    }
}
