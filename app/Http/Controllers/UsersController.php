<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Sentinel;
use Redirect;

class UsersController extends Controller
{
    /**
     * Instantiate a new UserController instance.
     */
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => [
                'show'
            ]
        ]);

        //$this->middleware('log', ['only' => ['fooAction', 'barAction']]);
    }
  
    public function show($username)
    {
        $user = User::findByNameOrFail($username);
        $userTriedProblemCount  = $user->getTriedProblems()->count();
        $userAcceptProblemCount = $user->getAcceptProblems()->count();
        $userTotalProblemCount = $userTriedProblemCount + $userAcceptProblemCount;
        $userTriedProblemRate = $userTotalProblemCount > 0 ? ($userTriedProblemCount / $userTotalProblemCount) * 100 : 0;
        
        
        $testImage = "http://people.imbc.com/images/thumbnail/A1105009727.jpg";
        if( $user->name == 'yukariko' )
          $testImage = "https://files.slack.com/files-pri/T0EJZPLJ2-F0G7GV2UW/pasted_image_at_2015_12_09_05_26_pm.png";
        elseif( rand()%2 == 1 )
          $testImage = "https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xfp1/v/t1.0-1/p40x40/11889666_933856966670876_899689170782757543_n.jpg?oh=e9c1b7ce8df50bacc32bda54c477893d&oe=56E92B1D&__gda__=1456929032_be7569ff3468ce54d95ed4e4b3d9f6a5";
        
        return view('users.show', compact('user', 'userTriedProblemRate', 'testImage'));
    }
    
    public function showSettings($template = null)
    {
        $userId = Sentinel::getUser()->id;
        $user = User::find($userId);
        
        if($template == 'password')
            $viewContext = 'users.settings.password';
        if($template == 'privacy')
            $viewContext = 'users.settings.privacy';
        if($template == 'language')
            $viewContext = 'users.settings.language';
        else
            $viewContext = 'users.settings.profile';
        
        return view('users.settings', compact('user', 'viewContext'));
    }
    public function postUpdateProfile(Request $request)
    {
        $inputs = $request->only([
            'via', 'first_name', 'last_name', 'organization', 'email_open', 'password'
        ]);
        
        $inputs['email_open'] = $inputs['email_open'] != null;
        
        $user = Sentinel::getUser();
        $credentials = array('password' => $inputs['password']);
        if( ! Sentinel::validateCredentials($user, $credentials) ) {
            return Redirect::back()->with('error', '비밀번호가 일치하지 않습니다.');
        }
        
        if( ! $user->updateProfile($inputs) ) {
            return Redirect::back()->with('error', '정보 수정을 실패했습니다.');
        }
        
        $request->session()->flash('success', '정보가 수정되었습니다.');
            
        return Redirect::back()->withInput();
    }
    
    public function showChangePassword()
    {
        return $this->showSettings('password');
    }
    public function postChangePassword(Request $request)
    {
        //
        return var_dump($request);
    }
    
    public function showResetPassword()
    {
        return view('auth.password');
    }
    public function postResetPassword(Request $request)
    {
        //
        return var_dump($request);
    }
    
    public function showPrivacy()
    {
        return $this->showSettings('privacy');
    }
    public function postPrivacy(Request $request)
    {
        //
        return var_dump($request);
    }
    
    public function showDefaultLanguage()
    {
        return $this->showSettings('language');
    }
    public function postDefaultLanguage(Request $request)
    {
        //
        return var_dump($request);
    }
}
