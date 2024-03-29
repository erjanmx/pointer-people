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

                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right required">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                {{ Form::text('name', $user->name, ['class' => 'form-control']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right required">{{ __('Pointer E-Mail Address') }}</label>

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
                                {{ Form::select('job_title', $jobTitles, $user->job_title ?? old('job_title'), ['class' => 'form-control', 'id' => 'user-job-title']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="country" class="col-md-4 col-form-label text-md-right">{{ __('Country of origin') }}</label>
                            <div class="col-md-6">
                                {{ Form::select('country', $countries, $user->country ?? old('country'), ['placeholder' => 'Select country', 'class' => 'form-control', 'id' => 'user-country']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="bio" class="col-md-4 col-form-label text-md-right">{{ __('Bio') }}</label>

                            <div class="col-md-6">
                                {{ Form::textarea('bio', $user->bio, ['class' => 'form-control', 'rows' => '2', 'maxlength' => '120', 'placeholder' => 'Tell us something about yourself']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="skills" class="col-md-4 col-form-label text-md-right">{{ __('Skills') }}</label>

                            <div class="col-md-6">
                                {{ Form::select('skills[]', $skills, $user->skills ?? old('skills'), ['class' => 'form-control', 'id' => 'user-skills', 'multiple' => 'multiple']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="avatar" class="col-md-4 col-form-label text-md-right">{{ __('Avatar (Max 5MB)') }}</label>

                            <div class="col-md-4">
                                <input type="file" class="form-control" name="avatar" id="avatar" style="height: 100%">
                            </div>

                            <div class="col-md-2">
                                <div class="profile-header-img">
                                    <img class="img-thumbnail" src="{{ $user->avatar_blob ? route('picture', [$user->id, uniqid()]) : $user->avatar }}" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-4 offset-md-4">
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
@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $("#user-skills").select2({
                placeholder: 'List your skills you want to share knowledge',
                maximumSelectionLength: 5,
                minimumInputLength: 1,
                tags: true,
            });

            $("#user-job-title").select2({
                placeholder: 'Job title',
                allowClear: true,
                minimumInputLength: 1,
                tags: true,
            });

            $("#user-country").select2({
                placeholder: 'Select country',
                allowClear: true,
            });
        });
    </script>
@endpush
