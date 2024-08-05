<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class logController extends Controller
{
    //
    public function log_super()
    {
        return view('admin.logs.logs');
    }

}
