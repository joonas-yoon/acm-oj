<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\User;
use Validator;
use Input;
use Redirect;
use Sentinel;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    protected $redirectTo = '/';
    
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        /***
         * 
         *  2015-12-07 23:57
         *  https://ide.c9.io/godakes/temp#AuthController.php 와 동반하여 확인
         */
        
        $field = array_has($data, 'email') ? 'email' : 'name';
        $fieldRule = 'required|min:3|max:255';
        if( $field == 'email' ) {
            $regExp = $this->getEmailRegexp();
        } else {
            $regExp = '/^[a-zA-Z0-9\-_\.]+$/';
        }
        $fieldRule = $fieldRule . '|regex:'.$regExp;
        
        $rules = [
            $field => $fieldRule,
            'password' => 'required|min:6',
        ];
        
        return Validator::make($data, $rules, [
            // messages
            'required'  => ':attribute 를 확인하세요.',
            'regex'     => '아이디 또는 이메일을 다시 확인하세요.',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return Sentinel::register([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
    
    
    /**
     * Show the form for logging the user in.
     *
     * @return \Illuminate\View\View
     */
    public function getLogin()
    {
        if( Sentinel::check() ) return redirect( $this->redirectTo );
        return view('auth.login');
    }
    
    /**
     * Handle posting of the form for logging the user in.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postLogin(Request $request)
    {
        try
        {
            $input = $this->getCredentials($request->all());
            
            $validator = $this->validator($input);

            if ($validator->fails())
            {
                return Redirect::back()
                    ->withInput()
                    ->withErrors($validator);
            }

            if (Sentinel::authenticate($input, $request->has('remember')))
            {
                return redirect( $this->redirectTo );
            }

            $errors = 'Invalid login or password.';
        }
        catch (NotActivatedException $e)
        {
            $errors = 'Account is not activated!';

            return Redirect::to('reactivate')->with('user', $e->getUser());
        }
        catch (ThrottlingException $e)
        {
            $delay = $e->getDelay();

            $errors = "Your account is blocked for {$delay} second(s).";
        }

        return Redirect::back()
            ->withInput()
            ->withErrors($errors);
    }
    
    private function getCredentials(array $data)
    {
        $fieldData = $data['username'];
        $fieldName = $this->getUsernameType($fieldData);
        array_set($data, $fieldName, $fieldData);
        array_forget($data, 'username');
        return $data;
    }
    
    private static function getEmailRegexp(){
        return "/^[a-zA-Z0-9._%+-]{1,64}@(?:[a-zA-Z0-9-]{1,63}\.){1,125}[a-zA-Z]{2,63}$/";
    }
    
    private function getUsernameType($username)
    {
        return filter_var($username, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
    }
    
    public function getRegister()
    {
        return view('auth.register');
    }
    
    public function postRegister(Request $request)
    {
        $input = Input::all();

        $rules = [
            'name'     => 'required|min:3|max:50|unique:users',
            'email'    => 'required|unique:users|regex:'.$this->getEmailRegexp(),
            'password' => 'required|min:4|confirmed'
        ];
        
        $messages = [
            'unique' => '사용할 수 없는 아이디 또는 이메일입니다',
            
            'name.required' => '아이디를 입력하세요.',
            'name.regex'    => '잘못된 아이디 형식입니다.',
            
            'email.required' => '이메일을 입력하세요.',
            'email.regex'    => '잘못된 이메일 형식입니다.',
            
            'password.required' => '비밀번호를 입력하세요.',
            'password.confirmed' => '비밀번호가 일치하지 않습니다.',
        ];

        $validator = Validator::make($input, $rules, $messages);

        if ($validator->fails())
        {
            return Redirect::back()
                ->withInput()
                ->withErrors($validator);
        }

        if ($user = Sentinel::register($input))
        {
            // $activation = Activation::create($user);

            // $code = $activation->code;

            // $sent = Mail::send('sentinel.emails.activate', compact('user', 'code'), function($m) use ($user)
            // {
            //     $m->to($user->email)->subject('Orion Online Judge 사이트 회원가입을 감사합니다.');
            // });

            // if ($sent === 0)
            // {
            //     return Redirect::to('register')
            //         ->withErrors('인증 메일 발송에 실패했습니다.');
            // }
            
            $request->session()->flash('success', '회원가입이 성공적으로 완료되었습니다.');

            return Redirect::to('login')
                ->with('userId', $user->getUserId());
        }

        return Redirect::to('register')
            ->withInput()
            ->withErrors('계정 생성에 실패하였습니다.');
    }
}
