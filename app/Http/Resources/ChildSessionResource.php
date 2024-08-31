<?php

namespace App\Http\Resources;


class ChildSessionResource extends BaseResource
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
            'status'                    => $this->status,
            'description'               => $this->description,
            'child_id'                  => $this->child_id,
            'session_id'                => $this->session_id,
            'created_at'                => $this->created_at
        ];
    }
}
