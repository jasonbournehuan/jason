<?php
namespace app\admin\controller;

class Notice extends Base
{
    private $map;
    public function _initialize()
    {
        parent::_initialize();
        if($this->get_uid() > 1){
            $this->map = ['group_id' => $this->get_group_id()];
        }
    }

    // 系统公告
    public function index()
    {
        if(request()->isAjax()){

            $param = input('param.');

            $limit = $param['pageSize'];
            $offset = ($param['pageNumber'] - 1) * $limit;

            $where = [];
            if (!empty($param['searchText'])) {
                $where['title'] = $param['searchText'];
            }

            $result = db('notice')->where($this->map)->where($where)->limit($offset, $limit)->select();
            foreach($result as $key=>$vo){
                // 生成操作按钮
                $result[$key]['operate'] = $this->makeBtn($vo['id']);
            }

            $return['total'] = db('notice')->where($this->map)->where($where)->count();  //总数据
            $return['rows'] = $result;

            return json($return);
        }

        return $this->fetch();
    }

    // 添加系统公告
    public function addNotice()
    {
        if(request()->isPost()){
            if($this->get_uid() == 1){
                return json(['code' => -2, 'data' => '', 'msg' => "该功能针对站点使用，超级管理员设置无效"]);
            }
            $param = input('post.');
            $param['title'] = trim($param['title']);

            $has = db('notice')->where($this->map)->field('id')->where('title', $param['title'])->find();
            if(!empty($has)){
                return json(['code' => -1, 'data' => '', 'msg' => '该公告已经存在']);
            }

            try{
                $param['group_id'] = $this->get_group_id();
                db('notice')->insert($param);
            }catch(\Exception $e){
                return json(['code' => -2, 'data' => '', 'msg' => $e->getMessage()]);
            }

            return json(['code' => 1, 'data' => '', 'msg' => '添加系统公告成功']);
        }

        return $this->fetch();
    }

    // 编辑系统公告
    public function editNotice()
    {
        if(request()->isAjax()){
            if($this->get_uid() == 1){
                return json(['code' => -2, 'data' => '', 'msg' => "该功能针对站点使用，超级管理员设置无效"]);
            }
            $param = input('post.');
            $param['title'] = trim($param['title']);

            // 检测用户修改的系统公告是否重复
            $has = db('notice')->where($this->map)->where('title', $param['title'])->where('id', '<>', $param['id'])->find();
            if(!empty($has)){
                return json(['code' => -1, 'data' => '', 'msg' => '该系统公告已经存在']);
            }

            try{
                db('notice')->where($this->map)->where('id', $param['id'])->update($param);
            }catch(\Exception $e){
                return json(['code' => -2, 'data' => '', 'msg' => $e->getMessage()]);
            }

            return json(['code' => 1, 'data' => '', 'msg' => '编辑系统公告成功']);
        }

        $id = input('param.id/d');
        $info = db('notice')->where($this->map)->where('id', $id)->find();

        $this->assign([
            'info' => $info
        ]);
        return $this->fetch();
    }

    // 删除系统公告
    public function delNotice()
    {
        if(request()->isAjax()){
            $id = input('param.id/d');

            try{
                db('notice')->where($this->map)->where('id', $id)->delete();
            }catch(\Exception $e){
                return json(['code' => -1, 'data' => '', 'msg' => $e->getMessage()]);
            }

            return json(['code' => 1, 'data' => '', 'msg' => '删除系统公告成功']);
        }
    }

    // 生成按钮
    private function makeBtn($id)
    {
        $operate = '<a href="' . url('notice/editNotice', ['id' => $id]) . '">';
        $operate .= '<button type="button" class="btn btn-primary btn-sm"><i class="fa fa-paste"></i> 编辑</button></a> ';

        $operate .= '<a href="javascript:noticeDel(' . $id . ')"><button type="button" class="btn btn-danger btn-sm">';
        $operate .= '<i class="fa fa-trash-o"></i> 删除</button></a> ';

        return $operate;
    }
}