<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Session;
use App\Models\User; 


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    } 


    public function login(Request $request){
        $userLocal = null;
        $credentials = $this->credentials($request);
        if(Auth::validate($credentials)){
            $user = Auth::getLastAttempted();
            auth()->login($user);
            return redirect('home');
        }else{
            /*
            if (!empty($credentials['username'])) {
                $userLocal = User::where('username', $credentials['username'])->first();
            }else if (!empty($credentials['email'])) {
                $userLocal = User::where('email', $credentials['email'])->first();
            }*/
            $typeFiel =  filter_var($request->input($this->username()), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
            $userLocal = User::where($typeFiel, $credentials[$typeFiel])->first();
            
            if (is_null($userLocal)){
                Session::flash('flash_message', 'The user is wrong');
                Session::flash('flash_message_class', 'danger');
            }else{
                Session::flash('flash_message', 'The password is wrong');
                Session::flash('flash_message_class', 'danger');
            }
           
            return back()->withInput();
        }
    }
    
    public function credentials(Request $request){
        $login = $request->input($this->username());

        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        return [
            $field      => $login,
            'password'  => $request->input('password'),
        ];

    }

    public function username(){
        return 'login';
    }

    
}
