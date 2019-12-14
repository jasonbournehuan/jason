<?php
namespace app\service\controller;

class Index extends Base
{
    public function index()
    {
        // 客服信息
        $userInfo = db('users')->where('id', cookie('l_user_id'))->find();
        $group_id = $userInfo['group_id'];
        $en_group_id = tid_encode($userInfo['group_id']);
		$word = db('words')->where('group_id', $group_id)->where('status', 1)->select();
		$words = array();
		foreach($word as $k => $v){
			$words[][0] = $v['content'];
		}
		$userInfo['group_id'] = $en_group_id;
        $this->assign([
            'uinfo' => $userInfo,
            'word' => $word,
            'status' => db('kf_config')->where('group_id', $group_id)->find()
        ]);
		
		if(request()->isMobile()){
			return $this->fetch('mobile');
        }
		$this->assign(['words' => json_encode($words, JSON_UNESCAPED_UNICODE  )]);
		$this->assign(['userInfo' => $userInfo]);
		$this->assign(['group_id' => $group_id]);
        return $this->fetch();
    }

    // 获取服务用户列表
    // 此方法是为了防止客服工作期间错误的刷新工作台，导致服务人员消失的问题
    public function getUserList()
    {
        if(request()->isAjax()){

            // 此处只查询过去 三个小时 内的服务的用户
            $userList = db('service_log')->field('log_id,user_id id,user_name name,user_avatar avatar,user_ip ip,end_time,protocol')
                ->where('kf_id', cookie('l_user_id'))
                ->where('start_time', '>', date('Y-m-d', time() - 3600 * 3))
                ->where('can_show', 0)
                ->group('id')
                ->select();

            return json(['code' => 1, 'data' => $userList, 'msg' => 'ok']);
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
                    $query->where('from_id', $param['uid'])->where('to_id', 'KF' . cookie('l_user_id'));
            })->whereOr(function($query) use($param){
                $query->where('from_id', 'KF' . cookie('l_user_id'))->where('to_id', $param['uid']);
            })->limit($offset, $limit)->order('id', 'desc')->select();

            $total =  db('chat_log')->where(function($query) use($param){
                $query->where('from_id', $param['uid'])->where('to_id', 'KF' . cookie('l_user_id'));
            })->whereOr(function($query) use($param){
                $query->where('from_id', 'KF' . cookie('l_user_id'))->where('to_id', $param['uid']);
            })->count();

            foreach($logs as $key=>$vo){

                $logs[$key]['type'] = 'user';
                $logs[$key]['time_line'] = date('Y-m-d H:i:s', $vo['time_line']);

                if($vo['from_id'] == 'KF' . cookie('l_user_id')){
                    $logs[$key]['type'] = 'mine';
                }
            }

            return json(['code' => 1, 'data' => $logs, 'msg' => intval($param['page']), 'total' => ceil($total / $limit)]);
        }
    }

    // ip 定位
    public function getCity()
    {
        $ip = input('param.ip');

        $ip2region = new \Ip2Region();
        $info = $ip2region->btreeSearch($ip);

        $city = explode('|', $info['region']);

        if(0 != $info['city_id']){
            return json(['code' => 1, 'data' => $city['2'] . $city['3'] . $city['4'], 'msg' => 'ok']);
        }else{

            return json(['code' => 1, 'data' => $city['0'], 'msg' => 'ok']);
        }
    }

    // 转接
    public function reLink()
    {
        if(request()->isAjax()) {
            $group_id = input('param.group');
            $groups = db('groups')->where('id', $group_id)->select();

            if(!empty($groups)) {

                foreach($groups as $key => $vo) {
                    $groups[$key]['users'] = db('users')->field('id,user_name,user_avatar,group_id')
                        ->where('group_id', $vo['id'])->where('online', 1)
                        ->where('id', '<>', cookie('l_user_id'))
                        ->select();
                }
            }

            return json(['code' => 1, 'data' => $groups, 'msg' => 'online info']);
        }
    }

    // 关闭某个用户的离线显示
    public function offlineHide()
    {
        if(request()->isAjax()) {

            $logId = input('param.id');
            $find = db('service_log')->field('user_id')->where('log_id', $logId)->find();
            $num = db('service_log')->where('user_id', $find['user_id'])
                ->where('start_time', '>', date('Y-m-d', time() - 3600 * 3))->count();

            if($num <= 1) {
                db('service_log')->where('log_id', $logId)->setField('can_show', 1);
            }else {
                db('service_log')->where('user_id', $find['user_id'])
                ->where('start_time', '>', date('Y-m-d', time() - 3600 * 3))->setField('can_show', 1);
            }

            return json(['code' => 1, 'data' => '', 'msg' => 'hide success']);
        }
    }

    // 通过http协议发送数据
    public function sendMsgFromHttp()
    {
        $param = input('post.');

        $url = config('kf_kf_url');

        $data = [
            "touser" => $param['data']['to_id'],
            "msgtype" => "text",
            "text" => ["content" => $param['data']['content']]
        ];
        $json = json_encode($data, JSON_UNESCAPED_UNICODE);  //php5.4+

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($json)){
            curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($curl, CURLOPT_HTTPHEADER, $headers );
        $output = curl_exec($curl);

        return json(['code' => 0, 'data' => '', 'msg' => '']);
    }
}
