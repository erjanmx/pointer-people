<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return AnonymousResourceCollection
     */
    public function list()
    {
        return UserResource::collection(User::all());
    }
}
