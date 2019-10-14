<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Resources\UsersResource;
use Intervention\Image\Facades\Image;
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

    public function picture($id)
    {
        $user = User::query()->findOrFail($id);

        if (!$user->avatar_blob) {
            abort(404);
        }

        return Image::make($user->avatar_blob)->response();
    }
}
