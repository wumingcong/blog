<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redis;
use Session;
use Cache;

class UserController extends Controller
{
    //
    public function index(){
        return view('aaa');
    }
}
