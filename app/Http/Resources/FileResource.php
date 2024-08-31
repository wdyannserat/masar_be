<?php

namespace App\Http\Resources;


class FileResource extends BaseResource
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
            'type'                          => $this->type,
            'file_path'                     => $this->file_path,
            'description'                   => $this->description,
            'order'                         => $this->order,
            'attachment_id'                 => $this->attachment_id,
            'created_at'                    => $this->created_at
        ];
    }
}
