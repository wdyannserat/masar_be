<?php

namespace App\Http\Resources;


class GroupScheduleResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $days = [
            '1' => 'Sunday',
            '2' => 'Monday',
            '3' => 'Tuesday',
            '4' => 'Wednesday',
            '5' => 'Thursday',
            '6' => 'Friday',
            '7' => 'Saturday'
        ];
        return [
            'id'                        => $this->id,
            'arrival_time'              => $this->arrival_time,
            'departure_time'            => $this->departure_time,
            'day_name'                  => $days[$this->day_number],
            'date'                      => $this->date,
            'group_id'                  => $this->group_id,
            'created_at'                => $this->created_at
        ];
    }
}
