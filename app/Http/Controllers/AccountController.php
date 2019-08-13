<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     *
     */
    public function showForm()
    {
        $collections = $this->getCollections();

        $collections['user'] = $this->getCurrentUser();;

        return view('account.profile', $collections);
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
        ]);

        $user = $this->getCurrentUser();

        $parameters = $request->only([
            'email', 'job_title', 'team_name', 'bio', 'country',
        ]);

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

    /**
     * Get list of collections
     *
     * ToDo retrieve it from db or other source
     *
     * @return array
     */
    protected function getCollections()
    {
        $countries = collect(json_decode(
            file_get_contents(
                resource_path('data/countries.json')
            )
        ));

        $jobTitles = User::query()->pluck('job_title')->unique()->toArray();

        $teamNames = collect([
            'Sales',
            'Finance',
            'Marketing',
            'Development',
            'Investigations',
            'Human Resources',
            'Brand Protection',
        ]);

        $teamNames = $teamNames->flatMap(function ($name) {
            return [$name => $name];
        })->sort();

        return [
            'countries' => $countries->toArray(),
            'jobTitles' => $jobTitles,
            'teamNames' => $teamNames->toArray(),
        ];
    }
}
