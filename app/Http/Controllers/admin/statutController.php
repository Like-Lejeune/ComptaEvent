<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Tools;

class statutController extends Controller
{
    //
    private $tools;

    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
    }


}
