<?php

namespace App\Http\Resources;


class MonitorTripResource extends BaseResource
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
            'id'                                => $this->id,
            'type'                              => $this->type,
            'reason_of_switch'                  => $this->reason_of_switch,
            'expected_facilitator_id'           => $this->expected_facilitator_id,
            'actual_facilitator_id'             => $this->actual_facilitator_id,
            'trip_id'                           => $this->trip_id,
            'created_at'                        => $this->created_at
        ];
    }
}
