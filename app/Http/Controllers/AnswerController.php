<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AnswerService;
use App\Http\Requests\AnswerRequest;
use App\Http\Resources\AnswerResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\ChildQuestionResource;

class AnswerController extends BaseController
{
    //this is for test
    public function __construct(private AnswerService $answerService)
    {
    }

    public function index()
    {
        return $this->successResponse(
            $this->resource($this->answerService->getAll(), AnswerResource::class),
            'DataSuccessfullyFetched',
            'Answers'
        );
    }


    public function store(AnswerRequest $request)
    {
        return $this->successResponse(
            $this->answerService->store($request->validated()),
            'AddedSuccessfully',
            'Answer'
        );
    }

    public function show(Request $request)
    {
        return $this->successResponse(
            $this->resource($this->answerService->show($request->id), AnswerResource::class),
            'DataSuccessfullyFetched',
            'Answer'
        );
    }

    public function update(AnswerRequest $request, $id)
    {
        $this->answerService->update($request->validated(), $id);

        return $this->successResponse(
            null,
            'UpdatedSuccessfully',
            'Answer'
        );
    }

    public function destroy($id)
    {
        $this->answerService->destroy($id);

        return $this->successResponse(
            null,
            'DeletedSuccessfully',
            'Answer'
        );
    }

    public function answerQuestion(AnswerRequest $request, $questionId)
    {
        return $this->successResponse(
            $this->answerService->answerQuestion($request->validated(), $questionId),
            'AddedSuccessfully',
            'Answer'
        );
    }

    public function getChildAnswer($questionId, $childId)
    {
        return $this->successResponse(
            $this->resource($this->answerService->getChildAnswer($questionId, $childId),ChildQuestionResource::class),
            'DataSuccessfullyFetched',
            'Answer'
        );
    }
}
