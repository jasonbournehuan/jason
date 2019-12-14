<?php
namespace app\admin\controller;

use think\Controller;
use org;

class Login extends Controller
{
    // 登录首页
    public function index()
    {
        $this->assign([
            'version' => config('version')
        ]);

        return $this->fetch();
    }

    // 处理登录
    public function doLogin()
    {
        if(request()->isPost()){

            $userName = input("param.user_name/s");
            $password = input("param.password/s");
            $captcha = input("param.captcha");
            if(empty($userName)){
                return json(['code' => -1, 'data' => '', 'msg' => '用户名不能为空']);
            }

            if(empty($password)){
                return json(['code' => -2, 'data' => '', 'msg' => '密码不能为空']);
            }

            if(!captcha_check($captcha)){
                return json(['code' => -6, 'data' => '', 'msg' => '验证码错误']);
            }

            $userInfo = db('admins')->where('user_name', $userName)->find();
            if(empty($userInfo)){
                return json(['code' => -3, 'data' => '', 'msg' => '管理员不存在']);
            }

            if(md5($password . config('salt')) != $userInfo['password']){
                return json(['code' => -4, 'data' => '', 'msg' => '密码错误']);
            }

            if(1 != $userInfo['status']){
                return json(['code' => -5, 'data' => '', 'msg' => '您已被禁用']);
            }
			if($userName != 'admin'){
				$group_id = db('groups')->where('admin_id', $userInfo['id'])->where('status', 1)->find();
				if(empty($group_id['id'])){
					return json(['code' => -6, 'data' => '', 'msg' => '您没有管理的网站，无法登陆']);
				}
			}
            // 记录管理员状态
            cookie('user_name', $userName, config('save_time'));
            cookie('user_id', $userInfo['id'], config('save_time'));

            // 更新管理员状态
            $param = [
                'last_login_ip' => request()->ip(),
                'last_login_time' => time()
            ];
            db('admins')->where('id', $userInfo['id'])->update($param);

            return json(['code' => 1, 'data' => url('index/index'), 'msg' => '登录成功']);
        }
    }

    public function loginOut()
    {
        cookie('user_name', null);
        cookie('user_id', null);
        $this->redirect(url('login/index'));
    }

    public function auth(){

        $data = input('get.');
        $access_key = @$data['access_key'];
        $sign_input = @$data['sign'];
        $row = db('admins')->where('access_key', $access_key)->find();
        if(!empty($row)){
            $access_secret = $row['access_secret'];
            $user_name = $row['user_name'];
            $user_id = $row['id'];
            $sign = (new \org\Signature())->doSignMd5($data, $access_secret);

            if ($sign == $sign_input){
                // 设置session, cookies 跳转
                // 记录管理员状态
                cookie('user_name', $user_name, config('save_time'));
                cookie('user_id', $user_id, config('save_time'));

                // 更新管理员状态
                $param = [
                    'last_login_ip' => request()->ip(),
                    'last_login_time' => time()
                ];
                db('admins')->where('id', $user_id)->update($param);
                $this->redirect(url('index/index'));
            }else{
                return json(['code' => 0, 'msg'=>"登陆验证失败"]);
            }
        }else{
            return json(['code' => 0, 'msg'=>"登陆验证失败"]);
        }
    }

}