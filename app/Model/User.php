<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //数据库名
    public $table = 'user';

    //主键名
    public $primaryKey = 'user_id';

    //不允许修改的字段（为空则说明都允许修改）
    public $guarded = [];

    //不自动维护时间
    public $timestamps = false;
}
