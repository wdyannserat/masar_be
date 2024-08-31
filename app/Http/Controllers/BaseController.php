<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use App\Traits\ResourceHelper;

class BaseController extends Controller
{
    use ApiResponser , ResourceHelper;
}