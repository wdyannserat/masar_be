<?php

namespace App\Http\Resources;

use App\Services\ChildService;
use Illuminate\Support\Facades\Auth;

class ChallengeResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $keys = [
            'id'                            => $this->id,
            'name'                          => $this->name,
            'points'                        => $this->points,
            'is_timed'                      => $this->is_timed,
            'duration_in_days'              => $this->duration_in_days,
            'duration_in_hours'             => $this->duration_in_hours,
            'status'                        => $this->status,
            'attachment'                    => $this->resource($this->whenLoaded('attachment'),AttachmentResource::class),
            'mission'                       => $this->resource($this->whenLoaded('mission'),MissionResource::class),
            'created_at'                    => $this->created_at
        ];

        if(Auth::guard('children')->check()){
            $keys['child_challenge_status']  = ChildService::checkChallengeIsDone(Auth::guard('children')->id(),$this->id);
        }
        return $keys;
    }
}
