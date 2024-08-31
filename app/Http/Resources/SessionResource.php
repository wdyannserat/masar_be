<?php

namespace App\Http\Resources;


class SessionResource extends BaseResource
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
            'id'                    => $this->id,
            'name'                  => $this->name,
            'category'              => $this->category,
            'questions'             => $this->resource($this->whenLoaded('questions'),QuestionResource::class),
            'concepts'              => $this->resource($this->whenLoaded('concepts'),ConceptResource::class),
            'created_at'            => $this->created_at
        ];
         if(request()->routeIs('child_sessions')){
            $keys['status']  = $this->status;
         }

         return $keys;
    }
}
