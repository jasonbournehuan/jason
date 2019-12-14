<?php
namespace app\admin\controller;

class Words extends Base
{
    private $map;
    public function _initialize()
    {
        parent::_initialize();
        if($this->get_uid() > 1){
            $this->map = ['group_id' => $this->get_group_id()];
        }

    }
    // 常用语列表
    public function index()
    {
        if(request()->isAjax()){

            $param = input('param.');

            $limit = $param['pageSize'];
            $offset = ($param['pageNumber'] - 1) * $limit;

            $where = [];
            if (!empty($param['searchText'])) {
                $where['content'] = $param['searchText'];
            }

            $result = db('words')->where($this->map)->where($where)->limit($offset, $limit)->select();
            foreach($result as $key=>$vo){
                // 优化显示状态
                if(1 == $vo['status']){
                    $result[$key]['status'] = '<span class="label label-primary">启用</span>';
                }else{
                    $result[$key]['status'] = '<span class="label label-danger">禁用</span>';
                }

                // 生成操作按钮
                $result[$key]['operate'] = $this->makeBtn($vo['id']);
            }

            $return['total'] = db('words')->where($this->map)->where($where)->count();  //总数据
            $return['rows'] = $result;

            return json($return);

        }

        return $this->fetch();
    }

    // 添加常用语
    public function addWord()
    {
        if(request()->isPost()){
            if($this->get_uid() == 1){
                return json(['code' => -2, 'data' => '', 'msg' => "该功能针对站点使用，超级管理员设置无效"]);
            }
            $param = input('post.');
            $param['content'] = trim($param['content']);

            $has = db('words')->where($this->map)->field('id')->where('content', $param['content'])->find();
            if(!empty($has)){
                return json(['code' => -1, 'data' => '', 'msg' => '该常用语已经存在']);
            }

            $param['add_time'] = date('Y-m-d H:i:s');
            $param['group_id'] = $this->get_group_id();
                try{
                db('words')->insert($param);
            }catch(\Exception $e){
                return json(['code' => -2, 'data' => '', 'msg' => $e->getMessage()]);
            }

            return json(['code' => 1, 'data' => '', 'msg' => '添加常用语成功']);
        }

        $this->assign([
            'status' => config('kf_status')
        ]);

        return $this->fetch();
    }

    // 编辑常用语
    public function editWord()
    {
        if(request()->isAjax()){
            if($this->get_uid() == 1){
                return json(['code' => -2, 'data' => '', 'msg' => "该功能针对站点使用，超级管理员设置无效"]);
            }
            $param = input('post.');
            $param['content'] = trim($param['content']);

            // 检测用户修改的常用语是否重复
            $has = db('words')->where($this->map)->where('content', $param['content'])->where('id', '<>', $param['id'])->find();
            if(!empty($has)){
                return json(['code' => -1, 'data' => '', 'msg' => '该常用语已经存在']);
            }

            try{
                db('words')->where($this->map)->where('id', $param['id'])->update($param);
            }catch(\Exception $e){
                return json(['code' => -2, 'data' => '', 'msg' => $e->getMessage()]);
            }

            return json(['code' => 1, 'data' => '', 'msg' => '编辑常用语成功']);
        }

        $id = input('param.id/d');
        $info = db('words')->where($this->map)->where('id', $id)->find();

        $this->assign([
            'info' => $info,
            'status' => config('kf_status')
        ]);
        return $this->fetch();
    }

    // 删除常用语
    public function delWord()
    {
        if(request()->isAjax()){
            $id = input('param.id/d');

            try{
                db('words')->where($this->map)->where('id', $id)->delete();
            }catch(\Exception $e){
                return json(['code' => -1, 'data' => '', 'msg' => $e->getMessage()]);
            }

            return json(['code' => 1, 'data' => '', 'msg' => '删除常用语成功']);
        }
    }

    // 生成按钮
    private function makeBtn($id)
    {
        $operate = '<a href="' . url('words/editword', ['id' => $id]) . '">';
        $operate .= '<button type="button" class="btn btn-primary btn-sm"><i class="fa fa-paste"></i> 编辑</button></a> ';

        $operate .= '<a href="javascript:userDel(' . $id . ')"><button type="button" class="btn btn-danger btn-sm">';
        $operate .= '<i class="fa fa-trash-o"></i> 删除</button></a> ';

        return $operate;
    }
}