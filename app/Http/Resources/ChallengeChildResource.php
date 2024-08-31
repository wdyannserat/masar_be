<?php

namespace App\Http\Resources;

use App\Models\Attachment;
use App\Traits\ResourceHelper;

class ChallengeChildResource extends BaseResource
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
            'progress'                  => $this->progress,
            'status'                    => $this->status,
            'description'               => $this->description,
            'challenge'                 => $this->resource($this->whenLoaded('challenge'),ChallengeResource::class),
            'child'                     => $this->resource($this->whenLoaded('child'),ChildResource::class),
            'attachment'                => $this->resource($this->whenLoaded('attachment'),AttachmentResource::class),
            'created_at'                => $this->created_at
        ];
    }
}
