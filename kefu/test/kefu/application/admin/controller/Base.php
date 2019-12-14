<?php
namespace app\admin\controller;

use think\Controller;

class Base extends Controller
{
    private $uid;
    private $username;
    private $group_id;

    public function _initialize()
    {
        if(empty(cookie('user_name'))){
            $this->redirect(url('login/index'));
        }

        $this->username = cookie('user_name');
        $uid = db('admins')->where('user_name', $this->username)->limit(1)->value('id');

        if(!empty($uid)){
            $this->set_uid($uid);
        }

        if($uid > 1){
            // 初始化当前非管理员的group id
            $this->admin_group = db('groups')->where('admin_id', $this->get_uid())->find();
			$this->group_id = $this->admin_group['id'];
            $this->assign(['admin_group'=>$this->admin_group]);
            $this->assign(['is_super'=>false]);
        }else{
            $this->assign(['is_super'=>true]);
        }

        $this->assign([
            'version' => config('version'),
            'uid' => $this->get_uid(),
            'admin_username' => $this->username,
        ]);
    }

    public function get_uid(){
        return $this->uid;
    }

    public function set_uid($uid){
        $this->uid = $uid;
    }

    public function get_group_id(){
        return $this->group_id;
    }
}
