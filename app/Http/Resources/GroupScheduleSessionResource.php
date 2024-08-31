<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GroupScheduleSessionResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    private $days = [
        '1' => 'Sunday',
        '2' => 'Monday',
        '3' => 'Tuesday',
        '4' => 'Wednesday',
        '5' => 'Thursday',
        '6' => 'Friday',
        '7' => 'Saturday'
    ];
    public function toArray($request)
    {

        // if (request()->routeIs('group_schedules_store')) {
        return [
            'id'                        => $this->id,
            'arrival_time'              => $this->arrival_time,
            'departure_time'            => $this->departure_time,
            'day_name'                  => $this->days[$this->day_number],
            'date'                      => $this->date,
            'group_id'                  => $this->group_id,
            'session'                   => $this->resource($this->session,SessionResource::class),
            'created_at'                => $this->created_at
        ];
        // }
    }
}
