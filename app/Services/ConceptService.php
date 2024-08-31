<?php

namespace App\Services;

use App\Models\Concept;
use Illuminate\Support\Facades\DB;


class ConceptService extends BaseService
{
    public function getAll($sessionId)
    {
        return  Concept::where('session_id', $sessionId)->get();
    }


    public function store($validatedData, $sessionId)
    {
        DB::beginTransaction();

        $concept = Concept::create(
            array_merge(
                $validatedData,
                [
                    'session_id' => $sessionId,
                ]
            )
        );
        DB::commit();
        return $concept;
    }

    public function show($id)
    {
        $concept = $this->find($id);

        return $concept;
    }


    public function update($validatedData, $id)
    {
        DB::beginTransaction();


        $concept = $this->find($id);

        $concept->update($validatedData);

        DB::commit();
        return $concept;
    }


    public function destroy($id)
    {
        $concept = $this->find($id);

        DB::beginTransaction();


        $concept->delete();
        DB::commit();

        return true;
    }

    public function find($id)
    {
        return $this->findByIdOrFail(Concept::class, 'Concept', $id);
    }
}
