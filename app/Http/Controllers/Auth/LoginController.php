<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    


    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => [
                'required', 'string',
                Rule::exists('users')->where(function ($query) {
                    $query->whereNotNull('email_verified_at');
                })
            ],
            'password' => 'required|string',
        ],
        $this->validationError());
    }

    /**
     * Get the validation error for login
     * 
     * @return array
     */
    public function validationError() {
       
        return [
            $this->username().'.exists' => 'The selected email is invalid or you need to activate your account. ',
        ];
    }


    protected function authenticated(Request $request, $user)
    {
        if($user->hasRole('admin')) {
            return redirect()->route('admin-dashboard');
        }
        else if($user->hasAnyRole(['writer', 'reader'])){
            return redirect()->route('user-dashboard');
        }
        
    }
}

