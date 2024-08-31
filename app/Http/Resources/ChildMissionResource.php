<?php

namespace App\Http\Resources;


class ChildMissionResource extends BaseResource
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
            'id'                    => $this->id,
            'progress'              => $this->progress,
            'mission_id'            => $this->mission_id,
            'child_id'              => $this->child_id,
            'created_at'            => $this->created_at
        ];
    }
}
