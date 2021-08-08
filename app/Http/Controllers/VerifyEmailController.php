<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;

class VerifyEmailController extends Controller
{
    public function __verifyEmail(Request $request): RedirectResponse
    {
        $user = User::find($request->route('id')); //takes user ID from verification link. Even if somebody would hijack the URL, signature will be fail the request
        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(config('auth.home') . '?verified=1');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }
        
        $message = __('Your email has been verified.');

        return redirect('login')->withStatus($message); //if user is already logged in it will redirect to the dashboard page
    }
}
