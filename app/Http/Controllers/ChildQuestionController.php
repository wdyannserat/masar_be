<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ChildQuestionService;
use App\Http\Requests\ChildQuestionRequest;
use App\Http\Resources\ChildQuestionResource;
use App\Http\Controllers\Controller;

class ChildQuestionController extends BaseController
{

    public function __construct(private ChildQuestionService $childQuestionService)
    {
    }

    public function index()
    {
        return $this->successResponse(
            $this->resource($this->childQuestionService->getAll(), ChildQuestionResource::class),
            'DataSuccessfullyFetched',
            'ChildQuestions'
        );
    }


    public function store(ChildQuestionRequest $request)
    {
        return $this->successResponse(
            $this->childQuestionService->store($request->validated()),
            'AddedSuccessfully',
            'ChildQuestion'
        );
    }

    public function show(Request $request)
    {
        return $this->successResponse(
            $this->resource($this->childQuestionService->show($request->id), ChildQuestionResource::class),
            'DataSuccessfullyFetched',
            'ChildQuestion'
        );
    }

    public function update(ChildQuestionRequest $request, $id)
    {
        $this->childQuestionService->update($request->validated(), $id);

        return $this->successResponse(
            null,
            'UpdatedSuccessfully',
            'ChildQuestion'
        );
    }

    public function destroy($id)
    {
        $this->childQuestionService->destroy($id);

        return $this->successResponse(
            null,
            'DeletedSuccessfully',
            'ChildQuestion'
        );
    }
}
