@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('User profile') }}</div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Pointer E-Mail Address') }}</label>

                            <div class="col-md-6">
                                {{ Form::text('email', $user->email, ['class' => 'form-control']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="team_name" class="col-md-4 col-form-label text-md-right">{{ __('Team') }}</label>

                            <div class="col-md-6">
                                {{ Form::select('team_name', $teamNames, $user->team_name ?? old('team_name'), ['placeholder' => 'Select your team', 'class' => 'form-control']) }}
                           </div>
                        </div>

                        <div class="form-group row">
                            <label for="job_title" class="col-md-4 col-form-label text-md-right">{{ __('Job title') }}</label>

                            <div class="col-md-6">
                                <input type="text" class="awesomplete form-control" name="job_title" value="{{ $user->job_title ?? old('job_title') }}"
                                       data-list="{{ join(',', $jobTitles) }}" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="country" class="col-md-4 col-form-label text-md-right">{{ __('Country of origin') }}</label>
                            <div class="col-md-6">
                                {{ Form::select('country', $countries, $user->country ?? old('country'), ['placeholder' => 'Select country', 'class' => 'form-control']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="bio" class="col-md-4 col-form-label text-md-right">{{ __('Bio') }}</label>

                            <div class="col-md-6">
                                {{ Form::textarea('bio', $user->bio, ['class' => 'form-control', 'rows' => '2', 'maxlength' => '120', 'placeholder' => 'Tell us something about yourself']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-4 col-sm-4 col-xs-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <button class="btn btn-danger" href="{{ route('delete-logout') }}"
                                    onclick="if (confirm('Are you sure you want to remove your account?'))
                                                 document.getElementById('delete-logout-form').submit(); ">
                                {{ __('Delete my account') }}
                            </button>
                        </div>
                    </div>

                    <form id="delete-logout-form" action="{{ route('delete-logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
