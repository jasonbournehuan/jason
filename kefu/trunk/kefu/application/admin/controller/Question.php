<?php
namespace app\admin\controller;

class Question extends Base
{
    private $map;
    public function _initialize()
    {
        parent::_initialize();
        if($this->get_uid() > 1){
            $this->map = ['group_id' => $this->get_group_id()];
        }
    }

    // 常见问题
    public function index()
    {
        if(request()->isAjax()){

            $param = input('param.');

            $limit = $param['pageSize'];
            $offset = ($param['pageNumber'] - 1) * $limit;

            $where = [];
            if (!empty($param['searchText'])) {
                $where['question'] = $param['searchText'];
            }

            $result = db('questions')->where($this->map)->where($where)->limit($offset, $limit)->select();
            foreach($result as $key=>$vo){
                // 生成操作按钮
                $result[$key]['operate'] = $this->makeBtn($vo['id']);
            }

            $return['total'] = db('questions')->where($this->map)->where($where)->count();  //总数据
            $return['rows'] = $result;

            return json($return);
        }

        return $this->fetch();
    }

    // 添加常用语
    public function addQuestion()
    {
        if(request()->isPost()){
            if($this->get_uid() == 1){
                return json(['code' => -2, 'data' => '', 'msg' => "该功能针对站点使用，超级管理员设置无效"]);
            }
            $param = input('post.');
            $param['question'] = trim($param['question']);
			$param['quick_id'] = intval($param['quick_id']);
			if($param['quick_id'] > 99999 || $param['quick_id'] < 0){
				return json(['code' => -1, 'data' => '', 'msg' => '快捷回复ID只能是正数，范围为1-99999，0为不支持快捷回复']);
			}else if($param['quick_id'] > 0){
				$has = db('questions')->where($this->map)->field('id')->where('quick_id', $param['quick_id'])->find();
				if(!empty($has)){
					return json(['code' => -1, 'data' => '', 'msg' => '快捷回复ID：《'.$param['quick_id'].'》已经存在']);
				}
			}

            $has = db('questions')->where($this->map)->field('id')->where('question', $param['question'])->find();
            if(!empty($has)){
                return json(['code' => -1, 'data' => '', 'msg' => '该常见问题已经存在']);
            }

            try{
                $param['group_id'] = $this->get_group_id();
                db('questions')->insert($param);
            }catch(\Exception $e){
                return json(['code' => -2, 'data' => '', 'msg' => $e->getMessage()]);
            }

            return json(['code' => 1, 'data' => '', 'msg' => '添加常见问题成功']);
        }

        return $this->fetch();
    }

    // 编辑常用语
    public function editQuestion()
    {
        if(request()->isAjax()){
            if($this->get_uid() == 1){
                return json(['code' => -2, 'data' => '', 'msg' => "该功能针对站点使用，超级管理员设置无效"]);
            }
            $param = input('post.');
            $param['question'] = trim($param['question']);
			$param['quick_id'] = intval($param['quick_id']);
			if($param['quick_id'] > 99999 || $param['quick_id'] < 0){
				return json(['code' => -1, 'data' => '', 'msg' => '快捷回复ID只能是正数，范围为1-99999，0为不支持快捷回复']);
			}else if($param['quick_id'] > 0){
				$has = db('questions')->where($this->map)->field('id')->where('quick_id='.$param['quick_id'].' and id != '.$param['id'])->find();
				if(!empty($has)){
					return json(['code' => -1, 'data' => '', 'msg' => '快捷回复ID：《'.$param['quick_id'].'》已经存在']);
				}
			}

            // 检测用户修改的常用语是否重复
            $has = db('questions')->where($this->map)->where('question', $param['question'])->where('id', '<>', $param['id'])->find();
            if(!empty($has)){
                return json(['code' => -1, 'data' => '', 'msg' => '该常见问题已经存在']);
            }

            try{
                db('questions')->where($this->map)->where('id', $param['id'])->update($param);
            }catch(\Exception $e){
                return json(['code' => -2, 'data' => '', 'msg' => $e->getMessage()]);
            }

            return json(['code' => 1, 'data' => '', 'msg' => '编辑常见问题成功']);
        }

        $id = input('param.id/d');
        $info = db('questions')->where($this->map)->where('id', $id)->find();

        $this->assign([
            'info' => $info
        ]);
        return $this->fetch();
    }

    // 删除常用语
    public function delQuestion()
    {
        if(request()->isAjax()){
            $id = input('param.id/d');

            try{
                db('questions')->where($this->map)->where('id', $id)->delete();
            }catch(\Exception $e){
                return json(['code' => -1, 'data' => '', 'msg' => $e->getMessage()]);
            }

            return json(['code' => 1, 'data' => '', 'msg' => '删除常见问题成功']);
        }
    }

    // 生成按钮
    private function makeBtn($id)
    {
        $operate = '<a href="' . url('question/editQuestion', ['id' => $id]) . '">';
        $operate .= '<button type="button" class="btn btn-primary btn-sm"><i class="fa fa-paste"></i> 编辑</button></a> ';

        $operate .= '<a href="javascript:questionDel(' . $id . ')"><button type="button" class="btn btn-danger btn-sm">';
        $operate .= '<i class="fa fa-trash-o"></i> 删除</button></a> ';

        return $operate;
    }
}