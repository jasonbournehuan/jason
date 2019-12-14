<?php
namespace app\admin\controller;

class System extends Base
{
    private $map;
    public function _initialize()
    {
        parent::_initialize();
        if($this->get_uid() > 1){
            $this->map = ['group_id' => $this->get_group_id()];
        }
    }

    // 自动回复设置
    public function reply()
    {
        if(request()->isPost()){

            $param = input('post.');
            if(empty($param['word'])){
                return json(['code' => -1, 'data' => '', 'msg' => '回复内容不能为空']);
            }

            if($this->get_uid() == 1){
                return json(['code' => -2, 'data' => '', 'msg' => "该功能针对站点使用，超级管理员设置无效"]);
            }
            try{
                if(db('reply')->where($this->map)->count()){
                    db('reply')->where($this->map)->update($param);
                }else{
                    $param['group_id'] = $this->get_group_id();
                    db('reply')->insert($param);
                }
            }catch(\Exception $e){
                return json(['code' => -2, 'data' => '', 'msg' => $e->getMessage()]);
            }

            return json(['code' => 1, 'data' => '', 'msg' => '设置成功']);
        }

        $info = db('reply')->where($this->map)->find();
        $this->assign([
            'info' => $info,
            'status' => config('kf_status')
        ]);

        return $this->fetch();
    }

    // 客服设置
    public function customerService()
    {
        if(request()->isPost()){

            $param = input('post.');
            if($this->get_uid() == 1){
                return json(['code' => -2, 'data' => '', 'msg' => "该功能针对站点使用，超级管理员设置无效"]);
            }

            if(db('kf_config')->where($this->map)->count()){
                db('kf_config')->where($this->map)->update($param);
            }else{
                $param['group_id'] = $this->get_group_id();
                db('kf_config')->insert($param);
            }

            return json(['code' => 1, 'data' => '', 'msg' => '设置成功']);
        }

        $this->assign([
            'config' => db('kf_config')->where($this->map)->find(),
            'status' => config('kf_status')
        ]);

        return $this->fetch();
    }

    // 历史会话记录
    public function wordsLog()
    {
        if(request()->isAjax()){

            $param = input('param.');

            $limit = $param['pageSize'];
            $offset = ($param['pageNumber'] - 1) * $limit;

            // 默认显示最近7天
            $start = input('param.start');
            $end = input('param.end');

            $temp = db('chat_log')->where($this->map);
            $countTmp = db('chat_log')->where($this->map);
            if(!empty($param['searchText'])){
                $temp = $temp->where('from_name', $param['searchText'])->whereOr('to_name', $param['searchText']);
                $countTmp = $countTmp->where('from_name', $param['searchText'])->whereOr('to_name', $param['searchText']);
            }

            if(!empty($start) && !empty($end) && $start <= $end){
                $temp = $temp->whereBetween('time_line', [strtotime($start), strtotime($end . ' 23:59:59')]);
                $countTmp = $countTmp->whereBetween('time_line', [strtotime($start), strtotime($end . ' 23:59:59')]);
            }

            $result = $temp->limit($offset, $limit)->order('id', 'desc')->select();
            foreach($result as $key=>$vo){
                $result[$key]['time_line'] = date('Y-m-d H:i:s', $vo['time_line']);

                $operate = '<a href="javascript:delword(' . $vo['id'] . ')"><button type="button" class="btn btn-danger btn-sm">';
                $operate .= '<i class="fa fa-trash-o"></i> 删除</button></a> ';

                $result[$key]['operate'] = $operate;
            }

            $return['total'] = $countTmp->count();  //总数据
            $return['rows'] = $result;

            return json($return);

        }

        return $this->fetch();
    }

    // 历史留言
    public function leaveMsgLog()
    {
        if(request()->isAjax()){

            $param = input('param.');

            $limit = $param['pageSize'];
            $offset = ($param['pageNumber'] - 1) * $limit;

            // 默认显示最近7天
            $start = input('param.start');
            $end = input('param.end');

            $temp = db('leave_msg')->where($this->map);
            $countTmp = db('leave_msg')->where($this->map);

            if(!empty($start) && !empty($end) && $start <= $end){
                $temp = $temp->whereBetween('add_time', [strtotime($start), strtotime($end . ' 23:59:59')]);
                $countTmp = $countTmp->whereBetween('add_time', [strtotime($start), strtotime($end . ' 23:59:59')]);
            }

            $result = $temp->limit($offset, $limit)->order('id', 'desc')->select();
            foreach($result as $key=>$vo){
                $result[$key]['add_time'] = date('Y-m-d H:i:s', $vo['add_time']);

                $operate = '<a href="javascript:delword(' . $vo['id'] . ')"><button type="button" class="btn btn-danger btn-sm">';
                $operate .= '<i class="fa fa-trash-o"></i> 删除</button></a> ';

                $result[$key]['operate'] = $operate;
            }

            $return['total'] = $countTmp->count();  //总数据
            $return['rows'] = $result;

            return json($return);

        }

        return $this->fetch();
    }

    // 删除历史会话
    public function deleteWords()
    {
        if(request()->isAjax()) {

            $id = input('param.id');

            db('chat_log')->where($this->map)->where('id', $id)->delete();

            return json(['code' => 1, 'data' => '', 'msg' => '删除成功']);
        }
    }

    // 删除历史留言
    public function deleteLeave()
    {
        if(request()->isAjax()) {

            $id = input('param.id');

            db('leave_msg')->where($this->map)->where('id', $id)->delete();

            return json(['code' => 1, 'data' => '', 'msg' => '删除成功']);
        }
    }
}