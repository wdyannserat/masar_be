<?php

namespace App\Http\Resources;


class SessionChecklistResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'                        => $this->id,
            'attendance'                => $this->attendance,
            'description'               => $this->description,
            'child_id'                  => $this->child_id,
            'group_schedule_id'         => $this->group_schedule_id,
            'created_at'                => $this->created_at
        ];
    }
}
