<?php

namespace App\Http\Resources;


class AgeTypeResource extends BaseResource
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
            'age_type'                  => $this->age_type,
            'ages'                      => $this->when($this->ages != null, function () {
                return array_map('intval', $this->ages);
            }, []),
            'min_age'                   => $this->min_age,
            'max_age'                   => $this->max_age,
            'notes'                     => $this->notes,
            'created_at'                => $this->created_at
        ];
    }
}
