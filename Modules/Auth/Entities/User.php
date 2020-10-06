<?php

namespace Modules\Auth\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\ThongTinChung\Entities\University;
use Spatie\Activitylog\Traits\LogsActivity;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use LogsActivity;
    use SoftDeletes;

    protected $table = 'users';

    protected static $logAttributes = [
        'university_id',
        'username',
        'password',
        'user_token',
        'fullname',
        'email',
        'created_by',
        'role_id'
    ];

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
            'exp' => time() + 7 * 24 * 3600
        ];
    }

    public function roles()
    {
        return $this->hasOne(Role::class, 'id')->first();
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'user_permissions', 'user_id');
    }

    public function university()
    {
        return $this->belongsTo(University::class, 'university_id', 'id');
    }

    public function role()
    {
        return $this->hasOne(Role::class, 'id');
    }
}
