<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    public $table = 'user';

    public $primaryKey = 'user_id';

    /**
     * 允许被批量操作的字段
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','nick','lastlogin',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * 禁止自动维护时间戳
     * @var bool
     */
     public $timestamps = false;
}
