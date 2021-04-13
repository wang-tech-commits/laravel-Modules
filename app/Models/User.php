<?php

namespace App\Models;

use Encore\Admin\Traits\DefaultDatetimeFormat;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Jason\Api\Traits\ApiGuardable;
use Modules\User\Entities\UserInfo;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, ApiGuardable, DefaultDatetimeFormat;

    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    ];

    public function info()
    {
        return $this->hasOne(UserInfo::class);
    }

    /**
     * 当用户有密码的时候才加密
     * @Author:<Mr.Wang>
     * @Date:2021-04-12
     * @param [type] $password [description]
     */
    public function setPasswordAttribute($password)
    {
        if ($password) {
            $this->attributes['password'] = bcrypt($password);
        }
    }
}
