<?php

namespace App\Services;

use App\Models\ChallengeChild;
use App\Models\Child;
use App\Models\ChildGroup;
use App\Models\ChildMission;
use App\Models\FacilitatorGroup;
use App\Models\Mission;
use App\Models\MissionProgram;
use App\Models\Program;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class FacilitatorService extends BaseService
{
    public function __construct(
        private AttachmentService $attachmentService,
        private GroupService $groupService,
        private ChildService $childService,
        private ChallengeService $challengeService
    ) {
    }

    public function getAll()
    {
        return  User::where([
            'role' => 'Facilitator'
        ])->get();
    }


    public function store($validatedData)
    {
        DB::beginTransaction();
        $attachmentId = null;
        if (isset($validatedData['files'])   && count($validatedData['files']) > 0) {
            request()->myFiles = [];
            $attachmentId = $this->attachmentService->store([
                'files' => $validatedData['files']
            ], 'User_Info')->id;

            if (!isset($attachmentId)) {
                throw new Exception('Error in create Attachment', 400);
            }
        }


        $facilitator = User::create(array_merge(
            $validatedData,
            [
                'username'      => $this->generateUserName('Facilitator', $validatedData['first_name']),
                'password'      => Hash::make(12345678),
                'role'          => 'Facilitator',
                'attachment_id' => $attachmentId
            ]
        ));

        // $facilitator->groups()->attach($this->groupService->find($validatedData['group_id']));


        DB::commit();

        return $facilitator->load('groups');
    }

    public function show($id)
    {
        $facilitator = $this->find($id);

        return $facilitator;
    }


    public function update($validatedData, $id)
    {
        DB::beginTransaction();

        $facilitator = $this->find($id);

        $facilitator->update($validatedData);

        DB::commit();
        return $facilitator;
    }


    public function destroy($id)
    {
        $facilitator = $this->find($id);

        DB::beginTransaction();


        $facilitator->delete();
        DB::commit();

        return true;
    }

    public function mangeChallengeRequest($validatedData)
    {
        DB::beginTransaction();
        //******************************************** */
        //******************************************** */
        $challenge = $this->challengeService->find($validatedData['challenge_id']);

        //? 1-check if facilitator is active
        /**
         * @var  User $facilitator
         */
        $facilitator = Auth::guard('users')->user();
        if (!$facilitator->isActive()) {
            throw new Exception(__('messages.userNotActive', ['object' => __('objects.Facilitator')]), 403);
        }
        //******************************************** */
        //******************************************** */
        //? 2- check current facilitator can approve this child challenge request
        $child = $this->childService->find($validatedData['child_id']);
        /**
         *  @var ChildGroup $childGroup
         */
        $childGroup =  $child->groups()->where('status', 'Active')->first();

        $facilitatorGroup = $facilitator->groups()->where('group_id', $childGroup->id)->first();

        if (!isset($facilitatorGroup)) {
            throw new Exception(__('messages.NoPermission'), 403);
        }
        //******************************************** */
        //******************************************** */
        //? 3- check if this child have document this challenge

        $challengeForChild = ChallengeChild::where([
            'child_id' => $child->id,
            'challenge_id' => $challenge->id,
            'status' => 'Pending'
        ])->first();

        if (!isset($challengeForChild)) {
            throw new Exception('Error : check child id or challenge id or the status of challenge for this child is not Pending', 400);
        }

        $challengeForChild->update([
            'status' => $validatedData['status'] == 'Accepted' ? 'Completed' : 'Rejected',
            'description' => isset($validatedData['description']) ? $validatedData['description'] : null,
            'progress' => $validatedData['status'] == 'Accepted' ? 100 : 50
        ]);

        if ($validatedData['status'] == 'Accepted') {
            $child->update([
                'points' => $child->points + $challengeForChild->challenge->points
            ]);

            $mission = Mission::whereHas('challenges', function ($query) use ($challenge) {
                $query->where('id', $challenge->id);
            })->inRunningProgram()->first();

            $missionProgram = MissionProgram::where([
                'mission_id' => $mission->id,
                'program_id' => Program::isRunning()->first()->id
            ])->first();

            $childMission = ChildMission::where([
                'child_id' => $child->id,
                'mission_program_id' => $missionProgram->id
            ])->first();

            $progress  = ( $this->challengeService->getCompletedChallengesCount($child) / $mission->number_of_challenges ) * 100;

            $childMission->update([
                'progress' => $progress,
                'status' => $progress == 100 ? 'Done' : 'InProgress'
            ]);
        }



        DB::commit();

        return $challengeForChild;
    }

    public function getChallengeConfirmRequests()
    {
        /**
         * @var User $facilitator
         */
        $facilitator = Auth::guard('users')->user();
        $groupsIds = $facilitator->groups->pluck('id');
        $childrenIds = Child::whereHas('groups', function ($query) use ($groupsIds) {
            $query->whereIn('groups.id', $groupsIds);
        })->get()->pluck('id');

        $challengeForChildren = ChallengeChild::whereIn('child_id', $childrenIds)->with('attachment', 'child', 'challenge')->get();

        return $challengeForChildren;
    }

    public function getMyGroups()
    {
        /**
        * @var User $facilitator
        *
        */
        $facilitator = Auth::guard('users')->user();

        return $facilitator->groups;

    }

    public function find($id)
    {
        return $this->findByIdOrFail(User::class, 'Facilitator', $id);
    }
}
