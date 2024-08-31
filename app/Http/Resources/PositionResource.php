<?php

namespace App\Http\Resources;


class PositionResource extends BaseResource
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
            'address'                           => $this->address,
            'name'                              => $this->name,
            'latitude'                          => $this->latitude,
            'longitude'                         => $this->longitude,
            'created_at'                        => $this->created_at
        ];
    }
}
