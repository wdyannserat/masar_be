<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FacilitatorService;
use App\Http\Requests\FacilitatorRequest;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\ChallengeChildResource;
use App\Http\Resources\GroupResource;
use App\Models\ChallengeChild;

class FacilitatorController extends BaseController
{

    public function __construct(private FacilitatorService $facilitatorService)
    {
    }

    public function index()
    {
        return $this->successResponse(
            $this->resource($this->facilitatorService->getAll(), UserResource::class),
            'DataSuccessfullyFetched',
            'Facilitators'
        );
    }


    public function store(FacilitatorRequest $request)
    {
        return $this->successResponse(
            $this->resource($this->facilitatorService->store($request->validated()), UserResource::class),
            'AddedSuccessfully',
            'Facilitator'
        );
    }

    public function show(Request $request)
    {
        return $this->successResponse(
            $this->resource($this->facilitatorService->show($request->id), UserResource::class),
            'DataSuccessfullyFetched',
            'Facilitator'
        );
    }

    public function update(FacilitatorRequest $request, $id)
    {
        $this->facilitatorService->update($request->validated(), $id);

        return $this->successResponse(
            null,
            'UpdatedSuccessfully',
            'Facilitator'
        );
    }

    public function destroy($id)
    {
        $this->facilitatorService->destroy($id);

        return $this->successResponse(
            null,
            'DeletedSuccessfully',
            'Facilitator'
        );
    }

    public function mangeChallengeRequest(FacilitatorRequest $request)
    {
        return $this->successResponse(
            $this->facilitatorService->mangeChallengeRequest($request->validated()),
            'ChildChallengeRequestHandledSuccessfully',
            'Facilitator'
        );
    }

    public function getChallengeConfirmRequests(Request $request)
    {
        return $this->successResponse(
            $this->resource($this->facilitatorService->getChallengeConfirmRequests(), ChallengeChildResource::class),
            'DataSuccessfullyFetched',
            'ChallengeConfirmRequests'
        );
    }

    public function getMyGroups()
    {
        return $this->successResponse(
            $this->resource($this->facilitatorService->getMyGroups(), GroupResource::class),
            'DataSuccessfullyFetched',
            'Groups'
        );
    }
}
