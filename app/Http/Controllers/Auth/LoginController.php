<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;
use GuzzleHttp\Exception\ClientException;
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
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('linkedin')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        $status = 'Logged in successfully';

        try {
            $remoteUser = Socialite::driver('linkedin')->stateless()->user();

            /** @var User $user */
            $user = User::withTrashed()->updateOrCreate([
                'linkedin_id' => $remoteUser->getId(),
            ], [
                'name' => $remoteUser->getName(),
                'email' => $remoteUser->getEmail(),
                'linkedin_id' => $remoteUser->getId(),
                'linkedin_token' => $remoteUser->token,
                'avatar' => data_get($remoteUser, 'avatar_original', $remoteUser->getAvatar()),
            ]);

            $user->restore();

            Auth::login($user, true);

            if ($user->wasRecentlyCreated) {
                $status = 'Your user has been added to this list';

                Log::info('New user', $user->toArray());
            }
        } catch (ClientException $exception) {
            $status = 'Login canceled';
        } catch (Exception $exception) {
            $status = 'Unable to do the sign in';
        }

        return redirect()->route('home')->with('status', $status);
    }

    /**
     * @return RedirectResponse
     * @throws Exception
     */
    public function deleteAndLogout()
    {
        $user = User::query()->find(Auth::user()->id);

        Auth::logout();

        $user->delete();

        return redirect()->route('home')->with('status', 'Your account has been removed');
    }
}
