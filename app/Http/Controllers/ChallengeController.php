<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ChallengeService;
use App\Http\Requests\ChallengeRequest;
use App\Http\Resources\ChallengeResource;
use App\Http\Controllers\Controller;

class ChallengeController extends BaseController
{
    public function __construct(private ChallengeService $challengeService)
    {
    }

    public function index()
    {
        return $this->successResponse(
            $this->resource($this->challengeService->getAll(), ChallengeResource::class),
            'DataSuccessfullyFetched',
            'Challenges'
        );
    }


    public function store(ChallengeRequest $request)
    {
        return $this->successResponse(
            $this->challengeService->store($request->validated()),
            'AddedSuccessfully',
            'Challenge'
        );
    }

    public function show(Request $request)
    {
        return $this->successResponse(
            $this->resource($this->challengeService->show($request->id), ChallengeResource::class),
            'DataSuccessfullyFetched',
            'Challenge'
        );
    }

    public function update(ChallengeRequest $request, $id)
    {
        $this->challengeService->update($request->validated(), $id);

        return $this->successResponse(
            null,
            'UpdatedSuccessfully',
            'Challenge'
        );
    }

    public function destroy($id)
    {
        $this->challengeService->destroy($id);

        return $this->successResponse(
            null,
            'DeletedSuccessfully',
            'Challenge'
        );
    }

    public function startChallenge(ChallengeRequest $request, $id)
    {
        return $this->successResponse(
            $this->challengeService->startChallenge($id),
            'ChallengeStartedSuccessfully',
            'Challenge'
        );
    }

    public function documentChallenge(ChallengeRequest $request, $id)
    {
        return $this->successResponse(
            $this->challengeService->documentChallenge($request->validated(), $id),
            'AddedSuccessfully',
            'Challenge'
        );
    }
}
