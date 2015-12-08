<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Sentinel;

class UsersController extends Controller
{
    public function show($name){
        $user = User::findByNameOrFail($name);
        return view('users.show', compact('user'));
    }
}
