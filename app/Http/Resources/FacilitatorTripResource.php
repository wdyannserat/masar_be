<?php

namespace App\Http\Resources;


class FacilitatorTripResource extends BaseResource
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
            'type'                      => $this->type,
            'facilitator_id'            => $this->facilitator_id,
            'trip_id'                   => $this->trip_id,
            'created_at'                => $this->created_at
        ];
    }
}
