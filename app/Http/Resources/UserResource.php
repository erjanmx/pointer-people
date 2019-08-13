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
class UserResource extends JsonResource
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
            'avatar' => $this->avatar,
            'bio' => $authorized ? $this->bio : null,
            'email' => $authorized ? $this->email : null,
            'team' => $authorized ? $this->team_name : null,
            'position' => $authorized ? $this->job_title : null,
            'countryCode' => $authorized ? $this->country : null,
        ];
    }
}
