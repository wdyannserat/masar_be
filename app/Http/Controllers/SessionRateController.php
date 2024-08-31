<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SessionRateService;
use App\Http\Requests\SessionRateRequest;
use App\Http\Resources\SessionRateResource;
use App\Http\Controllers\Controller;
use App\Services\SessionService;

class SessionRateController extends BaseController
{

    public function __construct(private SessionRateService $sessionRateService)
    {}

    public function index()
    {
        return $this->successResponse(
            $this->resource($this->sessionRateService->getAll(),SessionRateResource::class),
            'DataSuccessfullyFetched',
            'SessionRates'
        );
    }


    public function store(SessionRateRequest $request,$sessionId)
    {
        SessionService::find($sessionId);
        return $this->successResponse(
            $this->resource($this->sessionRateService->store($request->validated(),$sessionId),SessionRateResource::class),
            'AddedSuccessfully',
            'SessionRate'
        );
    }

    public function show(SessionRateRequest  $request)
    {
        return $this->successResponse(
            $this->resource($this->sessionRateService->show($request->id),SessionRateResource::class),
            'DataSuccessfullyFetched',
            'SessionRate'
        );
    }

    public function update(SessionRateRequest $request , $id)
    {
        return $this->successResponse(
            $this->sessionRateService->update( $request->validated(),$id),
            'UpdatedSuccessfully',
            'SessionRate'
        );
    }

    public function destroy($id)
    {
        return $this->successResponse(
            $this->sessionRateService->destroy($id),
            'DeletedSuccessfully',
            'SessionRate'
        );
    }
}
