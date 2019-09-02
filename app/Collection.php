<?php

namespace App;

class Collection
{
    /**
     * @return array
     */
    public function getCountries()
    {
        return collect(json_decode(
            file_get_contents(
                resource_path('data/countries.json')
            )
        ))->sort()->toArray();
    }

    /**
     * @return array
     */
    public function getJobTitles()
    {
        $jobTitlesCollection = User::query()->pluck('job_title')->unique();

        return $jobTitlesCollection->flatMap(function ($name) {
            return [$name => $name];
        })->sort()->toArray();
    }

    /**
     * @return array
     */
    public function getSkills()
    {
        $skillsCollection = User::query()->pluck('skills')->flatten()->unique()->filter();

        // flatMap doesn't work here properly
        $skills = [];
        foreach ($skillsCollection as $skill) {
            $skills[strval($skill)] = $skill;
        }

        return $skills;
    }

    /**
     * @return array
     */
    public function getTeamNames()
    {
        $teamNamesCollection = collect([
            'Sales',
            'Finance',
            'Marketing',
            'Development',
            'Internal IT',
            'Investigations',
            'Human Resources',
            'Brand Protection',
            'Office Management',
        ]);

        return $teamNamesCollection->flatMap(function ($name) {
            return [$name => $name];
        })->sort()->toArray();
    }

    public function getAll()
    {
        $skills = $this->getSkills();
        $countries = $this->getCountries();
        $teamNames = $this->getTeamNames();
        $jobTitles = $this->getJobTitles();

        return compact('skills', 'countries', 'jobTitles', 'teamNames');
    }
}
