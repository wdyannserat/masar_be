<?php

namespace App\Http\Resources;


class ItemRequestResource extends BaseResource
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
            'status'                    => $this->status,
            'item_id'                   => $this->item_id,
            'child_id'                  => $this->child_id,
            'created_at'                => $this->created_at
        ];
    }
}
