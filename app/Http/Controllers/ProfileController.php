<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class ProfileController extends Controller
{
    /** @var \App\Collection */
    protected $collections;

    /**
     * ProfileController constructor.
     * @param \App\Collection $collections
     */
    public function __construct(\App\Collection $collections)
    {
        $this->middleware('auth');

        $this->collections = $collections;
    }

    /**
     * Show profile form
     */
    public function showForm()
    {
        return view('profile.form', array_merge(
            $this->collections->getAll(),
            [ 'user' => $this->getCurrentUser() ]
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function update(Request $request)
    {
        $user = $this->getCurrentUser();

        $previousEmail = $user->email;

        $user->update($this->getValidatedParameters($request));

        if ($previousEmail == $user->email) {
            return redirect()->route('account')->with('status', 'Updated successfully');
        }

        // handle email change
        $this->sendUserEmailVerificationNotification($user);

        return redirect()->route('account')->with(
            'status',
            'Updated successfully. Please check your email for a verification link.'
        );
    }

    private function sendUserEmailVerificationNotification(User $user)
    {
        // reset
        $user->email_verified_at = null;
        $user->save();

        $user->sendEmailVerificationNotification();
    }

    /**
     * Get current logged in user
     *
     * @return Builder|User
     */
    protected function getCurrentUser()
    {
        return User::query()->findOrFail(Auth::user()->id);
    }

    /**
     * @param Request $request
     * @return array
     */
    protected function getValidatedParameters(Request $request)
    {
        $request->validate([
            'bio' => 'max:120',
            'email' => ['max:40', 'regex:/^.+@pointerbp.(com|nl)$/'],
            'country' => 'max:2',
            'job_title' => 'max:30',
            'team_name' => 'max:30',
            'skills' => 'array|max:5',
        ]);

        $parameters = $request->only([
            'email', 'job_title', 'team_name', 'bio', 'country', 'skills',
        ]);

        // set default values if empty
        // otherwise they will not be updated in eloquent model
        Arr::set($parameters, 'skills', Arr::get($parameters, 'skills', []));
        Arr::set($parameters, 'job_title', Arr::get($parameters, 'job_title'));

        return $parameters;
    }
}
