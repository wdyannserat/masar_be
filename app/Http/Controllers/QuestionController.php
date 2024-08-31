<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\QuestionService;
use App\Http\Requests\QuestionRequest;
use App\Http\Resources\QuestionResource;
use App\Http\Controllers\Controller;
use App\Services\SessionService;

class QuestionController extends BaseController
{

    public function __construct(
        private QuestionService $questionService,
        private SessionService $sessionService
    ) {
    }

    public function index($sessionId)
    {
        $this->sessionService->find($sessionId);
        return $this->successResponse(
            $this->resource($this->questionService->getAll($sessionId), QuestionResource::class),
            'DataSuccessfullyFetched',
            'Questions'
        );
    }


    public function store(QuestionRequest $request, $sessionId)
    {
        $this->sessionService->find($sessionId);
        return $this->successResponse(
            $this->resource($this->questionService->store($request->validated(), $sessionId), QuestionResource::class),
            'AddedSuccessfully',
            'Question'
        );
    }

    public function show(Request $request)
    {
        return $this->successResponse(
            $this->resource($this->questionService->show($request->id), QuestionResource::class),
            'DataSuccessfullyFetched',
            'Question'
        );
    }

    public function childAnswerOnQuestion(QuestionRequest $request,$id)
    {
        $question = $this->questionService->find($id);

        return $this->successResponse(
            $this->questionService->childAnswerOnQuestion($request->validated(),$question),
            'AddedSuccessfully',
            'ChildAnswer'
        );
    }

    public function update(QuestionRequest $request, $id)
    {
        return $this->successResponse(
            $this->questionService->update($request->validated(), $id),
            'UpdatedSuccessfully',
            'Question'
        );
    }

    public function destroy($id)
    {
        return $this->successResponse(
            $this->questionService->destroy($id),
            'DeletedSuccessfully',
            'Question'
        );
    }
}
