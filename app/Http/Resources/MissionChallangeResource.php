<?php

namespace App\Http\Resources;

use App\Traits\ResourceHelper;

class MissionChallangeResource extends BaseResource
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
            'name'                          => $this->name,
            'category'                      => $this->category,
            'total_points'                  => $this->total_points,
            'number_of_challenges'          => $this->number_of_challenges,
            'badge_name'                    => $this->badge_name,
            'badge_url'                     => $this->badge_url,
            'attachment'                    => $this->resource($this->whenLoaded('attachment'), AttachmentResource::class),
            'challenges'                    => $this->resource($this->whenLoaded('challenges'), ChallengeResource::class),
            'created_at'                    => $this->created_at
        ];
    }
}
