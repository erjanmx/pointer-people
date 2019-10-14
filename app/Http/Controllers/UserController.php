<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Resources\UsersResource;
use Illuminate\Support\Facades\Response;
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
        $image = $user->avatar_blob ?? $user->avatar;

        if (!$image) {
            abort(404);
        }

        return Response::make($image, 200, ['Content-Type' => 'image'])
            ->setMaxAge(60 * 60 * 24 * 7) // one week
            ->setPublic();
    }
}
