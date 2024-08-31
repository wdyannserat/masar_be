<?php

namespace App\Http\Resources;

use App\Traits\ResourceHelper;

class UserResource extends BaseResource
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
            'id'                                            => $this->id,
            'first_name'                                    => $this->first_name,
            'last_name'                                     => $this->last_name,
            'username'                                      => $this->username,
            'phone_number'                                  => $this->phone_number,
            'address'                                       => $this->address,
            'gender'                                        => $this->gender,
            'role'                                          => $this->role,
            'is_active'                                     => $this->is_active,
            'email'                                         => $this->email,
            'notes'                                         => $this->notes,
            'attachment'                                    => $this->resource($this->whenLoaded('attachment'), AttachmentResource::class),
            'created_at'                                    => $this->created_at
        ];
        if ($this->role == 'Parent') {
            $keys['number_of_children']                     = $this->number_of_children;
            $keys['parent_full_name']                       = $this->parent_full_name;
        } else if ($this->role == 'Facilitator') {
            $keys['birth_date']                             = $this->birth_date;
            $keys['volunteering_start_date']                = $this->volunteering_start_date;
            $keys['volunteering_end_date']                  = $this->volunteering_end_date;
            $keys['groups']                                 = $this->resource($this->whenLoaded('groups'), GroupResource::class);
        } else if ($this->role == 'Manager') {
            $keys['birth_date']                             = $this->birth_date;
        }
        return $keys;
    }
}
