<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $redirectTo = '/';

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
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('linkedin')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $remoteUser = Socialite::driver('linkedin')->stateless()->user();

        /** @var User $user */
        $user = User::query()->updateOrCreate([
            'linkedin_id' => $remoteUser->getId(),
        ], [
            'name' => $remoteUser->getName(),
            'email' => $remoteUser->getEmail(),
            'linkedin_id' => $remoteUser->getId(),
            'linkedin_token' => $remoteUser->token,
            'avatar' => data_get($remoteUser, 'avatar_original', $remoteUser->getAvatar()),
        ]);

        Auth::login($user, true);

        return redirect()->route('home');
    }
}
