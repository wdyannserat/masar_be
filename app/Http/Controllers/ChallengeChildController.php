<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ChallengeChildService;
use App\Http\Requests\ChallengeChildRequest;
use App\Http\Resources\ChallengeChildResource;
use App\Http\Controllers\Controller;

class ChallengeChildController extends BaseController
{

    public function __construct(private ChallengeChildService $challengeChildService)
    {
    }

    public function index()
    {
        return $this->successResponse(
            $this->resource($this->challengeChildService->getAll(), ChallengeChildResource::class),
            'DataSuccessfullyFetched',
            'ChallengeChildren'
        );
    }


    public function store(ChallengeChildRequest $request)
    {
        return $this->successResponse(
            $this->challengeChildService->store($request->validated()),
            'AddedSuccessfully',
            'ChallengeChild'
        );
    }

    public function show(Request $request)
    {
        return $this->successResponse(
            $this->resource($this->challengeChildService->show($request->id), ChallengeChildResource::class),
            'DataSuccessfullyFetched',
            'ChallengeChild'
        );
    }

    public function update(ChallengeChildRequest $request, $id)
    {
        $this->challengeChildService->update($request->validated(), $id);

        return $this->successResponse(
            null,
            'UpdatedSuccessfully',
            'ChallengeChild'
        );
    }

    public function destroy($id)
    {
        $this->challengeChildService->destroy($id);

        return $this->successResponse(
            null,
            'DeletedSuccessfully',
            'ChallengeChild'
        );
    }
}
