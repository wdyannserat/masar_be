<?php

namespace App\Services;

use App\Models\ChildSession;
use App\Models\FacilitatorGroup;
use App\Models\GroupSchedule;
use App\Models\GroupSession;
use App\Models\Program;
use App\Models\ProgramSession;
use App\Models\Session;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class SessionService extends BaseService
{
    public function __construct(
        private ChildService $childService
    ) {
    }

    public function getAll()
    {
        return  Session::all();
    }

    public function getCurrentProgramSessions()
    {
        return Session::whereHas('programSession', function ($query) {
            $query->whereHas('program', function ($query) {
                $query->where('status', 'Running');
            });
        })->get();
    }

    public function getSessionsForChild()
    {
        /**
         * @var Child $child
         */
        $child = Auth::guard('children')->user();

        $childGroupsIds = $child->groups()->wherePivot('status', 'Active')->get()->pluck('id');

        $groupSchedulesIds = GroupSchedule::whereIn('group_id', $childGroupsIds)
            ->get()->pluck('id');

        $groupSessions =  DB::table('group_session')
            ->join('program_session', 'group_session.program_session_id', '=', 'program_session.id')
            ->join('sessions', 'program_session.session_id', '=', 'sessions.id')
            ->whereIn('group_session.id', $groupSchedulesIds)
            ->select('sessions.*', 'group_session.status')
            ->orderBy('group_session.created_at')
            ->get()
            ->unique();

        $sessions = Session::whereIn('id', $groupSessions->pluck('id'))->with('concepts', 'questions')->get();

        foreach ($groupSessions as $key => $groupSession) {
            $sessions[$key]->status = $groupSessions[$key]->status;
        }
        return $sessions->sortByDesc('status');
    }

    public function store($validatedData)
    {
        DB::beginTransaction();

        $session = Session::create($validatedData);
        DB::commit();
        return $session;
    }

    public function childStartSession(Session $session)
    {
        DB::beginTransaction();
        /**
        * @var Child $child
         */
        $child = Auth::guard('children')->user();

        ChildSession::create([
            'child_id' => $child->id,
            'session_id' => $session->id,
            'status' => 'not_completed'
        ]);
        DB::commit();
        return true;
    }

    public function closeSession($validatedData, $id)
    {
        DB::beginTransaction();
        $session = $this->find($id);
        $program = Program::getCurrentRunningProgram();

        $programSession = $program->sessions()->wherePivot('session_id', $session->id)->first()->pivot;
        $validatedData = collect(GroupScheduleService::find($validatedData['group_schedule_id']))->toArray();

        //? 1-check the facilitator if can close session or not for this group

        $facilitatorGroup = FacilitatorGroup::where([
            'group_id' => $validatedData['group_id'],
            'facilitator_id' => Auth::guard('users')->id()
        ])->first();

        if (!isset($facilitatorGroup)) {
            throw new Exception(__('messages.NoPermission'), 403);
        }

        //? 2-check group schedule if exist for entered time
        $date = Carbon::parse($validatedData['date']);
        $dayOfWeekNumber = $date->dayOfWeek;

        $groupSchedulesIds = GroupSchedule::where([
            'group_id'          => $validatedData['group_id'],
            'day_number'        => $dayOfWeekNumber,
            'date'              => $validatedData['date'],
            'arrival_time'      => $validatedData['arrival_time'],
            'departure_time'    => $validatedData['departure_time'],
        ])
            ->orWhere(function ($query) use ($validatedData) {
                $query->where('date', '<', $validatedData['date'])
                    ->where('group_id', $validatedData['group_id']);
            })->get()->pluck('id');

        if (!isset($groupSchedulesIds) || count($groupSchedulesIds) == 0) {
            throw new Exception(__('messages.ObjectNotFound', ['object' => __('objects.GroupSchedule')]), 404);
        }

        //? 3- fetch all group schedules that before the current group schedule and have the same session
        /*
        * because group can take on session over multiple days ex: Sunday,Monday,Tuesday for Session One
        */

        $groupSessions = GroupSession::whereIn('group_schedule_id', $groupSchedulesIds)
            ->where('program_session_id', $programSession->id)
            ->where('status', 'Opened')->get();

        foreach ($groupSessions as $groupSession) {
            $groupSession->update([
                'status' => 'Closed'
            ]);
        }
        DB::commit();
    }

    public function show($id)
    {
        $session = $this->find($id);

        return $session->load('questions', 'concepts');
    }


    public function update($validatedData, $id)
    {
        DB::beginTransaction();


        $session = $this->find($id);

        $session->update($validatedData);

        DB::commit();
        return $session;
    }


    public function destroy($id)
    {
        $session = $this->find($id);

        DB::beginTransaction();


        $session->delete();
        DB::commit();

        return true;
    }

    // public function getGroupSchedulesWithSession($groupId)
    // {
    //     $group = GroupService::find($groupId);
    //     $groupSchedules = $group->groupSchedules;
    //     // $sessions = Session::whereHas('groupSessions', function ($query) use ($groupSchedules) {
    //     //     $query->whereIn('group_schedule_id', $groupSchedules->pluck('id'));
    //     // })->with('concepts','groupSessions.groupSchedule')->get();
    //     $groupSchedules = DB::table('group_schedules')
    //         ->join('group_session', 'group_schedules.id', '=', 'group_session.group_schedule_id')
    //         ->join('program_session', 'group_session.program_session_id', '=', 'program_session.id')
    //         ->join('sessions', 'sessions.id', '=', 'program_session.session_id')
    //         ->select('group_schedules.*', 'sessions.id as session_id')
    //         ->where('group_schedules.group_id',$group->id)
    //         ->get();

    //     foreach($groupSchedules as $groupSchedule){
    //         $groupSchedule->session = SessionService::find($groupSchedule->session_id);
    //     }
    //     return new Collection($groupSchedules);
    // }



    public static function find($id)
    {
        return parent::findByIdOrFail(Session::class, 'Session', $id);
    }
}
