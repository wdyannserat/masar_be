<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ConceptService;
use App\Http\Requests\ConceptRequest;
use App\Http\Resources\ConceptResource;
use App\Http\Controllers\Controller;
use App\Services\SessionService;

class ConceptController extends BaseController
{

    public function __construct(
        private ConceptService $conceptService,
        private SessionService $sessionService
    ) {
    }

    public function index($sessionId)
    {
        $this->sessionService->find($sessionId);

        return $this->successResponse(
            $this->resource($this->conceptService->getAll($sessionId), ConceptResource::class),
            'DataSuccessfullyFetched',
            'Concepts'
        );
    }


    public function store(ConceptRequest $request, $sessionId)
    {
        $this->sessionService->find($sessionId);

        return $this->successResponse(
            $this->resource($this->conceptService->store($request->validated(), $sessionId), ConceptResource::class),
            'AddedSuccessfully',
            'Concept'
        );
    }

    public function show(Request $request)
    {
        return $this->successResponse(
            $this->resource($this->conceptService->show($request->id), ConceptResource::class),
            'DataSuccessfullyFetched',
            'Concept'
        );
    }

    public function update(ConceptRequest $request, $id)
    {
        $this->conceptService->update($request->validated(), $id);

        return $this->successResponse(
            null,
            'UpdatedSuccessfully',
            'Concept'
        );
    }

    public function destroy($id)
    {
        $this->conceptService->destroy($id);

        return $this->successResponse(
            null,
            'DeletedSuccessfully',
            'Concept'
        );
    }
}
