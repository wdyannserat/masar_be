<?php

namespace App\Services;

use App\Models\GroupSchedule;
use App\Models\GroupSession;
use App\Models\Program;
use App\Models\ProgramSession;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;


class GroupScheduleService extends BaseService
{
    public function __construct(
        private GroupService $groupService
    ) {
    }

    public function getAll()
    {
        return  GroupSchedule::all();
    }

    public function getSessionForGroupSchedule($groupScheduleId)
    {
        $groupSchedule = GroupScheduleService::find($groupScheduleId);
        $groupSession = $groupSchedule->groupSessions()->first();
        if(!isset($groupSession)){
            throw new Exception(__('messages.SessionNotFoundForThisGroupSchedule'),404);
        }
        $groupSchedule->session = $groupSession->programSession->session->load('concepts');
        return $groupSchedule;
    }


    public function store($validatedData, $id)
    {
        $group = $this->groupService->find($id);
        $groupSchedules = new Collection();
        DB::beginTransaction();
        foreach ($validatedData['arrival_times'] as $groupSchedule) {
            $groupSchedules->push(
                GroupSchedule::create([
                    'group_id'          => $group->id,
                    'arrival_time'      => $groupSchedule['arrival_time'],
                    'departure_time'    => $groupSchedule['departure_time'],
                    'date'              => $groupSchedule['date'],
                    'day_number'          => $groupSchedule['day_number'],
                ])
            );
        }
        DB::commit();
        return $groupSchedules;
    }

    public function assignSessions($validatedData, $id)
    {
        DB::beginTransaction();

        $program = Program::isRunning()->first();
        $this->find($id);

        foreach ($validatedData['sessionsIds'] as $sessionInfo) {
            $programSession = ProgramSession::where([
                'program_id' => $program->id,
                'session_id' => $sessionInfo['id']
            ])->first();

            if ($programSession == null) {
                throw new Exception(__('messages.SessionsIsNotInCurrentProgram'), 400);
            }

            GroupSession::create([
                'group_schedule_id' => $id,
                'program_session_id' => $programSession->id,
                'description' => isset($sessionInfo['description']) ?:  null
            ]);
        }



        DB::commit();
    }

    public function show($id)
    {
        $groupSchedule = $this->find($id);

        return $groupSchedule;
    }


    public function update($validatedData, $id)
    {
        DB::beginTransaction();


        $groupSchedule = $this->find($id);

        $groupSchedule->update($validatedData);

        DB::commit();
        return $groupSchedule;
    }


    public function destroy($id)
    {
        $groupSchedule = $this->find($id);

        DB::beginTransaction();


        $groupSchedule->delete();
        DB::commit();

        return true;
    }

    public static function find($id)
    {
        return parent::findByIdOrFail(GroupSchedule::class, 'GroupSchedule', $id);
    }
}
