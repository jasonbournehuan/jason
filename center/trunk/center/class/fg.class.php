<?php
/**fg接口
 * Class fg
 * 最短拉取时间 无间隔
 */
class fg extends base_model{
	function __construct() {
		parent::__construct();
		//加载ID转CODE类和错误代码类
		$this->c('id_to_code');
		$this->c('error');
		//用户信息
		$this->game_user = array();
		//网站ID
		$this->platform_id = 1;
        //API授权信息
        $this->fg_merchantname = $this->conf['platform'][$this->platform_id]['merchantName'];
        $this->fg_merchantcode = $this->conf['platform'][$this->platform_id]['merchantCode'];
        //API接口域名
        $this->fg_api_url = $this->conf['platform'][$this->platform_id]['url'];
        //$this->fg_api_url = $this->conf['platform'][$this->platform_id]['url1']; //备用
		$this->platform_name = '乐游棋牌';
		$this->site_id = 0;
		$this->en_site_id = '';
		$this->game_type = 'h5';//默认H5页面，支持H5和APP两个模式
		$this->user_ip = '';//用户IP
		$this->site_url = '';//客户端网站地址，返回使用
		//用户名最大最小长度限制
		$this->max_username_len = 32;
		$this->min_username_len = 5;
		$this->game_info = array();//20190625新增
        $this->return_type = 1;

    }
    private $order_id;
	//检测接口需求信息
	public function check_info(){
        if(empty($this->game_user)){
            return $this->echo_cmd('user_empty');
        }else if(empty($this->site_id)){
            return $this->echo_cmd('site_empty');
        }
	}
    /**
     * @param $user_data 数据
     * @return mixed
     */
    public function check_user($user_data)
    {
        $this->c('user');
        $id = $user_data['site_id'].sprintf("%011s",$user_data['uid']);
        $user_list = $this->user->get($id);
        if(empty($user_list)){
            //用户不存在，则入库用户数据
            $en_username = $this->id_to_code->en_username($user_data['site_id'], $user_data['uid'],$this->min_username_len, $this->max_username_len);
            $user_data['password'] = substr(md5($user_data['site_id'].$en_username.$user_data['old_username']), 8, 16);
            $user_data['username'] = $en_username;
            $user_data['add_time'] = $user_data['end_time'] = $_SERVER['time'];
            $user_data['id']  =  $id;
            if($this->user->add_list($user_data)!= 1)
            {
                return $this->echo_cmd('reg_user_error');
            }
        }else{
            $ip = $user_data['ip'];
            $user_data = $user_list;
            $user_data['ip'] = $ip;
        }
        return  $this->game_user = $user_data;
    }

    /**  检查金额
     * @param $money
     * @return array
     */
    public function check_money($money)
    {
        $amount = intval($money*100)/100;
        $result = array(
            "money" => $amount,
            "balance" => round($money - $amount,4),
        );
        return $result;
    }

    /**    各自单独解密
     * @param $en_username
     * @return array
     */
    public function de_username($en_username){
        $de_username = $this->id_to_code->tid_decode($en_username, 0);
        $de_username = explode("-",$de_username);
        return $de_username;
    }

	//接口报错转系统报错
	public function api_error_to_system_error($api_error){
		//值为空则表示不会发生的情况，所以无需转换
		$api_error_list = array(
			'100' => 'platform_error',//错误请求, MERCHANTNAME＆merchantcode 为空
			'101' => 'platform_error',//代理商余额不足
			'102' => 'platform_error',//Merchantname 账号或密码不对，或者账号被锁 
			'103' => 'platform_error',//未授权，不能查询其他运营商信息 
			'104' => 'user_nothing',//该玩家不存在 
			'105' => '',//玩家已经存在 
			'106' => 'user_frozen',//账户被冻结 
			'107' => '',//玩家代码必须是 5-32 个字符，并没有特殊的字符之间
			'108' => '',//密码应是 5-32 个字母数字
			'109' => 'in_out_money_number_error',//筹码值非法
			'110' => 'parameters_error',//参数非法 
			'111' => 'user_money_insufficient',//玩家余额不足
			'112' => 'game_nothingness',//无效的游戏代码
			'113' => 'game_nothingness',//该游戏不在代理商选中游戏列中 禁止访问
			'114' => '',//无效的密码值 
			'115' => 'platform_error',//IP 被阻止 
			'116' => 'platform_error',//代理商请求过多 被阻止
			'117' => 'out_money_error',//玩家正在结算无法提现
			'118' => 'platform_change_game_error',//正在赌注中無法切換遊戲
			'119' => 'order_id_error',//单号不存在或者该注单失败
			'120' => 'order_id_error',//单号已经存在
			'121' => 'time_range_error',//时间范围有误 
			'122' => 'no_authority',//没有权限启动大厅
			'123' => '',//Id 不属于该玩家
			'201' => 'platform_error',//api 内部错误
			'202' => 'platform_error',//重试
			'203' => 'in_out_money_error',//筹码更新失败
			'204' => '',//采集数据失败
			'205' => 'login_user_error',//玩家登录状态异常
			'206' => 'time_out',//超时
			'207' => 'platform_maintain',//api 维护中
			'208' => 'in_out_money_progressive',//充值转账正在处理中
			'209' => 'in_out_money_error',//充值提现失败
		);
		if(!empty($api_error_list[$api_error])){
			return $this->error->code($api_error_list[$api_error]);
		}else{
			return '';
		}
	}

	//通用递交接口
	public function api_query($api, $data){
		$url = $this->fg_api_url.$api;//要抓取数据的页面地址
		$header = array(
			'merchantname: '.$this->fg_merchantname,
			'merchantcode: '.$this->fg_merchantcode,
		);
		$info = $this->za->curlPost($url, $data, 3, 5, '', $header);//请求接口数据
		$data = json_decode($info, true);
		return $data;
	}

	//开户接口
	public function reg($num = 1){
		if($num > 3){
            return $this->echo_cmd('reg_user_error');
		}
		$this->check_info();
		$api = "/players";//api接口
		$api_data = array(
			'member_code' => $this->game_user['username'],
			'password' => $this->game_user['password'],
		);
		$data = $this->api_query($api, $api_data);
		if(isset($data['code'])){
			if($data['code'] == '105' or $data['code'] == '0'){
				return array('status' => 1, 'msg' => 'registered');
			}else{
				$error = $this->api_error_to_system_error($data['code']);
				if(!empty($error)){
					return $error;
				}else{
					$num += 1;
					return $this->reg($num);
				}
			}
		}else{
			$num += 1;
			return $this->reg($num);
		}
	}

	//登陆接口
	public function login($game_id = '', $num = 1){
		if($num > 3){
            return $this->echo_cmd('login_user_error');
		}else if(empty($game_id)){
            return $this->echo_cmd('no_game_id_error');
		}
		$this->check_info();
		$this->outlogin();
		$api = "/launch_game/";//api接口
		$api_data = array(
			'member_code' => $this->game_user['username'],
			//'game_code' => $game_id,
			'game_code' => '',
			'game_type' => $this->game_type,
			'language' => 'zh-cn',
			'ip' => $this->user_ip,
			'return_url' => $this->site_url,
			'owner_id' => $this->site_id,
		);
		if(!empty($game_id)){
			$api_data['game_code'] = $this->game_info['game_code'];
		}
		$data = $this->api_query($api, $api_data);
		if(isset($data['code'])){
			if($data['code'] == '0'){
				return array('status' => 1, 'msg' => $data['data']['game_url'].'&token='.$data['data']['token']);
			}else if($data['code'] == '104'){
				//未开户，进行开户后再登录
				$reg = $this->reg();
				$num += 1;
				return $this->login($game_id, $num);
			}else{
				$error = $this->api_error_to_system_error($data['code']);
				if(!empty($error)){
					return $error;
				}else{
					$num += 1;
					return $this->login($game_id, $num);
				}
			}
		}else{
			$num += 1;
			return $this->login($game_id, $num);
		}
	}

	//退出接口，有则接入，无则直接返回成功
	public function outlogin($num = 1){
		if($num > 3){
            return $this->echo_cmd('user_outlogin_error');
		}
		$this->check_info();
		$api = "/player_sessions/member_code/".$this->game_user['username']."/";//api接口
		$api_data = array(
			'member_code' => $this->game_user['username'],
		);
		$data = $this->api_query($api, $api_data);
		if(isset($data['code'])){
			if($data['code'] == '0'){
				return array('status' => 1, 'msg' => '');
			}else{
				$error = $this->api_error_to_system_error($data['code']);
				if(!empty($error)){
					return $error;
				}else{
					$num += 1;
					return $this->outlogin($num);
				}
			}
		}else{
			$num += 1;
			return $this->outlogin($num);
		}
	}

	//转入资金接口，部分接口不是同接口互转，所以独立一个函数方便整合，若接口支持同接口互转则不使用该函数，但是必须保留函数名称，防止出错
	//泛亚转入转出接口通用一个，所以该函数可以不使用
	public function in_money($money){
		return 1;
	}

	//转出资金接口，部分接口不是同接口互转，所以独立一个函数方便整合，若接口支持同接口互转则不使用该函数，但是必须保留函数名称，防止出错
	//泛亚转入转出接口通用一个，所以该函数可以不使用
	public function out_money($money){
		return 1;
	}

    /**
     * 生成订单id
     */
    private function set_order_id()
    {
        list($use,$sec) = explode(' ',microtime());
        $Current_ms = sprintf('%.0f',(floatval($use)+floatval($sec)) * 1000);
        $this->order_id =  substr($Current_ms.'_'.$this->game_user['username'],0,20);
    }

    /** 获取订单id
     * @return mixed
     */
    private function get_order_id()
    {
        return $this->order_id;
    }

    /**转入转出资金接口
     * @param $money
     * @param $type
     * @param int $num
     * @return array|string
     */
	public function in_out_money($money, $type, $num = 1){
		if($num > 3){
            return $this->echo_cmd('in_out_money_error');
		}
		if($money <= 0){
            return $this->echo_cmd('in_out_money_number_error');
		}
		$new_money = $money * 100;//FG接口以分为单位，所以必须乘以100
		if($type == 1){
			$in_out_type = '+';
		}else{
			$in_out_type = '-';
		}
		$api = "/player_uchips/member_code/".$this->game_user['username']."/";//api接口
		$order_id =  $this->get_order_id();
		$api_data = array(
			'UserName' => $this->game_user['username'],
			'amount' => $in_out_type.$new_money,
			'externaltransactionid' => $order_id,
		);
		$data = $this->api_query($api, $api_data);
        $this->log('start',$data);
		$result = $this->check_transfer($order_id,$money);
		if($result['status'] == 1 ){
				return array('status' => 1, 'platform_order_id' => $order_id , 'data' => '' , 'money' => $result['money']);
		}else{
			$num += 1;
			return $this->in_out_money($money, $type, $num);
		}
	}

    /**查询转账接口
     * @param $order_id
     * @param int $num
     * @param string $data
     * @return array|string
     */
    public function check_transfer($order_id, $money , $num = 1 , $data = ''){
        if($num > 10){
            $this->za->login_log($this->game_user['id'],$this->game_user['site_id'],'',$money,$order_id,$data,4,$this->platform_id,$this->game_info['id'],$this->game_user['order_id']);
            return $this->echo_cmd('transfer_time_out');
        }
		$api = "/player_uchips_check/".$order_id.'/';//api接口
		$api_data = array(
			'ID' => $order_id,
		);
		$data = $this->api_query($api, $api_data);
        $this->log('end',$data);
		if(isset($data['code']) && $data['code'] == '0'){
            return array(
                'status' => 1,
                'msg' => '',
                'data' => '',
                'money' => $data['data']['amount']/100
            );
		}else{
            sleep(1);
			$num += 1;
            return $this->check_transfer($order_id , $money , $num , $data);
		}
	}

    /** 充值日志
     * @param $type
     * @param $data
     */
    public function log($type,$data)
    {
        $this->za->make_log($this->platform_id.'_'.$this->game_user['uid'],time(),$type,json_encode($data),"transfer");
    }


    //查询用户资金接口
	public function get_money($num = 1){
		if($num > 3){
            return $this->echo_cmd('get_user_money_out');
		}
		$this->check_info();
		$api = "/player_chips/member_code/".$this->game_user['username']."/";//api接口
		$api_data = array(
			'member_code' => $this->game_user['username'],
		);
		$data = $this->api_query($api, $api_data);
		if(isset($data['code'])){
			if($data['code'] == '0'){
				return array('status' => 1, 'balance' => $data['data']['balance']/100);
			}else{
				$error = $this->api_error_to_system_error($data['code']);
				if(!empty($error)){
					return $error;
				}else{
					$num += 1;
					return $this->get_money($num);
				}
			}
		}else{
			$num += 1;
			return $this->get_money($num);
		}
	}

	//获取记录接口
    public function get_log($game_id,  $end_id = '',  $end_page = '' , $num = 1,$error = ''){

        if($num > 3){
            return array('status' => -1,
                'msg' => '采集数据超时',
                'error' => $error,
                'end_id' => $end_id,
                'end_page' => $end_page,
            );
        }else if(empty($game_id)){
            return array('status' => -2,
                'msg' => '没有递交game_id',
                'error' => $error,
                'end_id' => $end_id,
                'end_page' => $end_page,
            );
        }
        $game_list = array('slot', 'hunter', 'chess', 'arcade',);
        if(!in_array($game_id, $game_list)){
            return array('status' => -3, 'msg' => '游戏不存在','error' => $error);
        }
        $api = "/agent/log_by_page/gt/".$game_id;//api接口
        if(!empty($end_id)){
            $now_api = $api.'/id/'.$end_id;
        }elseif(!empty($end_page)){
            $now_api = $api.'/page_key/'.$end_page;
        }else {
            $now_api = $api.'/start_time/'.strtotime('-1 day').'/end_time/'.time();
        }
        $api_data = array();
        $data = $this->api_query($now_api, $api_data);
        if(isset($data['code'])){
            if($data['code'] == '0'){
                $return = array('status' => 1, 'msg' => '采集成功', 'end_time' => isset($end_time) ? $end_time : $_SERVER['time'], 'end_id' => isset($end_id) ? $end_id : '', 'end_page' => isset($end_page) ? $end_page : '', 'data' => array());
                if(!empty($data['data']['data'])){
                    foreach($data['data']['data'] as $k => $v){
                        $return['data'][] = $v;
                        $fg_log_endtime = $v['time'];
                        $fg_log_endid = $v['id'];
                    }
                    $fg_log_endpage = $data['data']['page_key'];  //分页符
                    //由于没有给出总页码和数据条数，为了减少多次数据消耗，循环100次读取，获取100页数据，若数据为空则提前退出
                    for($i = 1; $i <= 100; $i++){
                        $now_api = $api.'/page_key/'.$fg_log_endpage;
                        $data = $this->api_query($now_api, $api_data);
                        if(isset($data['code']) and $data['code'] == '0' and !empty($data['data']['data'])){
                            foreach($data['data']['data'] as $k => $v){
                                $return['data'][] = $v;
                                $fg_log_endtime = $v['time'];
                                $fg_log_endid = $v['id'];
                            }
                            $fg_log_endpage = $data['data']['page_key'];
                        }else{
                            //防止接口请求失败丢失数据，只要抓取失败就停止循环
                            break;
                        }
                    }
                    $return['end_time'] = $fg_log_endtime;
                    $return['end_id'] = $fg_log_endid;
                    $return['end_page'] = $fg_log_endpage;
                }
                return $return;
            }else{
                $num += 1;
                return $this->get_log($game_id, $end_page, $end_id, $num , $data['msg']);
            }
        }else{
            $num += 1;
            return $this->get_log($game_id, $end_page, $end_id , $num , $data['msg']);
        }
    }

	//获取游戏接口
	public function get_game($game_id = '', $num = 1){
		if($num > 3){
            return $this->echo_cmd('get_game_time_out');
		}
		$api = "/games/game_type/".$this->game_type."/language/zh-cn/";//要抓取数据的页面地址
		$api_data = array();
		$data = $this->api_query($api, $api_data);
		if(isset($data['code'])){
			if($data['code'] == '0'){
				$game_list = array();
				foreach($data['data'] as $k => $v){
					$game_list[] = array(
						'id' => $v['gamecode'],
						'name' => $v['name'],
						'pic' => $v['img'],
					);
				}
				return array('status' => 1, 'msg' => $game_list);
			}else{
				$num += 1;
				return $this->get_game($game_id, $num);
			}
		}else{
			$num += 1;
			return $this->get_game($game_id, $num);
		}
	}

	//用户进入游戏一键转入金额接口，整合多接口使用同一函数，如未指定进入的游戏，则进入大厅
	public function user_in_game($money = 0, $game_id = '', $step = 1, $data = array(), $num = 1){
		if($num > 3){
            return $this->echo_cmd('in_money_login_time_out');
		}
		if($step == 1){
			$login = $this->login($game_id);
			if($login['status'] == 1){
				$data = $login;
				$step = 2;
			}else{
				$num += 1;
				return $this->user_in_game($money, $game_id, $step, $data, $num);
			}
		}
		$data['money'] = 0;
        $data['orders_number'] = '';
		if($step == 2){
			if($money > 0){
                $amount = $this->check_money($money);
                $this->set_order_id();
                $in_money = $this->in_out_money($amount['money'], 1);
				if($in_money['status'] == 1){
					$data['money'] = $money;
                    $data['orders_number'] = $in_money['platform_order_id'];
                    $this->user->update1($this->game_user['id'], array(
                            'balance' =>array(
                                '+' =>$amount['balance'],
                            )
                        )
                    );
				}else{
					$num += 1;
					return $this->user_in_game($money, $game_id, $step, $data, $num);
				}
			}
		}
		return $data;
	}

	//用户退出游戏一键转出金额接口，整合多接口使用同一函数，生成新登陆地址可以退出已登陆用户
	public function user_out_game($user_money = 0, $step = 1, $num = 1){
		if($num > 3){
            return $this->echo_cmd('out_money_login_time_out');
		}
		if($step == 1){
			$login = $this->outlogin();
			if($login['status'] != 1){
				$num += 1;
				return $this->user_out_game($user_money, $step, $num);
			}
			$step = 2;
		}
		if($step == 2){
			if($user_money == 0){
				$money = $this->get_money();
				if($money['status'] != 1){
					$num += 1;
                    return $this->user_out_game($user_money, 1, $num);
				}
				$user_money = $money['balance'];
			}
			if($user_money > 0){
				//查询判断是否有余额需要转出并转出整数部分
                $this->set_order_id();
				$out_money = $this->in_out_money($user_money, 2);
				if($out_money['status'] != 1){
					$num += 1;
                    return $this->user_out_game($user_money, 1, $num);
				}
                $this->user->update1($this->game_user['id'], array(
                        'balance' =>array(
                            '-' =>$this->game_user['balance'],
                        )
                    )
                );
			}
		}
		$return = array(
			'status' => 1,
			'money' => $user_money+$this->game_user['balance'],
            'orders_number' => isset($out_money['platform_order_id']) ? $out_money['platform_order_id'] : '',
		);
		return $return;
	}

	//试玩接口，暂时不使用
	public function demo($game_id = '', $num = 1){
		if($num > 3){
            return $this->echo_cmd('demo_time_out');
		}else if(empty($game_id)){
            return $this->echo_cmd('no_game_id_error');
		}
		$this->check_info();
		$api = "/launch_free_game/";//要抓取数据的页面地址
		$api_data = array(
			'game_code' => $game_id,
			'game_type' => $this->game_type,
			'language' => 'zh-cn',
			'ip' => $this->user_ip,
			'return_url' => $this->site_url,
		);
		$data = $this->api_query($api, $api_data);
		if(isset($data['code'])){
			if($data['code'] == '0'){
				return array('status' => 1, 'msg' => $data['data']['game_url'].'&token='.$data['data']['token']);
			}else{
				$error = $this->api_error_to_system_error($data['code']);
				if(!empty($error)){
					return $error;
				}else{
					$num += 1;
					return $this->demo($game_id, $num);
				}
			}
		}else{
			$num += 1;
			return $this->demo($game_id, $num);
		}
	}

    /** 公共打印error方法
     * @param $name  code 下标
     */
    private function echo_cmd($data)
    {
        switch($this->return_type)
        {
            case 1:
                if(is_array($data))
                {
                    echo  json_encode($data);exit;
                }
                if(!empty($this->error->code($data)))
                {
                    echo  json_encode($this->error->code($data));exit;
                }else
                {
                    echo  json_encode('不存在的error');exit;
                }
                break;
            case 2:
                if(is_array($data))
                {
                    return  $data;
                }
                if(!empty($this->error->code($data)))
                {
                    return  $this->error->code($data);
                }else
                {
                    return  array("status" => 0,"msg" => '不存在的error');
                }
                break;
            default:
                return 'unknown return type';
        }
    }

}
?>