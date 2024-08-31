<?php

namespace App\Http\Resources;


class AnswerResource extends BaseResource
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
            'answer'                    => $this->answer,
            'result'                    => $this->result,
            'question_id'               => $this->question_id,
            'form_applied_id'           => $this->form_applied_id,
            'created_at'                => $this->created_at
        ];
    }
}
