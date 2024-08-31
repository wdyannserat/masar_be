<?php

namespace App\Services;

use App\Models\SessionChecklist;
use App\Models\GroupSchedule;
use Illuminate\Support\Facades\DB;


class SessionChecklistService extends BaseService
{
    public function getAll()
    {
        return  SessionChecklist::all();
    }


    public function store($validatedData)
    {
        DB::beginTransaction();

        foreach ($validatedData['children'] as $child) {
            SessionChecklist::create([
                'attendance'        => $child['attendance'],
                'description'       => isset($child['description']) ? $child['description'] : null,
                'group_schedule_id' => $validatedData['group_schedule_id'],
                'child_id'          => $child['id'],
            ]);
        }
        DB::commit();
        return true;
    }

    public function show($id)
    {
        $childSessionChecklist = $this->find($id);

        return $childSessionChecklist;
    }


    public function update($validatedData, $id)
    {
        DB::beginTransaction();


        $childSessionChecklist = $this->find($id);

        $childSessionChecklist->update($validatedData);

        DB::commit();
        return $childSessionChecklist;
    }


    public function destroy($id)
    {
        $childSessionChecklist = $this->find($id);

        DB::beginTransaction();


        $childSessionChecklist->delete();
        DB::commit();

        return true;
    }

    public function find($id)
    {
        return $this->findByIdOrFail(SessionChecklist::class, 'SessionChecklist', $id);
    }
}
