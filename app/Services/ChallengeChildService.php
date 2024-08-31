<?php

namespace App\Services;

use App\Models\ChallengeChild;
use Illuminate\Support\Facades\DB;


class ChallengeChildService extends BaseService
{
    public function getAll()
    {
        return  ChallengeChild::all();
    }


    public function store($validatedData)
    {
        DB::beginTransaction();

        $challengechild = ChallengeChild::create($validatedData);
        DB::commit();
        return $challengechild;
    }

    public function show($id)
    {
        $challengechild = $this->find($id);

        return $challengechild;
    }


    public function update($validatedData, $id)
    {
        DB::beginTransaction();


        $challengechild = $this->find($id);

        $challengechild->update($validatedData);

        DB::commit();
        return $challengechild;
    }


    public function destroy($id)
    {
        $challengechild = $this->find($id);

        DB::beginTransaction();


        $challengechild->delete();
        DB::commit();

        return true;
    }

    public function find($id)
    {
        return $this->findByIdOrFail(ChallengeChild::class, 'ChallengeChild', $id);
    }
}
