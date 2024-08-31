<?php

namespace App\Http\Resources;


class QuestionResource extends BaseResource
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
            'type'                              => $this->type,
            'question'                          => $this->question,
            'correct_answer'                    => $this->correct_answer,
            'session'                           => $this->resource($this->whenLoaded('session'),SessionResource::class),
            'suggestedAnswers'                  => $this->resource($this->whenLoaded('suggestedAnswers'),SuggestedAnswerResource::class),
            'created_at'                        => $this->created_at
        ];
    }
}
