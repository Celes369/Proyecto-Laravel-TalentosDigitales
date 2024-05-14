<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\Models\User;


class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function sendResetLinkEmail(Request $request){
        $login = $request->input($this->username());

        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        switch ($field) {
            case 'username':
                $user = User::where('username', $login)->first();
                break;

                case 'email':
                    $user = User::where('email', $login)->first();
                    break;
        }

        if(is_null($user)) return ['status'=>400];
        dd('user ok');
    }

    public function username(){
        return 'login';
    }

}
