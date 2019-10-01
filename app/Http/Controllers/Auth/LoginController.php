<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\Eloquent\Model;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Database\Eloquent\Builder;
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
        try {
            $user = $this->getUserWithLinkedIn();

            Auth::login($user, true);

            $status = __('Logged in successfully');

            if ($user->wasRecentlyCreated) {
                Log::info('New user', $user->toArray());

                return redirect()->route('profile')->with('status', __('Please provide your PointerBP email and some more information about yourself'));
            }
        } catch (ClientException $exception) {
            $status = __('Login canceled');
        } catch (Exception $exception) {
            Log::error($exception->getMessage());

            $status = __('Unable to do the sign in');
        }

        return redirect()->route('home')->with('status', $status);
    }

    /**
     * @return User|Builder|Model|\Illuminate\Database\Query\Builder
     */
    public function getUserWithLinkedIn()
    {
        $remoteUser = Socialite::driver('linkedin')->stateless()->user();

        /** @var User $user */
        return User::withTrashed()->updateOrCreate([
            'linkedin_id' => $remoteUser->getId(),
        ], [
            'name' => $remoteUser->getName(),
            'linkedin_token' => $remoteUser->token,
            'avatar' => data_get($remoteUser, 'avatar_original', $remoteUser->getAvatar()),
        ]);
    }
    /**
     * @return RedirectResponse
     * @throws Exception
     */
    public function deleteAndLogout()
    {
        $user = User::query()->find(Auth::user()->id);

        Auth::logout();

        Log::info('User removed', $user->toArray());

        $user->forceDelete();

        return redirect()->route('intro')->with('status', 'Your account has been removed');
    }
}
