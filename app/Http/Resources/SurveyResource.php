<?php

namespace App\Http\Resources;


class SurveyResource extends BaseResource
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
            'age_type_id'                   => $this->age_type_id,
            'url'                           => $this->url,
            'created_at'                    => $this->created_at
        ];
    }
}
