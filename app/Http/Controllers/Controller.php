<?php

namespace App\Http\Controllers;

use App\Http\Components\Traits\Upload;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected $index;
    use AuthorizesRequests, ValidatesRequests;
    use Upload;
}
