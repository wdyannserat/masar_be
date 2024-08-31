<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

trait FileUploader
{
    public static function uploadFile($file, $repository): string
    {
        $fileName = self::fileName($file);

        $realPath = $repository . $fileName;

        Storage::disk('public')->put($realPath, file_get_contents($file));

        $filePath   = 'storage/' . $realPath;

        return $filePath;
    }

    protected static function fileName($file): string
    {
        return  Carbon::now()->format('Y_m_d_u') . '_' . $file->getClientOriginalName();
    }

    protected static function deleteFile($fileName): bool
    {
        if (file_exists(public_path($fileName))) {
            unlink(public_path($fileName));
            return true;
        }
        return false;
    }
}
