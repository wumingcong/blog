<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    //
    //数据库名
    protected $table = 'goods';

    //主键名
    protected $primaryKey = 'goods_id';

    //不允许修改的字段（为空则说明都允许修改）
    public $guarded = [];
}
