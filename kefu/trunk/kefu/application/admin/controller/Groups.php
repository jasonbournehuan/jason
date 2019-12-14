<?php
namespace app\admin\controller;

class Groups extends Base
{

    public function _initialize()
    {
        parent::_initialize();

        if ($this->get_uid() != 1) {
            return json(['code' => -1, 'data' => '', 'msg' => '对不起， 您无权使用当前功能']);
        }
    }

    // 网站列表
    public function index()
    {

        if(request()->isAjax()){
            $searchText = input('searchText');
            $pageSize = input('pageSize');
            $result = db('groups')->alias('g')->join("admins a", 'a.id=g.admin_id')->field('g.*, a.user_name admin_name')->select();
            $group_admin = [];
            foreach ($result as $v){
                $group_admin[$v['id']] = $v['admin_name'];
            }
            if(!empty($searchText))
            {
                $result = db('groups')->where('name','like','%'.$searchText.'%')->paginate($pageSize)->all();
            }else
            {
                $result = db('groups')->paginate($pageSize)->all();
            }

            foreach($result as $key=>$vo){
                // 优化显示状态
                if(1 == $vo['status']){
                    $result[$key]['status'] = '<span class="label label-primary">启用</span>';
                }else{
                    $result[$key]['status'] = '<span class="label label-danger">禁用</span>';
                }

				$result[$key]['site_code'] = tid_encode($vo['id']);
                $result[$key]['admin_name'] = @$group_admin[$vo['id']];

                // 统计网站人数
                $result[$key]['users_num'] = db('users')->where('group_id', $vo['id'])->count() . " / " . $vo['kf_size'];

                // 生成操作按钮
                $result[$key]['operate'] = $this->makeBtn($vo['id']);

            }

            $return['total'] = db('groups')->count();  //总数据
            $return['rows'] = $result;

            return json($return);

        }

        return $this->fetch();
    }

  

    // 添加网站
    public function addGroup()
    {
        if(request()->isPost()){

            $param = input('post.');

            $has = db('groups')->field('id')->where('name', $param['name'])->find();
            if(!empty($has)){
                return json(['code' => -1, 'data' => '', 'msg' => '该网站已经存在']);
            }
            $admin_name = $param['admin'];
            unset($param['admin']);
			if(!empty($admin_name)){
				$admin = db('admins')->where('user_name', $admin_name)->limit(1)->find();
				if($admin){
					if($admin['id'] == 1){
						return json(['code' => -2, 'data' => '', 'msg' => "超级管理员不能设置为网站管理员"]);
					}
					$admin_group_count = db('groups')->where('admin_id', $admin['id'])->count();
					if($admin_group_count > 0){
						return json(['code' => -2, 'data' => '', 'msg' => "管理员不能管理多个网站"]);
					}
					$param['admin_id'] = $admin['id'];
				}else{
					return json(['code' => -2, 'data' => '', 'msg' => "你没有填入正确的管理员信息"]);
				}
			}else{
				$param['admin_id'] = 0;
			}

            try{
                db('groups')->insert($param);
            }catch(\Exception $e){
                return json(['code' => -2, 'data' => '', 'msg' => $e->getMessage()]);
            }

            return json(['code' => 1, 'data' => '', 'msg' => '添加网站成功']);
        }

        $this->assign([
            'status' => config('kf_status')
        ]);

        return $this->fetch();
    }

    // 编辑网站
    public function editGroup()
    {
        if(request()->isAjax()){

            $param = input('post.');

            // 检测用户修改的用户名是否重复
            $has = db('groups')->where('name', $param['name'])->where('id', '<>', $param['id'])->find();
            if(!empty($has)){
                return json(['code' => -1, 'data' => '', 'msg' => '该网站已经存在']);
            }

            $kf_size = $param['kf_size'];
            $group_size = db('users')->where('group_id', $param['id'])->count();
            if($kf_size < $group_size){
                return json(['code' => -2, 'data' => '', 'msg' => "你当前的客服数[{$group_size}]大于你设置的数量[{$kf_size}]"]);
            }

            $admin_name = $param['admin'];
            unset($param['admin']);
			if(!empty($admin_name)){
				$admin = db('admins')->where('user_name', $admin_name)->limit(1)->find();
				if($admin){
					if($admin['id'] == 1){
						return json(['code' => -2, 'data' => '', 'msg' => "超级管理员不能设置为网站管理员"]);
					}
					$admin_group_count = db('groups')->where('admin_id', $admin['id'])->where("id", "<>", $param['id'])->count();
					if($admin_group_count > 0){
						return json(['code' => -2, 'data' => '', 'msg' => "管理员不能管理多个网站"]);
					}
					$param['admin_id'] = $admin['id'];
				}else{
					return json(['code' => -2, 'data' => '', 'msg' => "你没有填入正确的管理员信息"]);
				}
			}else{
				$param['admin_id'] = 0;
			}

            try{
                db('groups')->where('id', $param['id'])->update($param);
            }catch(\Exception $e){
                return json(['code' => -2, 'data' => '', 'msg' => $e->getMessage()]);
            }

            return json(['code' => 1, 'data' => '', 'msg' => '编辑网站成功']);
        }

        $id = input('param.id/d');
        $info = db('groups')->where('id', $id)->find();
        if(!empty($info)){
            $info['admin'] = db('admins')->where('id', $info['admin_id'])->value('user_name');
        }

        $this->assign([
            'info' => $info,
            'status' => config('kf_status')
        ]);
        return $this->fetch();
    }

    // 删除网站
    public function delGroup()
    {
        if(request()->isAjax()){
            $id = input('param.id/d');

            // 查询该网站下是否有客服
            $has = db('users')->where('group_id', $id)->count();
            if($has > 0){
                return json(['code' => -2, 'data' => '', 'msg' => '该网站下有客服，不可删除']);
            }

            try{
                db('groups')->where('id', $id)->delete();
            }catch(\Exception $e){
                return json(['code' => -1, 'data' => '', 'msg' => $e->getMessage()]);
            }

            return json(['code' => 1, 'data' => '', 'msg' => '删除网站成功']);
        }
    }

    // 管理组员
    public function manageUser()
    {
        return $this->fetch();
    }

    // 生成按钮
    private function makeBtn($id)
    {
        $operate = '<a href="' . url('groups/editgroup', ['id' => $id]) . '">';
        $operate .= '<button type="button" class="btn btn-primary btn-sm"><i class="fa fa-paste"></i> 编辑</button></a> ';

        $operate .= '<a href="javascript:userGroup(' . $id . ')"><button type="button" class="btn btn-danger btn-sm">';
        $operate .= '<i class="fa fa-trash-o"></i> 删除</button></a> ';

        //$operate .= '<a href="' . url('groups/manageUser') . '">';
        //$operate .= '<button type="button" class="btn btn-info btn-sm"><i class="fa fa-user-plus"></i> 管理组员</button></a>';

        return $operate;
    }
}