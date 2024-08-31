<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SessionService;
use App\Http\Requests\SessionRequest;
use App\Http\Resources\SessionResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\GroupScheduleSessionResource;

class SessionController extends BaseController
{

    public function __construct(private SessionService $sessionService)
    {
    }

    public function index()
    {
        return $this->successResponse(
            $this->resource($this->sessionService->getAll(), SessionResource::class),
            'DataSuccessfullyFetched',
            'Sessions'
        );
    }

    public function getCurrentProgramSessions()
    {
        return $this->successResponse(
            $this->resource($this->sessionService->getCurrentProgramSessions(), SessionResource::class),
            'DataSuccessfullyFetched',
            'Sessions'
        );
    }

    public function getSessionsForChild()
    {
        return $this->successResponse(
            $this->resource($this->sessionService->getSessionsForChild(), SessionResource::class),
            'DataSuccessfullyFetched',
            'Sessions'
        );
    }


    public function store(SessionRequest $request)
    {
        return $this->successResponse(
            $this->resource($this->sessionService->store($request->validated()), SessionResource::class),
            'AddedSuccessfully',
            'Session'
        );
    }

    public function childStartSession($id)
    {
        $session = $this->sessionService->find($id);
        return $this->successResponse(
            $this->sessionService->childStartSession($session),
            'AddedSuccessfully',
            'Session'
        );
    }

    public function closeSession(SessionRequest $request, $id)
    {
        return $this->successResponse(
            $this->sessionService->closeSession($request->validated(), $id),
            'SessionClosedSuccessfully',
            'Session'
        );
    }

    public function show(Request $request)
    {
        return $this->successResponse(
            $this->resource($this->sessionService->show($request->id), SessionResource::class),
            'DataSuccessfullyFetched',
            'Session'
        );
    }

    public function update(SessionRequest $request, $id)
    {
        return $this->successResponse(
            $this->sessionService->update($request->validated(), $id),
            'UpdatedSuccessfully',
            'Session'
        );
    }

    public function destroy($id)
    {
        return $this->successResponse(
            $this->sessionService->destroy($id),
            'DeletedSuccessfully',
            'Session'
        );
    }
}
