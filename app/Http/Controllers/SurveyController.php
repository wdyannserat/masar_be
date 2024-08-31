<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SurveyService;
use App\Http\Requests\SurveyRequest;
use App\Http\Resources\SurveyResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SurveyController extends BaseController
{

    public function __construct(private SurveyService $surveyService)
    {
    }

    public function index()
    {
        if (Auth::guard('users')->check() && Auth::guard('users')->user()->role == 'Parent') {
            $surveys = $this->surveyService->getSurveysForParents();
        } else {
            $surveys = $this->surveyService->getAll();
        }
        return $this->successResponse(
            $this->resource($surveys, SurveyResource::class),
            'DataSuccessfullyFetched',
            'Surveys'
        );
    }


    public function store(SurveyRequest $request)
    {
        return $this->successResponse(
            $this->surveyService->store($request->validated()),
            'AddedSuccessfully',
            'Survey'
        );
    }

    public function show(Request $request)
    {
        return $this->successResponse(
            $this->resource($this->surveyService->show($request->id), SurveyResource::class),
            'DataSuccessfullyFetched',
            'Survey'
        );
    }

    public function update(SurveyRequest $request, $id)
    {
        $this->surveyService->update($request->validated(), $id);

        return $this->successResponse(
            null,
            'UpdatedSuccessfully',
            'Survey'
        );
    }

    public function destroy($id)
    {
        $this->surveyService->destroy($id);

        return $this->successResponse(
            null,
            'DeletedSuccessfully',
            'Survey'
        );
    }
}
