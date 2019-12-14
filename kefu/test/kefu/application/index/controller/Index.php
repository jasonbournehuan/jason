<?php
namespace app\index\controller;

use think\Controller;

class Index extends Controller
{
//    public function index()
//    {
//        return $this->fetch();
//    }

    // 默认一个404的首页
    public function index()
    {
		header('HTTP/1.1 404 Not Found');
		header("status: 404 Not Found");
		exit;
	}

    // pc客户端
    public function chat()
    {
		$param = '';
        $id = input('param.id');
        $group = $gid = input('param.group');
        $avatar = input('param.avatar');
        $name = input('param.name');
		$mid = tid_decode($gid);
		if($mid >= 1){
			$gid = $mid;
		}else{
			echo "请勿尝试非法操作！";exit;
		}
        // 跳转到移动端
        if(request()->isMobile()){
			if(!empty($group)){
				$param .= $group.'/';
			}
			if(!empty($id)){
				$param .= $id.'/';
			}
			if(!empty($name)){
				$param .= $name.'/';
			}
			if(!empty($avatar)){
				$param .= $avatar.'/';
			}
            if(!empty($safeArea)){
                $param .= '?safeArea='.$safeArea;
            }
            $this->redirect('/mobile/' . $param);
        }
		if(empty($id)){
			$id = cookie('chat_user_id');
			if(empty($id)){
				$tmp_id = temp_uid();
				$id = "temp_".$tmp_id;
				$name = '游客'.$tmp_id;
				cookie('chat_user_id', $id, 1800);
			}
		}
		if(empty($name)){
			$name = $id;
		}

		if(empty($avatar)){
			$avatar = '/static/demo/images/l02.png';
		}

        $questions = db('questions')->where('group_id', $gid)->field('id,question')->select();
        $notice = db('notice')->where('group_id', $gid)->field('id,title')->select();
        $this->assign([
            'socket' => config('protocol') . config('socket'),
            'id' => $id,
            'name' => $name,
            'group' => $group,
            'avatar' => $avatar,
            'question' => $questions,
            'notice' => $notice
        ]);

        return $this->fetch();
    }

    // 移动客户端
    public function mobile()
    {
        $uid = input('param.id');
        $gid = input('param.group');
        $avatar = input('param.avatar');
        $name = input('param.name');
        $group = input('param.group');
		if(!empty($gid)){
			$mid = tid_decode($gid);
			if($mid >= 1){
				$gid = $mid;
			}else{
				echo "请勿尝试非法操作！";exit;
			}
		}else{
			echo "请勿尝试非法操作！";exit;
		}
		if(empty($id)){
			$id = cookie('chat_user_id');
			if(empty($id)){
				$tmp_id = temp_uid();
				$id = "temp_".$tmp_id;
				$name = '游客'.$tmp_id;
				cookie('chat_user_id', $id, 1800);
			}
		}
		if(empty($name)){
			$name = $id;
		}
		if(empty($avatar)){
			$avatar = '/static/demo/images/l02.png';
		}
        $questions = db('questions')->where('group_id='.$gid.' and quick_id > 0')->field('id,question,answer,quick_id')->order('quick_id asc')->select();
		$quick_list = array();
		if(!empty($questions)){
			$quick_list[] = array(
				'quick_id' => 0,
				'title' => '',
				'contents' => '尊敬的贵宾，您可以通过回复下列问题ID获得快速帮助！',
			);//第一条给默认文字提示
			foreach($questions as $k => $v){
				$quick_list[] = array(
					'quick_id' => $v['quick_id'],
					'title' => $v['question'],
					'contents' => $v['answer'],
				);
			}
		}
		$quick_list = json_encode($quick_list);
        $this->assign([
            'socket' => config('protocol') . config('socket'),
            'id' => $id,
            'name' => $name,
            'group' => $group,
            'avatar' => $avatar,
			'quick_list' => $quick_list,
        ]);

        return $this->fetch();
    }

    // 留言
    public function leave()
    {
        $gid = input('group');
		$mid = tid_decode($gid);
		if($mid >= 1){
			$gid = $mid;
		}else{
			echo "请勿尝试非法操作！";exit;
		}
        if(request()->isAjax() and !empty($_POST)){
            $param = input('post.');
            if(empty($param['username']) || empty($param['phone']) || empty($param['content'])){
                return json(['code' => -1, 'data' => '', 'msg' => '请全部填写']);
            }
			unset($param['group']);
            $param['add_time'] = time();
            $param['group_id'] = $gid;
            try{
                db('leave_msg')->insert($param);
            }catch (\Exception $e){
                return json(['code' => -2, 'data' => '', 'msg' => '留言失败']);
            }

            return json(['code' => 1, 'data' => '', 'msg' => '留言成功']);
        }

        $group_id = input('param.group');
        $this->assign(['group'=> $group_id]);

        return $this->fetch();
    }

    // 常见问题
    public function question()
    {
        $id = input('param.id');

        $question = db('questions')->where('id', $id)->find();

        $this->assign([
            'question' => $question
        ]);

        return $this->fetch();
    }

    // 系统公告
    public function notice()
    {
        $id = input('param.id');

        $question = db('notice')->where('id', $id)->find();

        $this->assign([
            'notice' => $question
        ]);

        return $this->fetch();
    }

    // 绑定点赞
    public function bindPraise()
    {
        if(request()->isAjax()) {

            $kfId = ltrim(input('param.kf_id', 0), 'KF');
            $uerId = input('param.uid', 0);
            $uuid = uniqid();

            try {
                db('praise')->insert([
                    'user_id' => $uerId,
                    'kf_id' => $kfId,
                    'uuid' => $uuid,
                    'star' => 0,
                    'add_time' => date('Y-m-d H:i:s')
                ]);
            }catch (\Exception $e) {
                return json(['code' => -1, 'data' => '', 'res' => 'ERROR']);
            }

            return json(['code' => 1, 'data' => $uuid, 'res' => 'SUCCESS']);
        }
    }

    // 点赞
    public function doPraise()
    {
        if(request()->isAjax()) {

            $uuid = input('param.uuid', 0);
            $star = input('param.star', 0);
		/*	echo $uuid.'||'.$star;exit;*/
            if($star > 0 && 0 != $uuid) {
                try {
                    db('praise')->where('uuid', $uuid)->update([
                        'star' => $star,
                    ]);
                }catch (\Exception $e) {
                    return json(['code' => -1, 'data' => '', 'res' => 'ERROR']);
                }
            }

            return json(['code' => 1, 'data' => '', 'res' => 'SUCCESS']);
        }
    }

    // 获取聊天记录
    public function getChatLog()
    {
        if(request()->isAjax()){

            $param = input('param.');

            $limit = 10; // 一次显示10 条聊天记录
            $offset = ($param['page'] - 1) * $limit;

            $logs = db('chat_log')->where(function($query) use($param){
                $query->where('from_id', $param['uid'])->where('to_id', $param['kf_id']);
            })->whereOr(function($query) use($param){
                $query->where('from_id', $param['kf_id'])->where('to_id', $param['uid']);
            })->limit($offset, $limit)->order('id', 'desc')->select();

            $total =  db('chat_log')->where(function($query) use($param){
                $query->where('from_id', $param['uid'])->where('to_id', $param['kf_id']);
            })->whereOr(function($query) use($param){
                $query->where('from_id', $param['kf_id'])->where('to_id', $param['uid']);
            })->count();

            foreach($logs as $key=>$vo){

                $logs[$key]['type'] = 'user';
                $logs[$key]['time_line'] = date('Y-m-d H:i:s', $vo['time_line']);

                if($vo['from_id'] == $param['uid']){
                    $logs[$key]['type'] = 'mine';
                }
            }

            return json(['code' => 1, 'data' => $logs, 'msg' => intval($param['page']), 'total' => ceil($total / $limit)]);
        }
    }
}
