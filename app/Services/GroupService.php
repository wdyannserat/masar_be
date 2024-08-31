<?php

namespace App\Services;

use App\Models\ChildGroup;
use App\Models\Group;
use App\Models\GroupSchedule;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;


class GroupService extends BaseService
{
    public function getAll()
    {
        return  Group::with('program','ageType')->get();
    }


    public function store($validatedData)
    {
        DB::beginTransaction();

        $group = Group::create($validatedData);
        DB::commit();
        return $group;
    }

    public function assignFacilitator($validatedData, $id)
    {
        DB::beginTransaction();
        $group = $this->find($id);

        $facilitators = User::whereIn('id', $validatedData['facilitatorsIds'])->where('role', 'Facilitator')->get();

        $group->facilitators()->attach($facilitators);

        DB::commit();
    }

    public function assignChildren($validatedData, $id)
    {
        DB::beginTransaction();
        $group = $this->find($id);

        foreach ($validatedData['children'] as $child) {
            ChildGroup::create([
                'child_id' => $child['id'],
                'group_id' => $group->id,
                'description' => isset($child['description']) ? $child['description'] : null,
                'status' => $child['status'],
            ]);
        }
        DB::commit();
    }

    public function show($id)
    {
        $group = $this->find($id);

        //? 1- get the facilitators for the group
        //? 2- get the children
        //? 3- get the group schedule data for this group

        return $group->load('facilitators', 'children', 'groupSchedules','program','ageType');
    }


    public function update($validatedData, $id)
    {
        DB::beginTransaction();


        $group = $this->find($id);

        $group->update($validatedData);

        DB::commit();
        return $group;
    }


    public function destroy($id)
    {
        $group = $this->find($id);

        DB::beginTransaction();


        $group->delete();
        DB::commit();

        return true;
    }

    public function deleteChildFromGroup($groupId, $childId)
    {
        DB::beginTransaction();
        $childGroup = ChildGroup::where([
            'child_id' => $childId,
            'group_id' => $groupId
        ])->first();

        if(!isset($childGroup)){
            throw new Exception(__('messages.ObjectNotFound',['object' => __('objects.Child')]),404);
        }

        $childGroup->delete();

        DB::commit();
        return true;
    }



    public static function find($id)
    {
        return parent::findByIdOrFail(Group::class, 'Group', $id);
    }
}
