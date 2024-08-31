<?php

namespace App\Http\Resources;


class ProgramResource extends BaseResource
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
            'name'                              => $this->name,
            'address'                           => $this->address,
            'start_date'                        => $this->start_date,
            'end_date'                          => $this->end_date,
            'status'                            => $this->status,
            'notes'                             => $this->notes,
            'created_at'                        => $this->created_at
        ];
    }
}
