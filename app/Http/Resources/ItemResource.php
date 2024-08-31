<?php

namespace App\Http\Resources;


class ItemResource extends BaseResource
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
            'status'                            => $this->status,
            'quantity'                          => $this->quantity,
            'name'                              => $this->name,
            'point_price'                       => $this->point_price,
            'category'                          => $this->category,
            'created_at'                        => $this->created_at
        ];
    }
}
