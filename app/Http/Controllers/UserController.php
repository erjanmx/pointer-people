<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Resources\UsersResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Show the list of users.
     *
     * @return AnonymousResourceCollection
     */
    public function list()
    {
        return UsersResource::collection(
            User::query()->verified()->orderBy('name')->get()
        );
    }
}
