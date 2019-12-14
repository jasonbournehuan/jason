<?php
namespace app\admin\controller;

use think\Validate;

class Secret extends Base
{
    // 编辑管理员
    public function edit()
    {
        $uid = $this->get_uid();
        if (request()->isAjax()) {

            //验证器
            $access_secret=input('post.');
            $validate = new Validate([
                'access_key'  => 'require|min:10|max:30',
                'access_secret'  => 'require|min:18|max:50',
            ]);
            if(!$validate->check($access_secret)){
                //输出的提示错误信息
                $error=$validate->getError();
                $this->error($error,'secret/edit');
            }

            try {
                db('admins')->where('id', $uid)->update($access_secret);
            } catch (\Exception $e) {
                return json(['code' => -2, 'data' => '', 'msg' => $e->getMessage()]);
            }
            return json(['code' => 1, 'data' => '', 'msg' => '编辑安全验证信息成功']);
        }

        $info = db('admins')->where('id', $uid)->find();

        $this->assign([
            'info' => $info,
        ]);
        return $this->fetch();
    }

}