<?php

namespace App\Services;

use App\Models\MonitorTrip;
use Illuminate\Support\Facades\DB;


class MonitorTripService extends BaseService
{
    public function getAll()
    {
        return  MonitorTrip::all();
    }


    public function store($validatedData)
    {
        DB::beginTransaction();

        $monitortrip = MonitorTrip::create($validatedData);
        DB::commit();
        return $monitortrip;
    }

    public function show($id)
    {
        $monitortrip = $this->find($id);

        return $monitortrip;
    }


    public function update($validatedData, $id)
    {
        DB::beginTransaction();


        $monitortrip = $this->find($id);

        $monitortrip->update($validatedData);

        DB::commit();
        return $monitortrip;
    }


    public function destroy($id)
    {
        $monitortrip = $this->find($id);

        DB::beginTransaction();


        $monitortrip->delete();
        DB::commit();

        return true;
    }

    public function find($id)
    {
        return $this->findByIdOrFail(MonitorTrip::class, 'MonitorTrip', $id);
    }
}
