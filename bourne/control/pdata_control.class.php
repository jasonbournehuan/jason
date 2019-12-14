<?php
!defined('FRAMEWORK_PATH') && exit('FRAMEWORK_PATH not defined.');
include BBS_PATH.'control/common_control.class.php';
//所有接口获取投注数据
class pdata_control extends common_control {
    private $date_time;  //current date
    private $data_count = 0;  //
    private $on_name;        //采集名称
    private $end_log_id;
    private $cache_key;
    private $detailed_info;  //游戏名称
    private $data_c_type;
    private $result_username;
    private $result_gamesId;
    private $money;
    private $win_money;
    private $bet_money;
    private $oid;
    private $error_result = array();
    private $platform_id;
	function __construct() {
		parent::__construct();
		$this->c('endlog');
        $this->c('cache_redis');
        $this->cache_redis->select($this->conf['redis_db']);
        $this->date_time = date('Y-m-d H:i:s', $_SERVER['time']);
        $this->current_time = $_SERVER['time'];
	}

	//公共代码开始
	//按需处理API列表，将键名修改为站点ID

	function api_list(){
		$this->_api_list = array();
		$api_list = $this->mcache->read('api');
		if(!empty($api_list)){
			foreach($api_list as $k => $v){
				$this->_api_list[$v['site_id']] = $v;
			}
		}
	}
	//清除缓存重新加载
    public function reload($games)
    {
        $this->mcache->clear($games);
        $this->mcache->read($games);
    }

	//按需处理游戏列表，将键名修改为游戏信息
	function game_list($key_name = 'id',$platform_id=''){
		$this->_games_list = array();
		$games_list = $this->mcache->read('games');
		if(!empty($games_list)){
		    if(!empty($platform_id)){
                foreach($games_list as $k => $v){
                    if($v['platform_id'] == $platform_id){
                        $this->_games_list[$v[$key_name]] = $v;
                    }
                }
            }else{
                foreach($games_list as $k => $v){
                        $this->_games_list[$v[$key_name]] = $v;
                }
            }
		}
	}

    /**整合data
     * @param $platform_id  平台id
     */
    public function data_c($platform_id)
    {
        if (!empty($this->data_c_type))
        {
            $this->api_list();
            $this->c('user');
            $this->game_list($this->data_c_type,$platform_id);
        }else{
            $this->api_list();
            $this->c('user');
        }

    }

	//因为输出内容为DOS窗口，所以转换一下编码，否则是显示乱码
	function cmd_echo($info,$code=''){
		//echo iconv("UTF-8", "GB2312//IGNORE", $info);
		echo $info;
		if($code == 1){
		    return $code;
        }
        exit;
	}
    /* type_id :  1 代表|  2 代表时间  */
	public function end_log_data($redis_key,$log_id,$type_id='')
    {
        if($redis_key == "" && $log_id == "")
        {
            echo  'require redis_key or log_id';
            exit;
        }
        $end_log_data = '';
        $cache_log =  json_decode($this->cache_redis->kGet($redis_key),true);
        if(!empty($cache_log) && $cache_log != 'false')
        {
            $end_log_data = $cache_log;
        }else{
            $end_log_data = $this->endlog->get($log_id);
        }
        return  $end_log_data;
    }

    /**
     * 检查必须函数
     */
    public function check_Handle($data)
    {
        if(empty($this->on_name) )
        {
            $this->cmd_echo("require on_name parameter");
        }

        if(empty($this->data_c_type))
        {
            $this->cmd_echo("require data_c_type parameter");
        }

        if(empty($this->detailed_info))
        {
            $this->cmd_echo("require detailed_info parameter");
        }

        if(empty($this->result_username) || !array_key_exists($this->result_username,end($data)))
        {
            $this->cmd_echo("require result_username parameter");
        }

        if(empty($this->result_gamesId) || !array_key_exists($this->result_gamesId,end($data)))
        {
            $this->cmd_echo("require result_gamesId parameter");
        }

        if(empty($this->money) || !array_key_exists($this->money,end($data)))
        {
            $this->cmd_echo("require money parameter");
        }

        if(empty($this->win_money) || !array_key_exists($this->win_money,end($data)))
        {
            $this->cmd_echo("require win_money parameter");
        }

        if(empty($this->bet_money) || !array_key_exists($this->bet_money,end($data)))
        {
            $this->cmd_echo("require bet_money parameter");
        }

        if(empty($this->oid) || !array_key_exists($this->oid,end($data)))
        {
            $this->cmd_echo("require oid parameter");
        }
    }


    /**
     * @param $data  数据
     * @param string $classname 类名
     */
    private function Handle($data,$classname="",$last_data,$code = '')
    {
        if($data['status'] == 1)
        {
            if(!empty($data['data']) && is_array($data['data']))
            {
                $this->platform_id = $this->$classname->platform_id;
                $this->check_Handle($data['data']);
                $this->data_c($this->platform_id);
                $result    = $this->order_data($data['data'],$classname);
                $in_data   = $result['in_data'];
                $user_list = $result['user_list'];
                if(!empty($in_data)) {
                    $this->insert_order($in_data,$user_list);
                    //保存page_key和id记录
                    if(!empty($result['games_id']))
                    {
                        $this->reload("games");
                    }
                    $this->insert_log($last_data);
                    $this->insert_err_log($this->error_result);
                    return $this->cmd_echo($this->date_time . " 采集". $this->on_name. $this->data_count . "条！\r\n",1);
                }else{
                    $this->insert_log($last_data);
                    $this->insert_err_log($this->error_result);
                    return $this->cmd_echo($this->date_time." 采集".$this->on_name."成功，没有匹配数据！\r\n");
                }
            }else{
                 $this->insert_log($last_data);
                 return $this->cmd_echo($this->date_time." 采集".$this->on_name."成功，没有新数据！\r\n");
            }
        }
        else
        {
            return $this->cmd_echo($this->date_time." 采集".$this->on_name."失败，返回状态:".$data['msg']."！\r\n"."失败原因:".$data['error']);
        }
    }

    /**
     * @param $data      数据
     * @param $classname 类名
     * @return array
     */
    private function order_data($data,$classname)
    {
        $in_data  = $return = $user_list =  array();

        foreach($data as $key => $value)
        {
            $old_username  =  $this->$classname->de_username($value[$this->result_username]);
            $site_id       =  isset($old_username['0']) ?  $old_username['0']  :  "";
            $uid           =  isset($old_username['1']) ?  $old_username['1']  :  "";
            if(!empty($this->_api_list[$site_id]))
            {
                $table_id = $this->_api_list[$site_id]['service_id'];
                $user_list[] = $table_id.'_user-uid-'.$uid;
                //判断游戏id是否存在
                if(empty($this->_games_list[$value[$this->result_gamesId]]))
                {
                    $game_result = array(
                        "platform_id" => $this->platform_id,
                        "game_code" => '',
                        "game_name_cn" => null,
                        'game_name_en' => NULL,
                        'game_name_tw' => NULL,
                        'pic' => '',
                        "module_id" =>'',
                        "type_id"  => '1',//默认1
                        "status" => 2,
                        "query_info" => "",
                        "screen" => 2,
                        "pc" => 1,
                        "wap" =>1,
                        "paixu" =>1
                    );
                    $game_result[$this->data_c_type] = $value[$this->result_gamesId];
                    $this->c("games");
                    $return['games_id'] = $this->games->add($game_result);
                    $this->_games_list[$value[$this->result_gamesId]] = $game_result;
                    $this->_games_list[$value[$this->result_gamesId]]['id'] = $return['games_id'];
                    unset($game_result);
                    $this->error_result[$table_id][] = array(
                        "pid" => $this->end_log_id,
                        "created_at" => time(),
                        "infos"  => json_encode($value),
                        'error_id' => 2
                    );
                }
                $detailed_info = $this->detailed_info;
                $detailed_info .= '-'.$this->_games_list[$value[$this->result_gamesId]]['game_name_cn'];
                $gameId = isset($this->_games_list[$value[$this->result_gamesId]]['id']) ? $this->_games_list[$value[$this->result_gamesId]]['id'] : "";
                $in_data[] = array(
                    "uid" => $uid, //用户id
                    "username" => "", //用户名
                    "site_id" => $site_id, //归属网站id
                    "platform_id" => $this->platform_id, //归属平台id
                    "game_id" => $gameId , //归属游戏id
                    "money" => $value[$this->money],  //投注金额
                    "win_money" => $value[$this->win_money], //盈利金额
                    "bet_money" => $value[$this->bet_money], //有效投注金额
                    "detailed" => $detailed_info ,  //游戏详细信息
                    "infos" => json_encode($value),//原始数据
                    "oid" => $value[$this->oid],//平台注单id
                    "add_time" => $this->current_time,//记录时间
                    "service_id" => $this->_api_list[$site_id]['service_id'],//数据归属服务器
                    "now_uid" => 0,
                    "type_id" => $this->_games_list[$value[$this->result_gamesId]]['type_id'],
                    "platform_and_type" => $this->platform_id.'-'.$this->_games_list[$value[$this->result_gamesId]]['type_id'],
                    "table_id" => $table_id,//临时字段，后面需要销毁
                    "user_key" => $table_id.'_user-uid-'.$uid,//临时字段，后面需要销毁
                );
            }
            else
            {
                $this->error_result['0'][] = array(
                    "pid" => $this->end_log_id,
                    "created_at" => time(),
                    "infos"  => json_encode($value),
                    'error_id' => 1
                );
            }
        }
        $return['in_data'] = $in_data;
        $return['user_list'] = $user_list;
        return $return;
    }

    /**
     * @param $in_data    数据
     * @param $user_list  账号数据
     */
    private function insert_order($in_data,$user_list)
    {
        $db_data  = array();
        $user = $this->user->get($user_list);
        unset($user_list);
        foreach ($in_data as $key => $value) {
            //判断用户是否存在
            if (empty($user[$value['user_key']])) {
                $this->error_result[$value['table_id']][] = array(
                    "pid" => $this->end_log_id,
                    "created_at" => $this->current_time,
                    "infos" => $value['infos'],
                    'error_id' => 3
                );
                unset($in_data[$key]);
                continue;
            }
            $table_id = $value['table_id'];
            unset($value['table_id']);
            $value['username'] = $user[$value['user_key']]['old_username'];
            $value['now_uid'] = $user[$value['user_key']]['id'];
            unset($value['user_key']);
            $db_data[$table_id][] = $value;
            unset($in_data[$key]);
        }
        unset($user);
        foreach ($db_data as $key => $value) {
            $this->c('order');
            $this->order->table = $key.'_order';
            $this->order->add_list($value);
            $this->data_count = count($value);
        }
    }

    /**
     * @param $last_data 数据
     */
    private function insert_log($last_data)
    {
        $this->endlog->update($last_data['id'], $last_data);
        $this->cache_redis->kSet($this->cache_key ,json_encode($last_data));
    }

    private function insert_err_log($data)
    {
        if (!empty($data))
        {
            $this->c('error_data');
            foreach($data as $key => $value)
            {
                $this->error_data->table = $key."_error_data";
                $this->error_data->add_list($value);
            }
        }
    }

    /** 业务数据开始
     * 泛亚投注数据获取与处理
     */
	function on_fanya(){
        $this->c('fanya');
	    $this->end_log_id           = 4001;
	    $this->cache_key            = "fanya_".$this->end_log_id;
        $end_log_data                   = $this->end_log_data($this->cache_key,$this->end_log_id);
        if(!empty($end_log_data['up_time']) )
        {
            $start_time =   $end_log_data['up_time'];
            $end_time   = $start_time+3600;
        }else{
            $start_time = $_SERVER['time'] - 86400;
            $end_time   = $start_time+3600;
        }
        if($end_time > $_SERVER['time']-180)
        {
            $end_time   = $_SERVER['time']-180;
        }
	    $data                       = $this->fanya->get_log($start_time+1,$end_time);
        $last_data = array(
            'id'            => $this->end_log_id,
            'up_time'       => $data['end_time']
        );
        $this->on_name              = "泛亚";
        $this->data_c_type          = "query_info";
        $this->detailed_info        = "泛亚-电竞-";
        $this->result_username      = "UserName";
        $this->result_gamesId       = "CateID";
        $this->money                = "BetAmount";
        $this->win_money            = "Money";
        $this->bet_money            = "BetMoney";
        $this->oid                  = "OrderID";
        $this->Handle($data,"fanya",$last_data);
	}
    /**
     * 761投注数据获取与处理
     */
	function on_api761(){
        $this->c('api761');
        $this->end_log_id           = 2001;
        $this->cache_key            = "api761_".$this->end_log_id;
        $end_log_data                   = $this->end_log_data($this->cache_key,$this->end_log_id);
        if(!empty($end_log_data['up_time']) )
        {
            $start_time =   $end_log_data['up_time'];
            $end_time   = $start_time+3600;
        }else{
            $start_time = $_SERVER['time'] - 86400;
            $end_time   = $start_time+3600;
        }
        if($end_time > $_SERVER['time']-180)
        {
            $end_time = $_SERVER['time']-180;
        }
        $data                       = $this->api761->get_log($start_time+1,$end_time);
        if($data['status'] == 1)
        {
            if(!empty($data['data']) && is_array($data['data']))
            {
                foreach($data['data'] as $key => $value)
                {
                    $data['data'][$key]['kind'] =  $this->api761->game_code($data['data'][$key]['kind']);
                    $data['data'][$key]['allput'] =  $value['allput']/10000;
                    $data['data'][$key]['chg'] =  $value['chg']/10000;
                    $data['data'][$key]['realput'] =  $value['realput']/10000;
                }
            }
        }
        $last_data = array(
            'id'            => $this->end_log_id,
            'up_time'       => $data['end_time']
        );
        $this->on_name              = "爱棋牌";
        $this->data_c_type          = "module_id";
        $this->detailed_info        = "761";
        $this->result_username      = "acc";
        $this->result_gamesId       = "kind";
        $this->money                = "realput";
        $this->win_money            = "chg";
        $this->bet_money            = "realput";
        $this->oid                  = "sessionid";
        $this->Handle($data,"api761",$last_data);

	}

    /**
     * fg捕鱼投注数据获取与处理
     */
	function on_fg3(){
        $this->c('fg');
        $this->end_log_id           = 1003;
        $this->cache_key            = "fg_hunter_".$this->end_log_id ;
        $end_log_data                   = $this->end_log_data($this->cache_key,$this->end_log_id);
        if(!empty($end_log_data))
        {
            $last_data = explode('|',$end_log_data['log_end_info']);
            $end_log_page =  isset($last_data[0]) ? $last_data[0]  : "";
            $end_log_id =  isset($last_data[1]) ? $last_data[1]  : "";
        }
        if(empty($end_log_page))
        {
            $end_log_page = '';
        }
        if(empty($end_log_id))
        {
            $end_log_id = '';
        }
        $data                       = $this->fg->get_log('hunter',$end_log_id,$end_log_page);
       //print_r($data);exit;
        $last_data = array(
            'id'            => $this->end_log_id,
            'log_end_info'  => $data['end_page'] . '|' . $data['end_id'],
            'up_time'       => $this->current_time
        );
        $this->on_name              = "FG捕鱼";
        $this->data_c_type          = "module_id";
        $this->detailed_info        = "FG-捕鱼";
        $this->result_username      = "player_name";
        $this->result_gamesId       = "game_id";
        $this->money                = "all_bets";
        $this->win_money            = "result";
        $this->bet_money            = "all_bets";
        $this->oid                  = "id";
        $this->Handle($data,"fg",$last_data);

	}

    /**
     * fg棋牌投注数据获取与处理
     */
	function on_fg2(){
        $this->c('fg');
	    $this->end_log_id           = 1002;
        $this->cache_key            = "fg_chess_".$this->end_log_id ;
        $end_log_data                   = $this->end_log_data($this->cache_key,$this->end_log_id);
        if(!empty($end_log_data))
        {
            $last_data = explode('|',$end_log_data['log_end_info']);
            $end_log_page =  isset($last_data[0]) ? $last_data[0]  : "";
            $end_log_id =  isset($last_data[1]) ? $last_data[1]  : "";
        }
        if(empty($end_log_page))
        {
            $end_log_page = '';
        }
        if(empty($end_log_id))
        {
            $end_log_id = '';
        }
        $data                       = $this->fg->get_log('chess',$end_log_id,$end_log_page);
        $last_data = array(
            'id'            => $this->end_log_id,
            'log_end_info'  => $data['end_page'] . '|' . $data['end_id'],
            'up_time'       => $this->current_time
        );
        $this->on_name              = "FG棋牌";
        $this->data_c_type          = "module_id";
        $this->detailed_info        = "FG-棋牌";
        $this->result_username      = "player_name";
        $this->result_gamesId       = "game_id";
        $this->money                = "all_bets";
        $this->win_money            = "result";
        $this->bet_money            = "all_bets";
        $this->oid                  = "id";
        $this->Handle($data,"fg",$last_data);

	}

    /**
     * fg老虎机投注数据获取与处理
     */
	function on_fg1(){
        $this->c('fg');
        $this->end_log_id           = 1001;
        $this->cache_key            = "fg_slot_".$this->end_log_id ;
        $end_log_data                   = $this->end_log_data($this->cache_key,$this->end_log_id);
        if(!empty($end_log_data))
        {
            $last_data = explode('|',$end_log_data['log_end_info']);
            $end_log_page =  isset($last_data[0]) ? $last_data[0]  : "";
            $end_log_id =  isset($last_data[1]) ? $last_data[1]  : "";
        }
        if(empty($end_log_page))
        {
            $end_log_page = '';
        }
        if(empty($end_log_id))
        {
            $end_log_id = '';
        }
        $data                       = $this->fg->get_log('slot',$end_log_id,$end_log_page);
        //print_r($data);exit;
        $last_data = array(
            'id'            => $this->end_log_id,
            'log_end_info'  => $data['end_page'] . '|' . $data['end_id'],
            'up_time'       => $this->current_time
        );
        $this->on_name              = "FG电子";
        $this->data_c_type          = "module_id";
        $this->detailed_info        = "FG-电子";
        $this->result_username      = "player_name";
        $this->result_gamesId       = "game_id";
        $this->money                = "all_bets";
        $this->win_money            = "result";
        $this->bet_money            = "all_bets";
        $this->oid                  = "id";
        $this->Handle($data,"fg",$last_data);

	}

    /**
     * fg街机投注数据获取与处理
     */
	function on_fg4(){
        $this->c('fg');
        $this->end_log_id           = 1004;
        $this->cache_key            = "fg_arcade_".$this->end_log_id ;
        $end_log_data                   = $this->end_log_data($this->cache_key,$this->end_log_id);
        if(!empty($end_log_data))
        {
            $last_data = explode('|',$end_log_data['log_end_info']);
            $end_log_page =  isset($last_data[0]) ? $last_data[0]  : "";
            $end_log_id =  isset($last_data[1]) ? $last_data[1]  : "";
        }
        if(empty($end_log_page))
        {
            $end_log_page = '';
        }
        if(empty($end_log_id))
        {
            $end_log_id = '';
        }
        $data                       = $this->fg->get_log('arcade',$end_log_id,$end_log_page);
        $last_data = array(
            'id'            => $this->end_log_id,
            'log_end_info'  => $data['end_page'] . '|' . $data['end_id'],
            'up_time'       => $this->current_time
        );
        $this->on_name              = "FG电子";
        $this->data_c_type          = "module_id";
        $this->detailed_info        = "FG-电子";
        $this->result_username      = "player_name";
        $this->result_gamesId       = "game_id";
        $this->money                = "all_bets";
        $this->win_money            = "result";
        $this->bet_money            = "all_bets";
        $this->oid                  = "id";
        $this->Handle($data,"fg",$last_data);

	}

    /**
     * 开元投注数据获取与处理
     */
	function on_ky(){
        $this->c('ky');
	    $this->end_log_id           = 5001;
        $this->cache_key            = "ky_".$this->end_log_id;
        $end_log_data                   = $this->end_log_data($this->cache_key,$this->end_log_id);
        if(!empty($end_log_data['up_time']) )
        {
            $start_time =   $end_log_data['up_time'];
            $end_time   = $start_time+1800;
        }else{
            $start_time = $_SERVER['time'] - 86400;
            $end_time   = $start_time+1800;
        }
        if($end_time > $_SERVER['time']-180)
        {
            $end_time = $_SERVER['time']-180;
        }
	    $data                       = $this->ky->get_log('',$start_time+1,$end_time);
        //print_r($data);exit;
        if($data['status'] == 1)
        {
            if(!empty($data['data']) && is_array($data['data']))
            {
                $new_result_data = array();
                foreach($data['data']['Accounts'] as $key => $value)
                {
                    $new_result_data[] = array(
                        "GameID" => $data['data']['GameID'][$key],
                        "Accounts" => explode('_',$data['data']['Accounts'][$key])[1],
                        "ServerID" => $data['data']['ServerID'][$key],
                        "KindID" => $data['data']['KindID'][$key],
                        "TableID" => $data['data']['TableID'][$key],
                        "ChairID" => $data['data']['ChairID'][$key],
                        "UserCount" => $data['data']['UserCount'][$key],
                        "CellScore" => $data['data']['CellScore'][$key],
                        "AllBet" => $data['data']['AllBet'][$key],
                        "Profit" => $data['data']['Profit'][$key],
                        "Revenue" => $data['data']['Revenue'][$key],
                        "GameStartTime" => $data['data']['GameStartTime'][$key],
                        "GameEndTime" => $data['data']['GameEndTime'][$key],
                        "CardValue" => $data['data']['CardValue'][$key],
                        "ChannelID" => $data['data']['ChannelID'][$key],
                        "LineCode" => $data['data']['LineCode'][$key],
                    );
                }
                $data['data'] = $new_result_data;
            }
        }
        $last_data = array(
            'id'            => $this->end_log_id,
            'up_time'       => $data['end_time']
        );
        $this->on_name              = "开元";
        $this->data_c_type          = "module_id";
        $this->detailed_info        = "开元";
        $this->result_username      = "Accounts";
        $this->result_gamesId       = "KindID";
        $this->money                = "AllBet";
        $this->win_money            = "Profit";
        $this->bet_money            = "CellScore";
        $this->oid                  = "GameID";
        $this->Handle($data,"ky",$last_data);

	}

    /**
     * BBIN电子投注数据获取与处理
     */
    function on_bbin1(){
        $this->c('bbin');
        $this->end_log_id           = 3011;
        $this->cache_key            = "bbin_get_log_cache_".$this->end_log_id;
        $data                       = $this->bbin->get_log($this->end_log_id,5,1);
        $last_data = array(
            'id'            => $this->end_log_id,
            'up_time'       => $data['end_time']
        );
        $this->on_name              = "BBIN电子壹";
        $this->data_c_type          = "game_code";
        $this->detailed_info        = "BBIN电子-壹";
        $this->result_username      = "UserName";
        $this->result_gamesId       = "GameType";
        $this->money                = "BetAmount";
        $this->win_money            = "Payoff";
        $this->bet_money            = "Commissionable";
        $this->oid                  = "WagersID";
        $this->Handle($data,"bbin",$last_data);
    }

    /**
     * BBIN电子投注数据获取与处理
     */
    function on_bbin1_2(){
        $this->c('bbin');
        $this->end_log_id           = 3012;
        $this->cache_key            = "bbin_get_log_cache_".$this->end_log_id;
        $data                       = $this->bbin->get_log($this->end_log_id,5,2);
        //print_r($data);exit;
        $last_data = array(
            'id'            => $this->end_log_id,
            'up_time'       => $data['end_time']
        );
        $this->on_name              = "BBIN电子贰";
        $this->data_c_type          = "game_code";
        $this->detailed_info        = "BBIN电子-贰";
        $this->result_username      = "UserName";
        $this->result_gamesId       = "GameType";
        $this->money                = "BetAmount";
        $this->win_money            = "Payoff";
        $this->bet_money            = "Commissionable";
        $this->oid                  = "WagersID";
        $this->Handle($data,"bbin",$last_data);

    }

    /**
     * BBIN电子投注数据获取与处理
     */
    function on_bbin1_3(){
        $this->c('bbin');
        $this->end_log_id           = '3013';
        $this->cache_key            = "bbin_get_log_cache_".$this->end_log_id;
        $data                       = $this->bbin->get_log($this->end_log_id,5,3);
        //print_r($data);exit;
        $last_data = array(
            'id'            => $this->end_log_id,
            'up_time'       => $data['end_time']
        );
        $this->on_name              = "BBIN电子叁";
        $this->data_c_type          = "game_code";
        $this->detailed_info        = "BBIN电子-叁";
        $this->result_username      = "UserName";
        $this->result_gamesId       = "GameType";
        $this->money                = "BetAmount";
        $this->win_money            = "Payoff";
        $this->bet_money            = "Commissionable";
        $this->oid                  = "WagersID";
        $this->Handle($data,"bbin",$last_data);
    }

    /**
     * BBIN电子投注数据获取与处理
     */
    function on_bbin1_5(){
        $this->c('bbin');
        $this->end_log_id           = '3015';
        $this->cache_key            = "bbin_get_log_cache_".$this->end_log_id;
        $data                       = $this->bbin->get_log($this->end_log_id,5,5);
       // print_r($data);exit;
        $last_data = array(
            'id'            => $this->end_log_id,
            'up_time'       => $data['end_time']
        );
        $this->on_name              = "BBIN电子伍";
        $this->data_c_type          = "game_code";
        $this->detailed_info        = "BBIN电子-伍";
        $this->result_username      = "UserName";
        $this->result_gamesId       = "GameType";
        $this->money                = "BetAmount";
        $this->win_money            = "Payoff";
        $this->bet_money            = "Commissionable";
        $this->oid                  = "WagersID";
        $this->Handle($data,"bbin",$last_data);

    }

    /**
     * BBIN真人投注数据获取与处理
     */
	function on_bbin5(){
        $this->c('bbin');
        $this->end_log_id           = 3005;
        $this->cache_key            = "bbin_get_log_cache_".$this->end_log_id;
        $data                       = $this->bbin->get_log($this->end_log_id,3);
        // print_r($data);exit;
        $last_data = array(
            'id'            => $this->end_log_id,
            'up_time'       => $data['end_time']
        );
        $this->on_name              = "BBIN视讯";
        $this->data_c_type          = "game_code";
        $this->detailed_info        = "BBIN-视讯";
        $this->result_username      = "UserName";
        $this->result_gamesId       = "GameType";
        $this->money                = "BetAmount";
        $this->win_money            = "Payoff";
        $this->bet_money            = "Commissionable";
        $this->oid                  = "WagersID";
        $this->Handle($data,"bbin",$last_data);
	}

    /**
     * BBIN体育投注数据获取与处理
     */
	function on_bbin6(){
        $this->c('bbin');
        $this->end_log_id           = 3006;
        $api                        = "/WagersRecordBy1";
        $this->cache_key            = "bbin_get_log_cache_".$this->end_log_id;
        $data                       = $this->bbin->get_sports($this->end_log_id,$api);
        // print_r($data);exit;
        $last_data = array(
            'id'            => $this->end_log_id,
            'up_time'       => $data['end_time']
        );
        $this->on_name              = "BBIN体育";
        $this->data_c_type          = "game_code";
        $this->detailed_info        = "BBIN-体育";
        $this->result_username      = "UserName";
        $this->result_gamesId       = "GameType";
        $this->money                = "BetAmount";
        $this->win_money            = "Payoff";
        $this->bet_money            = "Commissionable";
        $this->oid                  = "WagersID";
        $this->Handle($data,"bbin",$last_data);

	}

    /**
     * BBIN New 体育投注数据获取与处理  还没接取这个游戏先不适用
     */
    function on_bbin631(){
        $this->c('bbin');
        $this->end_log_id           = 3631;
        $api                        = "/WagersRecordBy31";
        $this->cache_key            = "bbin_get_log_cache_".$this->end_log_id;
        $data                       = $this->bbin->get_sports($this->end_log_id,$api);
        // print_r($data);exit;
        $last_data = array(
            'id'            => $this->end_log_id,
            'up_time'       => $data['end_time']
        );
        $this->on_name              = "BBI NNew 体育";
        $this->data_c_type          = "game_code";
        $this->detailed_info        = "BBIN-New 体育";
        $this->result_username      = "UserName";
        $this->result_gamesId       = "GameType";
        $this->money                = "BetAmount";
        $this->win_money            = "Payoff";
        $this->bet_money            = "Commissionable";
        $this->oid                  = "WagersID";
        $this->Handle($data,"bbin",$last_data);

    }

    /**
     * BBIN捕鱼大师数据获取与处理
     */
    function on_bbin38(){
        $this->c("bbin");
	    $this->end_log_id           = 3038;
	    $api                        = "/WagersRecordBy38";
        $this->cache_key            = "bbin_get_log_cache_".$this->end_log_id;
	    $data                       = $this->bbin->get_fish2($this->end_log_id,$api);
         //print_r($data);exit;
        $last_data = array(
            'id'            => $this->end_log_id,
            'up_time'       => $data['end_time']
        );
        $this->on_name              = "BBIN捕鱼大师";
        $this->data_c_type          = "game_code";
        $this->detailed_info        = "BBIN-捕鱼";
        $this->result_username      = "UserName";
        $this->result_gamesId       = "GameType";
        $this->money                = "BetAmount";
        $this->win_money            = "Payoff";
        $this->bet_money            = "Commissionable";
        $this->oid                  = "WagersID";
        $this->Handle($data,"bbin",$last_data);

    }

    /**
     * BBIN捕鱼达人数据获取与处理
     */
    function on_bbin30(){
        $this->c("bbin");
        $this->end_log_id           = 3030;
        $api                        = "/WagersRecordBy30";
        $this->cache_key            = "bbin_get_log_cache_".$this->end_log_id;
        $data                       = $this->bbin->get_fish($this->end_log_id ,$api);
        //print_r($data);exit;
        $last_data = array(
            'id'            => $this->end_log_id,
            'up_time'       => $data['end_time']
        );
        $this->on_name              = "BBIN捕鱼达人";
        $this->data_c_type          = "game_code";
        $this->detailed_info        = "BBIN-捕鱼";
        $this->result_username      = "UserName";
        $this->result_gamesId       = "GameType";
        $this->money                = "BetAmount";
        $this->win_money            = "Payoff";
        $this->bet_money            = "Commissionable";
        $this->oid                  = "WagersID";
        $this->Handle($data,"bbin",$last_data);

    }


    /**
     * bg电子数据处理
     */
    public function on_bg1()
    {
        $this->c('bg');
        $this->end_log_id           = '6001';
        $this->cache_key            = "bg_".$this->end_log_id;
        $end_log_data                   = $this->end_log_data($this->cache_key,$this->end_log_id);
        if(!empty($end_log_data['up_time']) )
        {
            $start_time =   $end_log_data['up_time'];
            $end_time   = $start_time+3600;
        }else{
            $start_time = $_SERVER['time'] - 86400;
            $end_time   = $start_time+3600;
        }
        if($end_time > $_SERVER['time']-180)
        {
            $end_time = $_SERVER['time']-180;
        }
        $data                       = $this->bg->get_solt('',$start_time+1,$end_time+1);
        //print_r($data);exit;
        $last_data = array(
            'id'            => $this->end_log_id,
            'up_time'       => $data['end_time']
        );
        $this->on_name              = "BG电子";
        $this->data_c_type          = "module_id";
        $this->detailed_info        = "bg-电子";
        $this->result_username      = "loginId";
        $this->result_gamesId       = "gameId";
        $this->money                = "bet";
        $this->win_money            = "win";
        $this->bet_money            = "bet";
        $this->oid                  = "roundId";
        $this->Handle($data,"bg",$last_data);
    }

    /**
     * bg捕鱼大师数据处理
     */
    public function on_bg_fish_master()
    {
        $this->c('bg');
        $this->end_log_id           = '6030';
        $this->cache_key            = "bg_".$this->end_log_id;
        $end_log_data                   = $this->end_log_data($this->cache_key,$this->end_log_id);
        if(!empty($end_log_data['up_time']) )
        {
            $start_time =   $end_log_data['up_time'];
            $end_time   = $start_time+3600;
        }else{
            $start_time = $_SERVER['time'] - 86400;
            $end_time   = $start_time+3600;
        }
        if($end_time > $_SERVER['time']-180)
        {
            $end_time   = $_SERVER['time']-180;
        }
        $data                       = $this->bg->get_fish(105,$start_time+60,$end_time);
        //print_r($data);exit;
        $last_data = array(
            'id'            => $this->end_log_id,
            'up_time'       => $data['end_time']
        );
        $this->on_name              = "BG捕鱼大师";
        $this->data_c_type          = "module_id";
        $this->detailed_info        = "bg-捕鱼";
        $this->result_username      = "loginId";
        $this->result_gamesId       = "gameType";
        $this->money                = "betAmount";
        $this->win_money            = "payout";
        $this->bet_money            = "validAmount";
        $this->oid                  = "betId";
        $this->Handle($data,"bg",$last_data);

    }

    /**
     * bg西游捕鱼数据处理
     */
    public function on_bg_westward_fish()
    {
        $this->c('bg');
        $this->end_log_id           = '6031';
        $this->cache_key            = "bg_".$this->end_log_id;
        $end_log_data                   = $this->end_log_data($this->cache_key,$this->end_log_id);
        if(!empty($end_log_data['up_time']) )
        {
            $start_time =   $end_log_data['up_time'];
            $end_time   = $start_time+3600;
        }else{
            $start_time = $_SERVER['time'] - 86400;
            $end_time   = $start_time+3600;
        }
        if($end_time > $_SERVER['time']-180)
        {
            $end_time   = $_SERVER['time']-180;
        }
        $data                       = $this->bg->get_fish(411,$start_time+60,$end_time);
        //print_r($data);exit;
        $last_data = array(
            'id'            => $this->end_log_id,
            'up_time'       => $data['end_time']
        );
        $this->on_name              = "BG西游捕鱼";
        $this->data_c_type          = "module_id";
        $this->detailed_info        = "bg-捕鱼";
        $this->result_username      = "loginId";
        $this->result_gamesId       = "gameType";
        $this->money                = "betAmount";
        $this->win_money            = "payout";
        $this->bet_money            = "validAmount";
        $this->oid                  = "betId";
        $this->Handle($data,"bg",$last_data);
    }

    /**
     * bg真人数据处理
     */
    public function on_bg5()
    {
        $this->c('bg');
        $this->end_log_id           = '6005';
        $this->cache_key            = "bg_".$this->end_log_id;
        $end_log_data                   = $this->end_log_data($this->cache_key,$this->end_log_id);
        if(!empty($end_log_data['up_time']) )
        {
            $start_time =   $end_log_data['up_time'];
            $end_time   = $start_time+3600;
        }else{
            $start_time = $_SERVER['time'] - 86400;
            $end_time   = $start_time+3600;
        }
        if($end_time > $_SERVER['time']-180)
        {
            $end_time   = $_SERVER['time']-180;
        }
        $data                       = $this->bg->get_log('',$start_time+1,$end_time+1);
        $last_data = array(
            'id'            => $this->end_log_id,
            'up_time'       => $data['end_time']
        );
        if(!empty($data['data']))
        {
            foreach($data['data'] as $key => $value)
            {
                $data['data'][$key]['bAmount'] = abs($value['bAmount']);
            }
        }
        $this->on_name              = "BG真人视讯";
        $this->data_c_type          = "module_id";
        $this->detailed_info        = "bg-真人视讯";
        $this->result_username      = "loginId";
        $this->result_gamesId       = "gameId";
        $this->money                = "bAmount";
        $this->win_money            = "payment";
        $this->bet_money            = "validBet";
        $this->oid                  = "orderId";
        $this->Handle($data,"bg",$last_data);
    }


    /**
     * ug体育数据处理
     */
    public function on_ug6()
    {
        $this->c('ug');
        $this->end_log_id           = '8006';
        $this->cache_key            = "ug_" . $this->end_log_id ;
        $end_log_data                   = $this->end_log_data($this->cache_key,$this->end_log_id);
        if(!empty($end_log_data['log_end_info']))
        {
            $end_log_id = $end_log_data['log_end_info'];
        }else{
            $end_log_id = '';
        }
        $data                       = $this->ug->get_log($end_log_id);
        /*if(!empty($data['data']))
        {
            foreach($data['data'] as $key => $value)
            {
                if(strpos($value['Account'],'_'))
                {
                    unset($data['data'][$key]);
                }
            }
        }*/
        $last_data = array(
            'id'            => $this->end_log_id,
            'log_end_info'  => $data['end_id'],
            'up_time'       => $this->current_time,
        );
        /*print_r($data);exit;*/
        $this->on_name              = "UG体育";
        $this->data_c_type          = "query_info";
        $this->detailed_info        = "ug-体育";
        $this->result_username      = "Account";
        $this->result_gamesId       = "SubGameID";
        $this->money                = "BetAmount";
        $this->win_money            = "Win";
        $this->bet_money            = "Turnover";
        $this->oid                  = "BetID";
        $this->Handle($data,"ug",$last_data);
    }

    /**
     * cq9投注数据采集
     */
    public function on_cq9()
    {

        $this->c('cq9');
        $this->end_log_id           = '9001';
        $this->cache_key            = "cq9_" . $this->end_log_id ;
        $end_log_data                   = $this->end_log_data($this->cache_key ,$this->end_log_id);
        if(!empty($end_log_data['up_time']) )
        {
            $start_time =   $end_log_data['up_time'];
            $end_time   = $start_time+3600;
        }else{
            $start_time = $_SERVER['time'] - 86400;
            $end_time   = $start_time+3600;
        }
        if($end_time > $_SERVER['time']-180)
        {
            $end_time   = $_SERVER['time']-180;
        }
        $data                       = $this->cq9->get_log($start_time,$end_time);
        $last_data = array(
            'id'            => $this->end_log_id,
            'up_time'       => $data['end_time'],
        );
        $this->on_name              = "cq9电子";
        $this->data_c_type          = "game_code";
        $this->detailed_info        = "cq9-电子";
        $this->result_username      = "account";
        $this->result_gamesId       = "gamecode";
        $this->money                = "bet";
        $this->win_money            = "win";
        $this->bet_money            = "bet";
        $this->oid                  = "round";
        $this->Handle($data,"cq9",$last_data);
    }
	
	 /*
    * dg采集数据
    */
    public function on_dg(){
        $this->c('dg');
        $this->end_log_id           = '7005';
        $this->cache_key            = "dg_" . $this->end_log_id ;
        $data                       = $this->dg->get_log();
        $end_log = array(
                'id'            => $this->end_log_id,
                'log_end_info'  =>   '',
                'up_time'       => $this->current_time
            );
        $this->on_name              = "DG视讯";//采集数据名称
        $this->data_c_type          = "game_code";
        $this->detailed_info        = "DG-真人";
        $this->result_username      = "userName";
        $this->result_gamesId       = "gameId";
        $this->money                = "betPoints";
        $this->win_money            = "winOrLoss";
        $this->bet_money            = "availableBet";
        $this->oid                  = "ext";
        $code = $this->Handle($data,"dg",$end_log);
        if($code == 1){
            $this->dg->markReport($data["ids_list"]);
        }
    }

    /**
     * jdb投注数据采集
     */
    public function on_jdb()
    {
        $this->c('jdb');
        $this->end_log_id           = '10001';
        $this->cache_key            = "jdb_" . $this->end_log_id ;
        $end_log_data                   = $this->end_log_data($this->cache_key ,$this->end_log_id);
        if(!empty($end_log_data['up_time']) )
        {
            $start_time =   $end_log_data['up_time'];
            $end_time   = $start_time+900;
        }else{
            $start_time = $_SERVER['time'] - 7200;
            $end_time   = $start_time+900;
        }
        if($start_time < $_SERVER['time']-7200)
        {
            $start_time = $_SERVER['time'] - 7200;
            $end_time   = $start_time+900;
        }
        if($end_time > $_SERVER['time']-300)
        {
            $end_time   = $_SERVER['time']-300;
        }
        $data                       = $this->jdb->get_log('',$start_time,$end_time);
        $last_data = array(
            'id'            => $this->end_log_id,
            'up_time'       => $data['end_time'],
        );
        $this->on_name              = "jdb";
        $this->data_c_type          = "game_code";
        $this->detailed_info        = "jdb";
        $this->result_username      = "playerId";
        $this->result_gamesId       = "mtype";
        $this->money                = "bet";
        $this->win_money            = "total";
        $this->bet_money            = "bet";
        $this->oid                  = "seqNo";
        $this->Handle($data,"jdb",$last_data);
    }

    /**
     * leg投注数据获取与处理
     */
    function on_leg()
    {
        $this->c('leg');
        $this->end_log_id           = 11001;
        $this->cache_key            = "leg".$this->end_log_id;
        $end_log_data                   = $this->end_log_data($this->cache_key,$this->end_log_id);
        if(!empty($end_log_data['up_time']) )
        {
            $start_time =   $end_log_data['up_time'];
            $end_time   = $start_time+1800;
        }else{
            $start_time = $_SERVER['time'] - 86400;
            $end_time   = $start_time+1800;
        }
        if($end_time > $_SERVER['time']-180)
        {
            $end_time = $_SERVER['time']-180;
        }
        $data                       = $this->leg->get_log('',$start_time+1,$end_time);
        if($data['status'] == 1)
        {
            if(!empty($data['data']) && is_array($data['data']))
            {
                $new_result_data = array();
                foreach($data['data']['Accounts'] as $key => $value)
                {
                    $new_result_data[] = array(
                        "GameID" => $data['data']['GameID'][$key],
                        "Accounts" => explode('_',$data['data']['Accounts'][$key])[1],
                        "ServerID" => $data['data']['ServerID'][$key],
                        "KindID" => $data['data']['KindID'][$key],
                        "TableID" => $data['data']['TableID'][$key],
                        "ChairID" => $data['data']['ChairID'][$key],
                        "UserCount" => $data['data']['UserCount'][$key],
                        "CellScore" => $data['data']['CellScore'][$key],
                        "AllBet" => $data['data']['AllBet'][$key],
                        "Profit" => $data['data']['Profit'][$key],
                        "Revenue" => $data['data']['Revenue'][$key],
                        "GameStartTime" => $data['data']['GameStartTime'][$key],
                        "GameEndTime" => $data['data']['GameEndTime'][$key],
                        "CardValue" => $data['data']['CardValue'][$key],
                        "ChannelID" => $data['data']['ChannelID'][$key],
                        "LineCode" => $data['data']['LineCode'][$key],
                    );
                }
                $data['data'] = $new_result_data;
            }
        }
        $last_data = array(
            'id'            => $this->end_log_id,
            'up_time'       => $data['end_time']
        );
        $this->on_name              = "leg";
        $this->data_c_type          = "module_id";
        $this->detailed_info        = "leg";
        $this->result_username      = "Accounts";
        $this->result_gamesId       = "KindID";
        $this->money                = "AllBet";
        $this->win_money            = "Profit";
        $this->bet_money            = "CellScore";
        $this->oid                  = "GameID";
        $this->Handle($data,"leg",$last_data);

    }

    /**
     * lc投注数据获取与处理
     */
    function on_lc()
    {
        $this->c('lc');
        $this->end_log_id           = 12001;
        $this->cache_key            = "lc".$this->end_log_id;
        $end_log_data                   = $this->end_log_data($this->cache_key,$this->end_log_id);
        if(!empty($end_log_data['up_time']) )
        {
            $start_time =   $end_log_data['up_time'];
            $end_time   = $start_time+3600;
        }else{
            $start_time = $_SERVER['time'] - 86400;
            $end_time   = $start_time+3600;
        }
        if($end_time > $_SERVER['time']-180)
        {
            $end_time = $_SERVER['time']-180;
        }
        $data                       = $this->lc->get_log('',$start_time+1,$end_time);
        if($data['status'] == 1)
        {
            if(!empty($data['data']) && is_array($data['data']))
            {
                $new_result_data = array();
                foreach($data['data']['Accounts'] as $key => $value)
                {
                    $new_result_data[] = array(
                        "GameID" => $data['data']['GameID'][$key],
                        "Accounts" => explode('_',$data['data']['Accounts'][$key])[1],
                        "ServerID" => $data['data']['ServerID'][$key],
                        "KindID" => $data['data']['KindID'][$key],
                        "TableID" => $data['data']['TableID'][$key],
                        "ChairID" => $data['data']['ChairID'][$key],
                        "UserCount" => $data['data']['UserCount'][$key],
                        "CellScore" => $data['data']['CellScore'][$key],
                        "AllBet" => $data['data']['AllBet'][$key],
                        "Profit" => $data['data']['Profit'][$key],
                        "Revenue" => $data['data']['Revenue'][$key],
                        "GameStartTime" => $data['data']['GameStartTime'][$key],
                        "GameEndTime" => $data['data']['GameEndTime'][$key],
                        "CardValue" => $data['data']['CardValue'][$key],
                        "ChannelID" => $data['data']['ChannelID'][$key],
                        "LineCode" => $data['data']['LineCode'][$key],
                    );
                }
                $data['data'] = $new_result_data;
            }
        }
        $last_data = array(
            'id'            => $this->end_log_id,
            'up_time'       => $data['end_time']
        );
        $this->on_name              = "lc";
        $this->data_c_type          = "module_id";
        $this->detailed_info        = "lc";
        $this->result_username      = "Accounts";
        $this->result_gamesId       = "KindID";
        $this->money                = "AllBet";
        $this->win_money            = "Profit";
        $this->bet_money            = "CellScore";
        $this->oid                  = "GameID";
        $this->Handle($data,"lc",$last_data);
    }

    public function on_total_data()
    {
        $min_time = strtotime(date("Y-m-d 00:00:00",strtotime('-1 day')));
        $max_time = strtotime(date("Y-m-d 23:59:59"),strtotime('-1 day'));
        $current_time = strtotime(date('Y-m-d 00:00:00'));
        $this->c('site_total_data');
        $check  = $result = $this->site_total_data->index_fetch(
            array(
                'add_time' => array(' >= ' => $current_time ),
            ),'',0,10
        );
        $table_id = $site_data = array();
        $this->mcache->clear('api');
        $api_cache = $this->mcache->read('api');
        foreach($api_cache as $k => $v){
            if($v['site_id'] != 0 && $v['service_data_status'] == 2){
                $table_id[$v['service_id']] = $v['site_id'];
            }
        }
       if(empty($check) or count($check) < count($table_id))
       {
                   $this->c('order');
                   foreach($table_id as $key => $value){
                       $this->order->table = $key .'_order';
                       $result = $this->order->group(
                           array(
                               'add_time' => array(' >= ' => $min_time , ' <= ' => $max_time),
                           ),
                           'site_id,platform_and_type',
                           array('site_id,platform_and_type,sum(money) as money,sum(win_money) as win_money,sum(bet_money) as bet_money')
                       );
                       if(!empty($result)) {
                           foreach ($result as $k1 => $v1) {
                               $site_data[$key][$v1['site_id']][] = $v1;
                           }
                       }else
                       {
                           $site_data[$key][$value] = '';
                       }
                   }
                   if(!empty($site_data)){
                       $site_log = array();
                       foreach($site_data as $k => $v){
                               foreach($v as $key => $value)
                               {
                                   $site_log[] = array(
                                       'id' => date("Ymd", $min_time).str_pad($k.$key,5, 0,STR_PAD_LEFT),
                                       'site_id' => $key,
                                       'add_time' => $_SERVER['time'],
                                       'data' => json_encode($value),
                                   );
                               }
                       } ;
                       $this->site_total_data->add_list($site_log);
                       echo date("Y-m-d H:i:s")."昨天总汇计算完成!\r\n";exit;
                   }
       }else{
           echo date("Y-m-d H:i:s")."昨天总汇以计算过!\r\n";exit;
       }
    }




}
?>