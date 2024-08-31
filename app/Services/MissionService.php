<?php

namespace App\Services;

use App\Models\Mission;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class MissionService extends BaseService
{
    public function __construct(
        private ChallengeService $challengeService,
        private AttachmentService $attachmentService,
        private ChildService $childService,

    ) {
    }


    public function getAll()
    {
        return  Mission::all()->load('attachment', 'challenges');
    }



    public function store($validatedData)
    {
        DB::beginTransaction();
        request()->myFiles = [];

        //*create attachment if there is any files
        $files[0]['file'] = $validatedData['photo'];

        $attachment = $this->attachmentService->store([
            'files' => $files
        ], 'Missions');

        if (!isset($attachment)) {
            throw new Exception('Error in create Attachment', 400);
        }

        $badgeUrl = $this->uploadFile($validatedData['badge_image'], 'missions_files/');
        array_push(request()->myFiles, $badgeUrl);

        $mission = Mission::create(array_merge(
            collect($validatedData)->except('challenges')->toArray(),
            [
                'attachment_id' => $attachment->id,
                'number_of_challenges' => count($validatedData['challenges']),
                'badge_url'   => $badgeUrl,
            ]
        ));

        foreach ($validatedData['challenges'] as $challenge) {
            $challenge = $this->challengeService->store(
                array_merge(
                    [
                        'mission_id'  => $mission->id
                    ],
                    $challenge
                )
            );
        }
        DB::commit();
        return $mission;
    }

    public function show($id)
    {
        $mission = $this->find($id);

        return $mission->load('challenges.attachment','attachment');
    }


    public function update($validatedData, $id)
    {
        DB::beginTransaction();


        $mission = $this->find($id);

        $mission->update($validatedData);

        DB::commit();
        return $mission;
    }


    public function destroy($id)
    {
        $mission = $this->find($id);
        $attachmentId = $mission->attachment_id;
        DB::beginTransaction();
        foreach ($mission->challenges as $challenge) {
            $this->challengeService->destroy($challenge->id);
        }
        $mission->delete();
        $this->attachmentService->destroy($attachmentId);
        DB::commit();

        return true;
    }

    public function getCurrentProgramMissions()
    {
        return Mission::whereHas('programs', function ($query) {
            $query->where('status', 'Running');
        })->get();
    }

    public function find($id)
    {
        return $this->findByIdOrFail(Mission::class, 'Mission', $id);
    }
}
