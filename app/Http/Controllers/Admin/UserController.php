<?php

namespace App\Http\Controllers\Admin;

use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * 获取用户列表
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = User::orderBy('user_id','asc')
            ->where(function ($query) use ($request){
                $username = $request->input('username');
                if (!empty($username)){
                    $query->where('name','like','%'. $username .'%');
                }
            })
            ->paginate($request->input('num')?$request->input('num'):3);
//        $user = User::paginate(3);
        return view('admin/user/list',compact('user','request'));
        //
    }

    /**
     * 返回添加页面
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin/user/add');
    }

    /**
     * 执行添加操作
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $input = $request->all();
        //判断两次密码是否一致
        if ($input['pass'] != $input['repass']){
            return ['code'=>1,'msg'=>'两次密码不一致'];
        }
        //判断用户名和邮箱是否已存在
        $info = User::where(['name'=>$input['username']])->first();
        if ($info){
            return ['code'=>1,'msg'=>'用户名已存在'];
        }
        $user = User::create(['name'=>$input['username'],'email'=>$input['email'],'password'=>md5($input['pass'])]);
        if ($user){
            return ['code'=>0,'msg'=>'添加成功'];
        }else{
            return ['code'=>1,'msg'=>'添加失败'];
        }
    }

    /**
     * 显示一条用户记录
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * 返回修改页面
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $user = User::find($id);
        return view('admin/user/edit',compact('user'));
    }

    /**
     * 执行修改操作
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $user = User::find($id);
        $username = $request->input('username');

    }

    /**
     * 执行删除操作
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     *模拟秒杀活动-- 商品100件
     *
     */
    public function test(){
//        $path = app_path();
        # php中的文件锁
//        $fp = fopen($path.'/a.lock', 'r'); // php的文件锁和表没关系，随便一个文件即可
//        flock($fp, LOCK_EX);// 排他锁
//        DB::beginTransaction();
//        $info = DB::table('test')->where('id',1)->lockForUpdate()->value('num');
//        if ($info > 0){
//            $res = DB::table('test')->where('id',1)->update([
//                'num' => $info - 1,
//            ]);
//            Log::info($info);
//        }else{
//            return '库存不足';
//        }
//        DB::commit();

        DB::beginTransaction();
        try {
            $name = 'java';
            $count = DB::table('test')->where('name', $name)->lockForUpdate()->count();
            if ($count <= 0) {
                $res=DB::table('test')->insert(['name' => $name]);
                if ($res){
                    Log::info($count);
                }
                echo 1;
            } else {
                echo 0;
            }
            // 提交事务
            DB::commit();
        } catch (\Exception $e) {
            // 回滚事务
            DB::rollBack();
        }


        # php的文件锁，释放锁
//        flock($fp, LOCK_UN);
//        fclose($fp);
    }
}
