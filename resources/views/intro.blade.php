@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h3>{{ __('Welcome to Pointer Brand Protection People') }}</h3>
            Pointer People is here to help you get a better overview of who your colleagues are.
            <hr/>
            <img src="{{ asset('images/sample-page.png') }}" title="Sample UI" class="img-fluid" alt="sample ui">
            <hr/>
            To connect, simply <a href="{{ route('register') }}">register</a> or <a href="{{ route('login-linkedin') }}">log in</a> using your LinkedIn credentials and the app will automatically create your account based on your LI profile, which you can choose to complete with additional information about yourself.
        </div>
    </div>
</div>
@endsection
