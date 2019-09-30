<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Resources\UsersResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{
    /**
     * Show the list of users.
     *
     * @return AnonymousResourceCollection
     */
    public function list()
    {
        return UsersResource::collection(
            User::query()->orderBy('name')->get()
        );
    }
}
