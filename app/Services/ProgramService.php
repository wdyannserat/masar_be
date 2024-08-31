<?php

namespace App\Services;

use App\Models\Mission;
use App\Models\Program;
use App\Models\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ProgramService extends BaseService
{
    public function getAll()
    {
        return  Program::all();
    }

    public function getProgramsRequests()
    {
        return Program::whereStatus('Pending')->get();
    }


    public function store($validatedData)
    {
        DB::beginTransaction();
        //TODO make the manager approve the operation of create program
        if(Auth::guard('users')->user()->role == 'Manager'){
            $validatedData['status'] = 'Accepted';
        }
        else {
             $validatedData['status'] = 'Pending';
        }
        $program = Program::create($validatedData);
        DB::commit();
        return $program;
    }

    public function assignSessions($validatedData, $id)
    {
        DB::beginTransaction();
        $program = $this->find($id);

        $sessions = Session::whereIn('id', $validatedData['sessionsIds'])->get();

        $program->sessions()->attach($sessions);

        DB::commit();
    }

    public function assignMissions($validatedData, $id)
    {
        DB::beginTransaction();
        $program = $this->find($id);

        $missions = Mission::whereIn('id', $validatedData['missionsIds'])->get();

        $program->missions()->attach($missions);
        $program->save();
        DB::commit();
    }

    public function show($id)
    {
        $program = $this->find($id);

        return $program;
    }


    public function update($validatedData, $id)
    {
        DB::beginTransaction();

        $program = $this->find($id);

        $program->update($validatedData);

        DB::commit();
        return $program;
    }


    public function destroy($id)
    {
        $program = $this->find($id);

        DB::beginTransaction();


        $program->delete();
        DB::commit();

        return true;
    }

    public function endProgram($id)
    {
        $program = $this->find($id);

        DB::beginTransaction();


        $program->update([
            'status' => 'Finished',
            'end_date' => now()
        ]);
        DB::commit();

        return true;
    }

    public function getGroupsByProgramId($id)
    {
        $program = $this->find($id);

        return $program->groups->load('ageType');
    }

    public function find($id)
    {
        return $this->findByIdOrFail(Program::class, 'Program', $id);
    }
}
