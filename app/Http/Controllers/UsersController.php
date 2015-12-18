<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use UserService;
use StatisticsService;
use ProblemService;

use App\Models\Language;
use Sentinel;
use Redirect;

class UsersController extends Controller
{

    /**
     * Instantiate a new UserController instance.
     */
    public function __construct
    (
    )
    {

        $user = Sentinel::getUser();
        UserService::setUser($user);
        StatisticsService::setUser($user);
        ProblemService::setUser($user);
        
        $this->middleware('auth', [
            'except' => [
                'show'
            ]
        ]);

        //$this->middleware('log', ['only' => ['fooAction', 'barAction']]);
    }
  
    public function show($username)
    {
        $user = UserService::getUserByNameOrEmail($username);
        
        $acceptProblem = ProblemService::getAcceptProblemsByUser($user->id);
        $triedProblem = ProblemService::getTriedProblemsByUser($user->id);
        $userTriedProblemCount  = $acceptProblem->count();
        $userAcceptProblemCount = $triedProblem->count();
        $userTotalProblemCount = $userTriedProblemCount + $userAcceptProblemCount;
        $userTriedProblemRate = $userTotalProblemCount > 0 ? ($userTriedProblemCount / $userTotalProblemCount) * 100 : 0;
        
        $results = StatisticsService::getAllResultCountByUser($user->id);

        return view('users.show', compact('user', 'userTriedProblemRate', 'acceptProblem', 'triedProblem', 'results'));
    }
    
    public function showSettings($template = null, $compacts = [])
    {
        $user = UserService::getUser();
        
        $viewContext = 'users.settings.' . ($template ? $template : 'profile');
            
        $title = '설정';
        
        return view('users.settings', compact('user', 'viewContext', 'title') + $compacts);
    }
    
    public function postUpdateProfile(Request $request)
    {
        $inputs = $request->only([
            'via', 'first_name', 'last_name', 'organization', 'email_open', 'password'
        ]);
        
        $inputs['email_open'] = $inputs['email_open'] != null;
        
        $user = UserService::getUser();
        $credentials = array('password' => $inputs['password']);
        if( ! Sentinel::validateCredentials($user, $credentials) ) {
            return Redirect::back()->with('error', '비밀번호가 일치하지 않습니다.');
        }
        
        if( ! UserService::updateProfile($inputs) ) {
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
    
    public function showSessions()
    {
        $user = Sentinel::getUser();

        $persistence = Sentinel::getPersistenceRepository();
        
        return $this->showSettings('sessions', compact('user', 'persistence'));
    }
    public function postSessions(Request $request)
    {
        //
        return var_dump($request);
    }
    
    public function showDefaultLanguage()
    {
        $user = UserService::getUser();
        $defaults = [
            'language'   => $user->default_language,
            'code_theme' => $user->default_code_theme,
        ];
        
        $langs  = Language::all();
        $themes = [
          ['value' => 'chrome', 'name' => 'Chrome'], 
          ['value' => 'clouds', 'name' => 'Clouds'], 
          ['value' => 'crimson_editor', 'name' => 'Crimson Editor'], 
          ['value' => 'dawn', 'name' => 'Dawn'], 
          ['value' => 'dreamweaver', 'name' => 'Dreamweaver'], 
          ['value' => 'eclipse', 'name' => 'Eclipse'], 
          ['value' => 'github', 'name' => 'GitHub'], 
          ['value' => 'iplastic', 'name' => 'IPlastic'], 
          ['value' => 'solarized_light', 'name' => 'Solarized Light'], 
          ['value' => 'textmate', 'name' => 'TextMate'], 
          ['value' => 'tomorrow', 'name' => 'Tomorrow'], 
          ['value' => 'xcode', 'name' => 'XCode'], 
          ['value' => 'kuroir', 'name' => 'Kuroir'], 
          ['value' => 'katzenmilch', 'name' => 'KatzenMilch'], 
          ['value' => 'sqlserver', 'name' => 'SQL Server'], 
          ['value' => 'ambiance', 'name' => 'Ambiance'], 
          ['value' => 'chaos', 'name' => 'Chaos'], 
          ['value' => 'clouds_midnight', 'name' => 'Clouds Midnight'], 
          ['value' => 'cobalt', 'name' => 'Cobalt'], 
          ['value' => 'idle_fingers', 'name' => 'idle Fingers'], 
          ['value' => 'kr_theme', 'name' => 'krTheme'], 
          ['value' => 'merbivore', 'name' => 'Merbivore'], 
          ['value' => 'merbivore_soft', 'name' => 'Merbivore Soft'], 
          ['value' => 'mono_industrial', 'name' => 'Mono Industrial'], 
          ['value' => 'monokai', 'name' => 'Monokai'], 
          ['value' => 'pastel_on_dark', 'name' => 'Pastel on dark'], 
          ['value' => 'solarized_dark', 'name' => 'Solarized Dark'], 
          ['value' => 'terminal', 'name' => 'Terminal'], 
          ['value' => 'tomorrow_night', 'name' => 'Tomorrow Night'], 
          ['value' => 'tomorrow_night_blue', 'name' => 'Tomorrow Night Blue'], 
          ['value' => 'tomorrow_night_bright', 'name' => 'Tomorrow Night Bright'], 
          ['value' => 'tomorrow_night_eighties', 'name' => 'Tomorrow Night 80s'], 
          ['value' => 'twilight', 'name' => 'Twilight'], 
          ['value' => 'vibrant_ink', 'name' => 'Vibrant Ink'], 
        ];
        
        return $this->showSettings('language', compact('defaults', 'langs', 'themes'));
    }
    public function postDefaultLanguage(Request $request)
    {
        $inputs = $request->only(['default_language', 'default_code_theme']);
        
        if( ! UserService::updateProfile($inputs) ) {
            return Redirect::back()->with('error', '변경에 실패했습니다.');
        }
        
        $request->session()->flash('success', '변경 사항이 적용되었습니다.');
        return Redirect::back();
    }
    
    public function uploadPhoto(Request $request)
    {
        $user = Sentinel::getUser();
        $file = $request->only(['user_photo']);
        
        if( ! array_has($file, 'user_photo') )
            return Redirect::back();
        
        $filePath = upload_photo_on_storage($file['user_photo'], $user->name);
        
        if( $filePath && UserService::updateProfile(['photo_path' => $filePath]) ) {
            return Redirect::back();
        }
            
        return abort(404);
    }
}
