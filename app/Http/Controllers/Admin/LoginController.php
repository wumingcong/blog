<?php

namespace App\Http\Controllers\Admin;

use App\Model\User;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    //后台登录页
    public function login(){
//        $code = session('code');
//        dd($code);
        return view('admin/login');
    }
    // 验证码生成
    public function captcha($tmp)
    {

        $phrase = new PhraseBuilder();
        // 设置验证码位数
        $code = $phrase->build(4);
        // 生成验证码图片的Builder对象，配置相应属性
        $builder = new CaptchaBuilder($code, $phrase);
        // 设置背景颜色
        $builder->setBackgroundColor(220, 210, 230);
        $builder->setMaxAngle(25);
        $builder->setMaxBehindLines(0);
        $builder->setMaxFrontLines(0);
        // 可以设置图片宽高及字体
        $builder->build($width = 100, $height = 40, $font = null);
        // 获取验证码的内容
        $phrase = $builder->getPhrase();
        // 把内容存入session
//        \Session::flash('code', $phrase);
        session()->flash('code', $phrase);
        // 生成图片
        header("Cache-Control: no-cache, must-revalidate");
        header("Content-Type:image/jpeg");
        $builder->output();
    }

    /**
     * 执行登录
     */
    public function doLogin(Request $request){
        $input = $request->except('_token');
        $rule = array(
            'username'=>'required|between:4,20|alpha_dash',
            'password'=>'required|between:4,20|alpha_dash'
        );
        $msg = array(
            'username.required'      => '用户名必须填写',
            'username.between'       => '用户名长度为4到20位',
            'username.alpha_dash'    => '用户名必须为数字，字母和下划线',
            'password.required'      => '密码必须填写',
            'password.between'       => '密码长度为4到20位',
            'password.alpha_dash'    => '密码必须为数字，字母和下划线',
        );
        $validator = Validator::make($input,$rule,$msg);
        if ($validator->fails()) {
            return redirect('admin/login')
                ->withErrors($validator)
                ->withInput();
        }

        //验证验证码是否正确
        if ($input['captcha'] != session()->get('code')){
            return redirect('admin/login')->with('errors','验证码错误');
        }
        //验证用户名和密码是否正确
        $user = User::where('name',$input['username'])->first();
        if (!$user){
            return redirect('admin/login')->with('errors','用户名错误');
        }
        if (md5($input['password']) != $user['password']){
            return redirect('admin/login')->with('errors','密码错误');
        }

        //保存用户信息到session中
        session()->put('user',$user);

        //跳转到首页
        return redirect('admin/index');
    }
}
