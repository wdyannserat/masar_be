<?php

namespace App\Services;

use App\Models\GroupSession;
use Illuminate\Support\Facades\DB;


class GroupSessionService extends BaseService
{
    public function getAll()
    {
        return  GroupSession::all();
    }


    public function store($validatedData)
    {
        DB::beginTransaction();

        $groupsession = GroupSession::create($validatedData);
        DB::commit();
        return $groupsession;
    }

    public function show($id)
    {
        $groupsession = $this->find($id);

        return $groupsession;
    }


    public function update($validatedData, $id)
    {
        DB::beginTransaction();


        $groupsession = $this->find($id);

        $groupsession->update($validatedData);

        DB::commit();
        return $groupsession;
    }


    public function destroy($id)
    {
        $groupsession = $this->find($id);

        DB::beginTransaction();


        $groupsession->delete();
        DB::commit();

        return true;
    }

    public function find($id)
    {
        return $this->findByIdOrFail(GroupSession::class, 'GroupSession', $id);
    }
}
