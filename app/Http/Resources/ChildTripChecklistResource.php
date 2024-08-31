<?php

namespace App\Http\Resources;


class ChildTripChecklistResource extends BaseResource
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
            'monitor_trip_id'           => $this->monitor_trip_id,
            'child_id'                  => $this->child_id,
            'created_at'                => $this->created_at
        ];
    }
}
