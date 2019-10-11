<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class UserResource
 * @package App\Http\Resources
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $avatar
 */
class UsersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $authorized = Auth::check();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'bio' => $this->bio,
            'email' => $authorized ? $this->email : null,
            'team' => $this->team_name,
            'skills' => $this->skills,
            'avatar' => $this->getAvatar(),
            'position' => $this->job_title,
            'countryCode' => $this->country,
        ];
    }
}
