<?php

namespace App\Services;

use App\Models\ProgramSession;
use Illuminate\Support\Facades\DB;


class ProgramSessionService extends BaseService
{
    public function getAll()
    {
        return  ProgramSession::all();
    }


    public function store($validatedData)
    {
        DB::beginTransaction();

        $programsession = ProgramSession::create($validatedData);
        DB::commit();
        return $programsession;
    }

    public function show($id)
    {
        $programsession = $this->find($id);

        return $programsession;
    }


    public function update($validatedData , $id)
    {
        DB::beginTransaction();


        $programsession = $this->find($id);

        $programsession->update($validatedData);

        DB::commit();
        return $programsession;
    }


    public function destroy($id)
    {
        $programsession = $this->find($id);

        DB::beginTransaction();


        $programsession->delete();
        DB::commit();

        return true;
    }

    public function find($id){
        return $this->findByIdOrFail(ProgramSession::class, 'ProgramSession', $id);
    }

}
