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
        $userTriedProblemCount  = $user->getTriedProblems()->count();
        $userAcceptProblemCount = $user->getAcceptProblems()->count();
        $userTotalProblemCount = $userTriedProblemCount + $userAcceptProblemCount;
        $userTriedProblemRate = $userTotalProblemCount > 0 ? ($userTriedProblemCount / $userTotalProblemCount) * 100 : 0;
        return view('users.show', compact('user', 'userTriedProblemRate'));
    }
}
