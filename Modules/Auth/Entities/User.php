<?php

namespace Modules\Auth\Entities;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    protected $table = 'users';

    protected $fillable = [
        'university_id',
        'username',
        'password',
        'user_token',
        'fullname',
        'email',
        'created_by',
        'role_id'
    ];

    protected $hidden = [
        'password',
        'university_id',
        'user_token',
        'created_at',
        'updated_at'
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [

        ];
    }

    public function roles()
    {
        return $this->hasOne(Role::class,'id');
    }
}