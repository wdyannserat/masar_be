<?php

namespace App\Http\Resources;


class GroupSessionResource extends BaseResource
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
            'id'                            => $this->id,
            'description'                   => $this->description,
            'session_id'                    => $this->session_id,
            'group_id'                      => $this->group_id,
            'created_at'                    => $this->created_at
        ];
    }
}
