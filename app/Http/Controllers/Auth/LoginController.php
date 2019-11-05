<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
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
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
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
        $linkedInUser = $this->getSocialiteUserAsArray();

        /** @var User $user */
        $user = User::query()->where('linkedin_id', $linkedInUser['id'])->first();

        if (is_null($user)) {
            $user = User::query()->create([
                'name' => $linkedInUser['name'],
                'linkedin_id' => $linkedInUser['id'],
                'linkedin_token' => $linkedInUser['token'],
            ]);

            event(new Registered($user));
        }

        $user->update([
            'avatar' => $linkedInUser['avatar'],
            'linkedin_token' => $linkedInUser['token'],
        ]);

        return $user;
    }

    /**
     * @return array
     */
    public function getSocialiteUserAsArray()
    {
        /** @var \Laravel\Socialite\One\User $remoteUser */
        $remoteUser = Socialite::driver('linkedin')->stateless()->user();

        return [
            'id' => $remoteUser->getId(),
            'name' => $remoteUser->getName(),
            'token' => $remoteUser->token,
            'avatar' => data_get($remoteUser, 'avatar_original', $remoteUser->getAvatar())
        ];
    }

    /**
     * @return RedirectResponse
     * @throws Exception
     */
    public function deleteAndLogout()
    {
        $user = User::query()->find(Auth::user()->id);

        Auth::logout();

        $user->forceDelete();

        return redirect()->route('intro')->with('status', __('Your account has been removed'));
    }
}
