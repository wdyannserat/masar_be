<?php

namespace App\Services;

use App\Models\Challenge;
use App\Models\ChallengeChild;
use App\Models\Child;
use App\Models\ChildMission;
use App\Models\Mission;
use App\Models\MissionProgram;
use App\Models\Program;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ChallengeService extends BaseService
{
    public function __construct(private AttachmentService $attachmentService)
    {
    }

    public function getAll()
    {
        return  Challenge::all();
    }

    public function store($validatedData)
    {
        if (request()->routeIs('challenges_store')) {
            request()->myFiles = [];
        }
        DB::beginTransaction();
        //*create attachment if there is any files
        $files[0]['file'] = $validatedData['challenge_photo'];

        $attachment = $this->attachmentService->store([
            'files' => $files
        ], 'Challenges');

        if (!isset($attachment)) {
            throw new Exception('Error in create Attachment', 400);
        }

        $challenge = Challenge::create(
            array_merge(
                [
                    'attachment_id' => $attachment->id,
                ],
                $validatedData
            )
        );
        DB::commit();
        return $challenge;
    }

    public function show($id)
    {
        $challenge = $this->find($id);

        return $challenge->load('attachment', 'mission');
    }

    public function update($validatedData, $id)
    {
        DB::beginTransaction();


        $challenge = $this->find($id);

        $challenge->update($validatedData);

        DB::commit();
        return $challenge;
    }

    public function destroy($id)
    {
        $challenge = $this->find($id);
        $attachmentId = $challenge->attachment_id;
        DB::beginTransaction();
        $challenge->delete();
        $this->attachmentService->destroy($attachmentId);

        DB::commit();

        return true;
    }

    public function startChallenge($id)
    {
        $challenge = $this->find($id);
        if (!$challenge->isActive()) {
            throw new Exception(__('messages.ObjectNotActive', ['object' => __('objects.Challenge')]));
        }
        DB::beginTransaction();

        $challengeForChild = ChallengeChild::where([
            'challenge_id' => $challenge->id,
            'child_id' => Auth::guard('children')->id(),
        ])->whereIn('status', ['Pending', 'Not_Completed'])->first();

        if (isset($challengeForChild)) {
            throw new Exception(__('messages.ChallengeAlreadyStarted'), 400);
        }
        $challenge->children()->attach(Auth::guard('children')->user(), [
            'progress' => 25,
            'status' => 'Not_Completed',
        ]);

        $missionId = $challenge->mission->id;

        $missionProgram = MissionProgram::where([
            'mission_id' => $missionId,
            'program_id' => Program::isRunning()->first()->id
        ])->first();

        $childMission = ChildMission::where([
            'child_id' => Auth::guard('children')->id(),
            'mission_program_id' => $missionProgram->id
        ])->first();

        if (!isset($childMission)) {
            ChildMission::create([
                'child_id' => Auth::guard('children')->id(),
                'mission_program_id' => $missionProgram->id,
                'status' => 'InProgress',
                'progress' => 0
            ]);
        }
        DB::commit();
    }

    public function documentChallenge($validatedData, $id)
    {
        DB::beginTransaction();
        request()->myFiles = [];
        $challenge = $this->find($id);
        $challengeForChild = ChallengeChild::where([
            'challenge_id'  => $challenge->id,
            'child_id'      => Auth::guard('children')->id(),
            'status'        => 'Not_Completed'
        ])->first();

        if (!isset($challengeForChild)) {
            throw new Exception(__('messages.YouCantDocumentChallenge'), 400);
        }

        $attachment = $this->attachmentService->store([
            'files' => $validatedData['files']
        ], 'Child_Document_Challenge');

        if (!isset($attachment)) {
            throw new Exception('Error in create Attachment', 400);
        }
        $challengeForChild->update([
            'attachment_id' => $attachment->id,
            'status' => 'Pending',
            'progress' => 50
        ]);
        DB::commit();
    }


    public function getCompletedChallengesCount(Child $child)
    {
        return ChallengeChild::where([
            'status' => 'Completed',
            'child_id' => $child->id
        ])->get()->count();
    }


    public function find($id)
    {
        return $this->findByIdOrFail(Challenge::class, 'Challenge', $id);
    }
}
