<?php

namespace App\Http\Resources;

use App\Traits\ResourceHelper;

class AttachmentResource extends BaseResource
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
            'id'                    => $this->id,
            'type'                  => $this->type,
            'files'                 => $this->resource($this->files, FileResource::class),
            'created_at'            => $this->created_at
        ];
    }
}
