<?php

namespace App\Services;

use App\Models\Attachment;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AttachmentService extends BaseService
{
    public function __construct(
        private FileService $fileService
    ) {
    }

    public function getAll()
    {
        return  Attachment::all();
    }


    public function store($data, $fileType)
    {
        $attachment = Attachment::create([
            'type' => $fileType
        ]);

        foreach ($data['files'] as $key => $file) {
            //'Missions', 'Challenges', 'Child_Info', 'User_Info', 'Trophies','Child_Document_Challenge'
            $filePath = '';

            if ($fileType == 'Child_Info') {
                $filePath = $this->uploadFile($file['file'], 'child_files/');
            } else if ($fileType == 'User_Info') {
                $filePath = $this->uploadFile($file['file'], 'user_files/');
            } else if ($fileType == 'Missions') {
                $filePath = $this->uploadFile($file['file'], 'missions_files/');
            } else if ($fileType == 'Challenges') {
                $filePath = $this->uploadFile($file['file'], 'challenges_files/');
            } else if($fileType == 'Child_Document_Challenge'){
                $filePath = $this->uploadFile($file['file'], 'children_document_challenges/');
            }

            array_push(request()->myFiles, $filePath);

            $this->fileService->store([
                'file_path'     => $filePath,
                'description'   =>  isset($file['description']) ? $file['description'] : null,
                'order'         => $key + 1,
                'attachment_id' => $attachment->id
            ]);
        }

        return $attachment;
    }

    public function show($id)
    {
        $attachment = $this->find($id);

        return $attachment;
    }


    public function update($validatedData, $id)
    {
        DB::beginTransaction();


        $attachment = $this->find($id);

        $attachment->update($validatedData);

        DB::commit();
        return $attachment;
    }


    public function destroy($id)
    {
        $attachment = $this->find($id);

        DB::beginTransaction();
        $files = $attachment->files;

        foreach ($files as $file) {
            $this->deleteFile($file->file_path);
        }

        $attachment->delete();
        DB::commit();

        return true;
    }

    public function find($id)
    {
        return $this->findByIdOrFail(Attachment::class, 'Attachment', $id);
    }
}
