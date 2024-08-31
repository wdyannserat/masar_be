<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AttachmentService;
use App\Http\Requests\AttachmentRequest;
use App\Http\Resources\AttachmentResource;
use App\Http\Controllers\Controller;

class AttachmentController extends BaseController
{

    public function __construct(private AttachmentService $attachmentService)
    {
    }

    public function index()
    {
        return $this->successResponse(
            $this->resource($this->attachmentService->getAll(), AttachmentResource::class),
            'DataSuccessfullyFetched',
            'Attachments'
        );
    }


    public function store(AttachmentRequest $request)
    {
        return $this->successResponse(
            $this->attachmentService->store($request->validated()),
            'AddedSuccessfully',
            'Attachment'
        );
    }

    public function show(Request $request)
    {
        return $this->successResponse(
            $this->resource($this->attachmentService->show($request->id), AttachmentResource::class),
            'DataSuccessfullyFetched',
            'Attachment'
        );
    }

    public function update(AttachmentRequest $request, $id)
    {
        $this->attachmentService->update($request->validated(), $id);

        return $this->successResponse(
            null,
            'UpdatedSuccessfully',
            'Attachment'
        );
    }

    public function destroy($id)
    {
        $this->attachmentService->destroy($id);

        return $this->successResponse(
            null,
            'DeletedSuccessfully',
            'Attachment'
        );
    }
}
