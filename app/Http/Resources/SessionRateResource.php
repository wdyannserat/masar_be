<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SessionRateResource extends JsonResource
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
            'child_id'              => $this->child_id,
            'program_session_id'    => $this->program_session_id,
            'rate'                  => $this->rate,
            'created_at'            => $this->created_at,
        ];
    }
}
