<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChildDetailsResource extends BaseResource
{

    public function toArray($request)
    {
        return [
            'id'                        => $this->id,
            'full_name'                 => $this->full_name,
            'username'                  => $this->username,
            'gender'                    => $this->gender,
            'birth_date'                => $this->birth_date,
            'is_active'                 => $this->is_active,
            'parent_full_name'          => $this->parent->parent_full_name,
            'attachment'                => $this->resource($this->whenLoaded('attachment'), AttachmentResource::class),
            'position_id'               => $this->position_id,
            'trip_id'                   => $this->trip_id,
            'badges'                    => $this->badges,
            'missions'                  => $this->resource($this->missions,MissionResource::class),
            'sessions'                  => $this->resource($this->sessions,SessionResource::class),
            'created_at'                => $this->created_at
        ];
    }
}
