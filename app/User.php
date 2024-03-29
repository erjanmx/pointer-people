<?php

namespace App;

use App\Events\UserDeleted;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, SoftDeletes;

    const EMAIL_REGEXP = '/^.+@pointerbp.(com|nl)$/';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'linkedin_id', 'linkedin_token', 'avatar',
        'job_title', 'team_name', 'country', 'bio', 'skills', 'password',
        'avatar_blob',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'linkedin_id', 'linkedin_token', 'remember_token', 'deleted_at', 'email_verified_at', 'password',
        'avatar_blob',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'skills' => 'array',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'deleted' => UserDeleted::class,
    ];

    /**
     * Scope a query to only verified users.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeVerified($query)
    {
        return $query->whereNotNull('email_verified_at');
    }

    /**
     * @return bool
     */
    public function hasEmail() : bool
    {
        return $this->email != null;
    }
}
