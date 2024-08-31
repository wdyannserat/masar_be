<?php

namespace App\Services;

use App\Traits\FileUploader;
use App\Traits\ModelHelper;
use App\Traits\ResourceHelper;
use App\Traits\StringHelper;

class BaseService
{
    use ModelHelper, FileUploader, ResourceHelper , StringHelper;
}