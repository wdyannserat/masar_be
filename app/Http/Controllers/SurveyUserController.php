<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SurveyUserService;
use App\Http\Requests\SurveyUserRequest;
use App\Http\Resources\SurveyUserResource;
use App\Http\Controllers\Controller;

class SurveyUserController extends BaseController
{

    public function __construct(private SurveyUserService $surveyUserService)
    {
    }

    public function index()
    {
        return $this->successResponse(
            $this->resource($this->surveyUserService->getAll(), SurveyUserResource::class),
            'DataSuccessfullyFetched',
            'SurveyUsers'
        );
    }


    public function store(SurveyUserRequest $request)
    {
        return $this->successResponse(
            $this->surveyUserService->store($request->validated()),
            'AddedSuccessfully',
            'SurveyUser'
        );
    }

    public function show(Request $request)
    {
        return $this->successResponse(
            $this->resource($this->surveyUserService->show($request->id), SurveyUserResource::class),
            'DataSuccessfullyFetched',
            'SurveyUser'
        );
    }

    public function update(SurveyUserRequest $request, $id)
    {
        $this->surveyUserService->update($request->validated(), $id);

        return $this->successResponse(
            null,
            'UpdatedSuccessfully',
            'SurveyUser'
        );
    }

    public function destroy($id)
    {
        $this->surveyUserService->destroy($id);

        return $this->successResponse(
            null,
            'DeletedSuccessfully',
            'SurveyUser'
        );
    }
}
