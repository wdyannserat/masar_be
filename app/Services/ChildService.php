<?php

namespace App\Services;

use App\Models\Attachment;
use App\Models\ChallengeChild;
use App\Models\Child;
use App\Models\ChildMission;
use App\Models\File;
use App\Models\Mission;
use App\Models\MissionProgram;
use App\Models\Program;
use App\Models\Session;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PhpParser\ErrorHandler\Collecting;

class ChildService extends BaseService
{
    public function __construct(
        private UserService $userService,
        private AttachmentService $attachmentService
    ) {
    }

    public function getAll()
    {
        return  Child::with('attachment', 'parent')->get();
    }


    public function store($validatedData)
    {
        request()->myFiles = [];
        DB::beginTransaction();

        //*create parent account
        $parent = $this->userService->checkIfParentExists($validatedData['parent_phone_number']);

        if (!isset($parent)) {
            $parent = $this->userService->store([
                'role'               => 'Parent',
                'parent_full_name'   => $validatedData['parent_full_name'],
                'username'           => $this->generateUserName('Parent', $validatedData['parent_full_name']),
                'password'           => Hash::make($validatedData['parent_phone_number']),
                'phone_number'       => $validatedData['parent_phone_number'],
                'email'              => isset($validatedData['parent_email']) ? $validatedData['parent_email'] : null,
                'address'            => $validatedData['address'],
                'number_of_children' => 0
            ]);
        }

        //*create attachment if there is any files
        $attachment = null;
        if (isset($validatedData['files']) && count($validatedData['files']) > 0) {
            $attachment = $this->attachmentService->store([
                'files' => $validatedData['files']
            ], 'Child_Info');
            if (!isset($attachment)) {
                throw new Exception('Error in create Attachment', 400);
            }
        }

        $validatedData['attachment_id'] = $attachment ? $attachment->id : null;

        //*create child account
        $validatedData['parent_id'] = $parent->id;
        $validatedData['username']  = $this->generateUserName('Child', $validatedData['first_name']);
        $validatedData['password']  = Hash::make($validatedData['parent_phone_number']);
        $validatedData['is_active'] = true;
        $child = Child::create($validatedData);
        $parent->number_of_children += 1;
        $parent->save();
        DB::commit();
        return $child->load('attachment', 'parent');
    }

    public function show($id)
    {
        $child = $this->find($id);

        return $child->load('attachment', 'parent');
    }

    public function getDetails($id)
    {
        $child = $this->find($id);
        $child->badges = $child->getBadges();
        $child->missions =  $this->getMissionsForChild($child);
        $child->sessions = $this->getSessionForChild($child);
        return $child->load('attachment', 'parent');
    }


    public function update($validatedData, $id)
    {
        DB::beginTransaction();


        $child = $this->find($id);
        $attachment = null;
        if (isset($validatedData['files']) && count($validatedData['files']) > 0) {
            request()->myFiles = [];

            $attachment = $this->attachmentService->store([
                'files' => $validatedData['files']
            ], 'Child_Info');
            if (!isset($attachment)) {
                throw new Exception('Error in create Attachment', 400);
            }
        }

        if (isset($validatedData['parent_full_name']) || isset($validatedData['parent_email']) || isset($validatedData['parent_phone_number'])) {
            $parent            = $child->parent;
            $parentEmail       = isset($validatedData['parent_email']) ? $validatedData['parent_email'] : $parent->email;
            $parentPhoneNumber = isset($validatedData['parent_phone_number']) ? $validatedData['parent_phone_number'] : $parent->phone_number;
            $parentFullName    = isset($validatedData['parent_full_name']) ? $validatedData['parent_full_name'] : $parent->parent_full_name;
            $parentUserName    = $parent->username;
            $parentPassword    = $parent->password;

            if (isset($validatedData['parent_full_name'])) {
                $parentUserName    = $this->generateUserName('Parent', $validatedData['parent_full_name']);
            }

            if (isset($validatedData['parent_phone_number'])) {
                $parentPassword   = Hash::make($parentPhoneNumber);
            }


            $updatedParentData = [
                'email'             => $parentEmail,
                'phone_number'      => $parentPhoneNumber,
                'parent_full_name'  => $parentFullName,
                'username'          => $parentUserName,
                'password'          => $parentPassword,
                'address'           => isset($validatedData['address']) ? $validatedData['address'] : $parent->address
            ];

            $parent->update($updatedParentData);
        }

        $validatedData['attachment_id'] = $attachment ? $attachment->id : null;
        if (isset($validatedData['first_name']) & $child->first_name != $validatedData['first_name']) {
            $validatedData['username'] = $this->generateUserName('Child', $validatedData['first_name']);
        }
        $child->update($validatedData);

        DB::commit();
        return $child->load('attachment');
    }


    public function destroy($id)
    {
        $child = $this->find($id);

        DB::beginTransaction();

        $child->attachment()->delete();

        $child->delete();
        DB::commit();

        return true;
    }

    public static function find($id)
    {
        return parent::findByIdOrFail(Child::class, 'Child', $id);
    }

    public function getMissionsForChild(Child $child)
    {
        $missions  = $child->childMission->load('missionProgram.mission')->pluck('missionProgram.mission')->unique();

        return new Collection($missions);
    }

    public function getSessionForChild(Child $child)
    {
        $sessions = Session::whereHas('programSession', function ($query) {
            $query->whereHas('program', function ($query) {
                $query->where('status', 'Running');
            });
        })->whereHas('questions', function ($query) use ($child) {
            $query->whereHas('answers', function ($query) use ($child) {
                $query->whereHas('childSession', function ($query) use ($child) {
                    $query->where([
                        'child_id' => $child->id,
                        'status' => 'not_completed'
                    ]);
                });
            });
        })->with('questions')->get();

        return new Collection($sessions);
    }

    public static function checkMissionIsDone($missionId)
    {
        $program = Program::where('status', 'Running')->first();
        $missionProgram = MissionProgram::where([
            'mission_id' => $missionId,
            'program_id' => $program->id
        ])->first();

        $childMission = ChildMission::where([
            'child_id' => Auth::guard('children')->user()->id,
            'mission_program_id' => $missionProgram->id,
            'status' => 'Done'
        ])->first();

        return   isset($childMission) ?: false;
    }

    public static function checkChallengeIsDone($childId, $challengeId)
    {
        $challengeChild = ChallengeChild::where([
            'challenge_id' => $challengeId,
            'child_id' => $childId,
        ])->first();

        return isset($challengeChild) ? $challengeChild->status : null;
    }
}
