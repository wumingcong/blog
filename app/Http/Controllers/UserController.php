<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function index(){
        $list = User::get();
        dd($list[0]['name']);
    }
}