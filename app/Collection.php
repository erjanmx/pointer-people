<?php

namespace App;

class Collection
{
    public function getAll()
    {
        $countries = collect(json_decode(
            file_get_contents(
                resource_path('data/countries.json')
            )
        ))->sort()->toArray();

        $jobTitlesCollection = User::query()->pluck('job_title')->unique();
        $skillsCollection = User::query()->pluck('skills')->flatten()->unique()->filter();

        $teamNamesCollection = collect([
            'Sales',
            'Finance',
            'Marketing',
            'Development',
            'Investigations',
            'Human Resources',
            'Brand Protection',
        ]);

        $teamNames = $teamNamesCollection->flatMap(function ($name) {
            return [$name => $name];
        })->sort()->toArray();

        $jobTitles = $jobTitlesCollection->flatMap(function ($name) {
            return [$name => $name];
        })->sort()->toArray();

        // flatMap doesn't work here properly
        $skills = [];
        foreach ($skillsCollection as $skill) {
            $skills[strval($skill)] = $skill;
        }

        return compact('skills', 'countries', 'jobTitles', 'teamNames');
    }
}
