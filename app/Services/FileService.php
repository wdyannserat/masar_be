<?php

namespace App\Services;

use App\Models\File;
use Illuminate\Support\Facades\DB;


class FileService extends BaseService
{
    public function getAll()
    {
        return  File::all();
    }


    public function store($validatedData)
    {
        DB::beginTransaction();

        $file = File::create($validatedData);
        DB::commit();
        return $file;
    }

    public function show($id)
    {
        $file = $this->find($id);

        return $file;
    }


    public function update($validatedData, $id)
    {
        DB::beginTransaction();


        $file = $this->find($id);

        $file->update($validatedData);

        DB::commit();
        return $file;
    }


    public function destroy($id)
    {
        $file = $this->find($id);

        DB::beginTransaction();


        $file->delete();
        DB::commit();

        return true;
    }

    public function find($id)
    {
        return $this->findByIdOrFail(File::class, 'File', $id);
    }
}
