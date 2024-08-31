<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FileService;
use App\Http\Requests\FileRequest;
use App\Http\Resources\FileResource;
use App\Http\Controllers\Controller;

class FileController extends BaseController
{

    public function __construct(private FileService $fileService)
    {
    }

    public function index()
    {
        return $this->successResponse(
            $this->resource($this->fileService->getAll(), FileResource::class),
            'DataSuccessfullyFetched',
            'Files'
        );
    }


    public function store(FileRequest $request)
    {
        return $this->successResponse(
            $this->fileService->store($request->validated()),
            'AddedSuccessfully',
            'File'
        );
    }

    public function show(Request $request)
    {
        return $this->successResponse(
            $this->resource($this->fileService->show($request->id), FileResource::class),
            'DataSuccessfullyFetched',
            'File'
        );
    }

    public function update(FileRequest $request, $id)
    {
        $this->fileService->update($request->validated(), $id);

        return $this->successResponse(
            null,
            'UpdatedSuccessfully',
            'File'
        );
    }

    public function destroy($id)
    {
        $this->fileService->destroy($id);

        return $this->successResponse(
            null,
            'DeletedSuccessfully',
            'File'
        );
    }
}
