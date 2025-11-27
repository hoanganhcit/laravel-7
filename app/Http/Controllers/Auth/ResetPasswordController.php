<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function showResetForm(Request $request, $token = null)
    {
        $canonical = $request->url();
        $settings = Setting::first();
        $title = $settings->title;
        $description = $settings->description;
        $keywords = $settings->keywords;

        return view('auth.passwords.reset', compact(
            'canonical',
            'title',
            'description',
            'keywords'
        ))->with(
            [
                'token' => $token,
                'email' => $request->email,
            ]
        );
    }
}
