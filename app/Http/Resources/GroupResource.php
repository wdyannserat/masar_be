<?php

namespace App\Http\Resources;

use App\Models\Child;

class GroupResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if (request()->routeIs('groups_show')) {
            return [
                'id'                            => $this->id,
                'name'                          => $this->name,
                'children_count'                => $this->children_count,
                'notes'                         => $this->notes,
                'program'                       => $this->resource($this->whenLoaded('program'), ProgramResource::class),
                'age_type'                      => $this->resource($this->whenLoaded('ageType'), AgeTypeResource::class),
                'children'                      => $this->resource($this->whenLoaded('children'), ChildResource::class),
                'facilitators'                  => $this->resource($this->whenLoaded('facilitators'), UserResource::class),
                'groupSchedules'                => $this->resource($this->whenLoaded('groupSchedules'), GroupScheduleResource::class),
                'created_at'                    => $this->created_at
            ];
        } else if (request()->routeIs('groups_index') || request()->routeIs('groups_for_program')) {
            return [
                'id'                            => $this->id,
                'name'                          => $this->name,
                'children_count'                => $this->children_count,
                'notes'                         => $this->notes,
                'age_type'                      => $this->resource($this->whenLoaded('ageType'), AgeTypeResource::class),
                'program'                       => $this->resource($this->whenLoaded('program'), ProgramResource::class),
                'created_at'                    => $this->created_at
            ];
        } else if (request()->routeIs('get_my_groups')) {
            return [
                'id'                            => $this->id,
                'name'                          => $this->name,
                'children_count'                => $this->children_count,
                'notes'                         => $this->notes,
                'age_type_id'                   => $this->age_type_id,
                'program_id'                    => $this->program_id,
                'created_at'                    => $this->created_at
            ];
        }

        return [
            'id'                            => $this->id,
            'name'                          => $this->name,
            'children_count'                => $this->children_count,
            'notes'                         => $this->notes,
            'age_type_id'                   => $this->age_type_id,
            'program_id'                    => $this->program_id,
            'created_at'                    => $this->created_at
        ];
    }
}
