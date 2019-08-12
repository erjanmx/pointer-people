<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     */
    public function showForm()
    {
        return view('account.profile', [
            'user' => User::query()->findOrFail(Auth::user()->id)
        ]);
    }
}
