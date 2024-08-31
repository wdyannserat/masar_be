<?php

namespace App\Services;

use App\Models\ChildQuestion;
use Illuminate\Support\Facades\DB;


class ChildQuestionService extends BaseService
{
    public function getAll()
    {
        return  ChildQuestion::all();
    }


    public function store($validatedData)
    {
        DB::beginTransaction();

        $childquestion = ChildQuestion::create($validatedData);
        DB::commit();
        return $childquestion;
    }

    public function show($id)
    {
        $childquestion = $this->find($id);

        return $childquestion;
    }


    public function update($validatedData, $id)
    {
        DB::beginTransaction();


        $childquestion = $this->find($id);

        $childquestion->update($validatedData);

        DB::commit();
        return $childquestion;
    }


    public function destroy($id)
    {
        $childquestion = $this->find($id);

        DB::beginTransaction();


        $childquestion->delete();
        DB::commit();

        return true;
    }

    public function find($id)
    {
        return $this->findByIdOrFail(ChildQuestion::class, 'ChildQuestion', $id);
    }
}
