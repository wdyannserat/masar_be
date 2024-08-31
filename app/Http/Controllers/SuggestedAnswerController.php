<?php

namespace App\Http\Controllers;

use App\Http\Requests\SuggestedAnswerRequest;
use App\Services\SuggestedAnswerService;
use App\Http\Resources\SuggestedAnswerResource;

class SuggestedAnswerController extends BaseController
{
    public function __construct(private SuggestedAnswerService $suggestedAnswerService)
    {
    }

    public function index($questionId)
    {
        return $this->successResponse(
            $this->resource($this->suggestedAnswerService->getAll($questionId), SuggestedAnswerResource::class),
            'DataSuccessfullyFetched',
            'SuggestedAnswers'
        );
    }


    public function store($questionId, SuggestedAnswerRequest $request)
    {
        return $this->successResponse(
            $this->suggestedAnswerService->store($questionId, $request->validated()),
            'AddedSuccessfully',
            'SuggestedAnswer'
        );
    }

    public function update(SuggestedAnswerRequest $request, $id)
    {
        $this->suggestedAnswerService->update($request->validated(), $id);

        return $this->successResponse(
            null,
            'UpdatedSuccessfully',
            'SuggestedAnswer'
        );
    }

    public function destroy($id)
    {
        $this->suggestedAnswerService->destroy($id);

        return $this->successResponse(
            null,
            'DeletedSuccessfully',
            'SuggestedAnswer'
        );
    }
}
