<?php

namespace App\Http\Resources;


class ChildResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if (request()->routeIs('children_show')) {
            return [
                'id'                        => $this->id,
                'first_name'                => $this->first_name,
                'last_name'                 => $this->last_name,
                'username'                  => $this->username,
                'gender'                    => $this->gender,
                'school_name'               => $this->school_name,
                'birth_date'                => $this->birth_date,
                'notes'                     => $this->notes,
                'is_active'                 => $this->is_active,
                'parent_id'                 => $this->parent_id,
                'role'                      => 'Child',
                'parent'                    => $this->resource($this->whenLoaded('parent'), UserResource::class),
                'attachment'                => $this->resource($this->whenLoaded('attachment'), AttachmentResource::class),
                'position_id'               => $this->position_id,
                'trip_id'                   => $this->trip_id,
                'created_at'                => $this->created_at
            ];
        }
        return [
            'id'                        => $this->id,
            'first_name'                => $this->first_name,
            'last_name'                 => $this->last_name,
            'username'                  => $this->username,
            'gender'                    => $this->gender,
            'school_name'               => $this->school_name,
            'notes'                     => $this->notes,
            'birth_date'                => $this->birth_date,
            'is_active'                 => $this->is_active,
            'role'                      => 'Child',
            'parent_id'                 => $this->parent_id,
            'parent'                    => $this->resource($this->whenLoaded('parent'), UserResource::class),
            'attachment'                => $this->resource($this->whenLoaded('attachment'), AttachmentResource::class),
            'position_id'               => $this->position_id,
            'trip_id'                   => $this->trip_id,
            'created_at'                => $this->created_at
        ];
    }
}
