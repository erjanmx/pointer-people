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
        $request->validate([
            'bio' => 'max:120',
            'email' => ['max:40', 'regex:/^.+@pointerbp.(com|nl)$/'],
            'country' => 'max:2',
            'job_title' => 'max:30',
            'team_name' => 'max:30',
            'skills' => 'array|max:5',
        ]);

        $user = $this->getCurrentUser();

        $parameters = $request->only([
            'email', 'job_title', 'team_name', 'bio', 'country', 'skills',
        ]);

        Arr::set($parameters, 'skills', Arr::get($parameters, 'skills', []));
        Arr::set($parameters, 'job_title', Arr::get($parameters, 'job_title'));

        $user->update($parameters);

        return redirect()->route('account')
            ->with('status', 'Updated successfully');
    }

    /**
     * Get current logged in user
     *
     * @return Builder|Builder[]|Collection|Model
     */
    protected function getCurrentUser()
    {
        return User::query()->findOrFail(Auth::user()->id);
    }
}
