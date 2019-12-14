<?php
!defined('FRAMEWORK_PATH') && exit('FRAMEWORK_PATH not defined.');
	include 'D:/laragon/www/tmp/control_common_control.class.php';

class api_control extends common_control {

    private $last_game_id = '';
    private $game_id = '';
    private $username;
    private $uid;
    private $logo_money;
    private $logo_pid;
    private $out_money;
    private $api_log_key;
    private $out_platform_id;
    private $current_api = array();
    private $ip;
    private $method;
    private $orders_id;
    function __construct() {
        parent::__construct();
        $this->c('error');
        $this->api_key = core::gpc('api_key', 'P');//网站接口KEY
        $this->api_secret = core::gpc('api_secret', 'P');//网站接口秘钥
        $this->api_list = $this->mcache->read('api');
        $this->check_parameter();
        $this->_api = $this->api_list[$this->api_key];
        $this->conf['table_id'] = $this->_api['service_id'];//系统内的网站使用服务器id作为表名
        if($this->_api['service_id'] == 0){
            //系统外的网站使用网站id作为表名，并且前面加0不冲突且好集合数据
            $this->conf['table_id'] = '0'.$this->_api['site_id']%$this->conf['table_site_num'];
        }
        $this->api_log_key = 'api_'.$this->_api['site_id'].'_log';
        $this->_games_list = $this->mcache->read('games');
        $this->_platform_list = $this->mcache->read('platform');
        $this->c('cache_redis');
        $this->c("api");
        $this->c('api_log');
        $this->cache_redis->select($this->conf['redis_db']);
        $this->isset_method();
    }

    //进入游戏
    function on_goto_game(){
        $this->check_user_parameter();
        if(empty(intval(core::gpc('gid', 'R'))))
        {
            return $this->echo_cmd('gid_error');
        }
        $this->game_id = intval(core::gpc('gid', 'R'));//游戏ID
        $this->logo_money = core::gpc('money', 'P');//转入金额
        $is_encrypt = core::gpc('is_encrypt','P');
        $this->logo_pid = $this->_games_list[$this->game_id]['platform_id'];
        $this->check_permission();
        $this->check_lock($this->api_key);
        $this->get_api();
        if($this->current_api['wallet'] < 0 || $this->current_api['wallet'] < $this->logo_money )
        {
            return $this->echo_cmd('in_money_insufficient_balance');
        }
        $user = array(
            'uid' => $this->uid,
            'old_username' => $this->username,
            'site_id' => $this->_api['site_id'],
            'ip' => $this->ip,
        );
        $class_name = $this->_platform_list[$this->logo_pid]['class_name'];
        $this->c($class_name);
        $this->_user = $this->$class_name->check_user($user);
        $this->$class_name->site_id = $this->_api['site_id'];
        $this->$class_name->game_info = $this->_games_list[$this->game_id];
        $this->$class_name->game_user['order_id'] = $this->orders_id;
        //检测之前是否有未退出的游戏，如果平台一致则不退回资金，如果不一致，则退回资金
        $this->c('loginlog');
        $this->c('user');
        $user_game_log = $this->loginlog->index_fetch(array('uid' => $this->_user['id']), array('id' => 2), 0, 1);
        if(!empty($user_game_log)){
            list($userlogk, $userlog_data) = each($user_game_log);
            if($userlog_data['typeid'] == 1 and $userlog_data['platform_id'] != $this->logo_pid){
                $this->last_game_id = $userlog_data['game_id'];
                $surplus_money = $this->on_out_game($userlog_data['platform_id'], $this->_user, 1);
                if($surplus_money['money'] > 0){
                    $this->logo_money += $surplus_money['money'];
                    $this->user->update1($this->_user['id'], array(
                            'money' => $surplus_money['money']
                        )
                    );
                }
            }
        }
        if(isset($this->_user['money']) && $this->_user['money'] > 0){
            $this->logo_money += $this->_user['money'];
        }
        $this->$class_name->game_info['last_game_id'] = isset($userlog_data['game_id']) ? $userlog_data['game_id'] : $this->last_game_id;

        /*// $goto_game = $this->$class_name->get_money();
       $goto_game = $this->$class_name->check_transfer( "5");
        print_r($goto_game);
        exit;*/
        $goto_game = $this->$class_name->user_in_game($this->logo_money, $this->game_id);
        if($goto_game['status'] == 1){
            //登陆成功，增加登陆游戏转账记录
            if(empty($goto_game['orders_number'])){
                $goto_game['orders_number'] = api_control::order_id($this->$class_name->game_user['username']);
            }
            $goto_game['money'] = $this->logo_money;
            $log_id = $this->za->login_log($this->_user['id'],$this->_api['site_id'],$this->ip,'','',$goto_game,1,$this->logo_pid,$this->game_id,$this->orders_id);
            if(!isset($this->_user['platform_log']))
            {
                $this->_user['platform_log'] = '';
            }
            $platform_log = json_decode($this->_user['platform_log'],true);
            $platform_log[$this->logo_pid] = array(
                "last_time" => time(),
                "game_id" => $this->game_id,
            );
            $this->user->update1($this->_user['id'], array(
                    'money' => 0,
                    'platform_log' => json_encode($platform_log),
                )
            );
            if(!empty($log_id))
            {
                $goto_game['orders_number'] = $this->encrypt_order($log_id);
            }
            $goto_game['order_id'] = $this->orders_id;
        }
        if($this->logo_money > 0)
        {
            $this->api_log(2);
        }
        $this->cache_redis->del(md5($this->uid.$this->api_key));
        if($is_encrypt == 1 )
        {
            $this->is_encrypt($goto_game);
        }
        return $this->echo_cmd($goto_game);
    }

    /**  加密返回数据
     * @param $result
     */
    private function is_encrypt($result)
    {
        $this->c("api_aes");
        $timestamp = $_SERVER['time'];
        $result['site_id'] = core::gpc("sid",'P');
        $result['game_id'] = $this->game_id;
        $result['timestamp'] = $timestamp;
        $result['token'] =  core::gpc("token",'P');
        $sign = api_aes::md5_Encrypt($result);
        $code = api_aes::encrypt(json_encode($result));
        $return = array(
            "status" => 1,
            "code" => urlencode($code),
            "sign" => $sign,
            "data" => "",
            "message" => "",
        );
        $this->echo_cmd($return);
    }

    /**退出游戏，并转出平台内的整数金额
     * @param int $platform_id
     * @param array $user
     * @param int $return
     */
    function on_out_game($platform_id = 0, $user = array(), $return = 0){
        if(empty($platform_id)){
            $this->check_user_parameter();
            $this->check_lock("out_game");
            $this->get_api();
            /*判断用户是否存在  存在判断获取最后一次登录数据*/
            $this->c('user');
            $user_data = $this->user->index_fetch(array('id' => $this->_api['site_id'].sprintf("%011s",$this->uid)));
            if(empty($user_data))
            {
                return $this->echo_cmd('success');
            }
            list($cancel,$user_result) = each($user_data);
            $this->c('loginlog');
            $user_game_log = $this->loginlog->index_fetch(array('uid' => $user_result['id']), array('id' => 2), 0, 1);
            if(empty($user_game_log))
            {
                return $this->echo_cmd('success');
            }
            list($out_cancel,$user_last) = each($user_game_log);
            if(!empty($user_last) && $user_last['game_id'] != 0)
            {
                $this->last_game_id = $user_last['game_id'];
            }else{
                return $this->echo_cmd('success');
            }
            if(isset($this->_platform_list[core::gpc("platform_id",'P')]))
            {
                $platform_id = core::gpc("platform_id",'P');
            }else
            {
                if($user_last['typeid'] == 2 )
                {
                    return $this->echo_cmd('success');
                }
                $platform_id = $this->_games_list[$this->last_game_id]['platform_id'];
            }
        }else{
            $this->check_lock("out_gmae");
            $this->za->make_log($this->uid,$_SERVER['time'],'start',json_encode($user),"out_game");
        }
        if(empty($platform_id)){
            $this->echo_cmd('pid_error');
        }
        $user = array(
            'uid' => $this->uid,
            'old_username' => $this->username,
            'site_id' => $this->_api['site_id'],
            'ip' => $this->ip,
        );
        $this->out_platform_id = $platform_id;
        $class_name = $this->_platform_list[$platform_id]['class_name'];
        $this->c($class_name);
        $this->_user = $this->$class_name->check_user($user);
        $this->$class_name->site_id = $this->_api['site_id'];
        $this->$class_name->game_info = $this->_games_list[$this->last_game_id];
        $this->$class_name->game_info['last_game_id']  = $this->last_game_id;
        $this->$class_name->game_user['order_id'] = $this->orders_id;
        $out_game = $this->$class_name->user_out_game();

        if($out_game['status'] == 1){
            //退出登录需要退出记录
            if(empty($out_game['orders_number'])){
                $out_game['orders_number'] = api_control::order_id($this->$class_name->game_user['username']);
            }else{
                $this->out_money = $out_game['money'];
                $this->api_log(1);
            }
            $log_id = $this->za->login_log($this->_user['id'],$this->_api['site_id'],$this->ip,'-'.$out_game['money'],'',$out_game,2,$this->out_platform_id,$this->last_game_id,$this->orders_id);
            if(!empty($log_id))
            {
                $out_game['orders_number'] = $this->encrypt_order($log_id);
            }
            $out_game['order_id'] = $this->orders_id;
        }
        $out_game['user_name'] = $this->_user['username'];
        $this->cache_redis->del(md5($this->uid."out_game"));
        if($return == 1){
            $this->za->make_log($this->uid,time(),'end',json_encode($out_game),"out_game");
            return $out_game;
        }
        return $this->echo_cmd($out_game);
    }

    /** 锁
     * @param $key
     * @param string $type
     * @return bool
     */
    private function check_lock($key , $type = '')
    {
        if($type === 1 )
        {
            $lock_key = md5($key);
        }else{
            $lock_key = md5($this->uid.$key);
        }
        if(  $this->cache_redis->setnx($lock_key,time()) == 1  )
        {
            return true;
        }else if(time() - $this->cache_redis->kGet($lock_key) > 10)
        {
            $this->cache_redis->del($lock_key);
            $this->cache_redis->setnx($lock_key,time());
            return true;
        }else
        {
            sleep(3);
            return $this->check_lock($key,$type);
        }
    }

    /**  加密订单号
     * @param $log_id
     * @return string
     */
    private function encrypt_order($log_id)
    {
        $this->c("id_to_code");
        $system_orders  = array($this->_api['site_id'],$this->conf['table_id'],$log_id);
        $str = "";
        foreach($system_orders as $key => $value)
        {
            $str .=  $this->id_to_code->en_username($value,"",5,20);
        }
        return $str;
    }

    /** 获取api表
     * @return array|mixed
     */
    private function get_api()
    {
        $get_api = $this->cache_redis->hGetAll($this->api_log_key);
        if(!empty($get_api))
        {
            $get_api['wallet'] = $get_api['wallet'] / 10000;
            $this->current_api = $get_api;
        }else{
            $get_api = $this->api->index_fetch(array("api_key" => $this->api_key , "api_secret" => $this->api_secret , "service_id" => $this->conf['table_id']) , '' ,0,1);
            list($api_null,$this->current_api) = each($get_api);
            $new_redis = $this->current_api;
            $new_redis['wallet'] = $this->current_api['wallet'] * 10000;
            $this->cache_redis->hMset($this->api_log_key,$new_redis);
            unset($new_redis);
        }
    }

    /** insert and update
     * @param $type
     */
    private function api_log($type)
    {
        $api_log = array(
            "add_time" => time(),
            "api_id" => $this->_api['id'],
            "game_id" => $this->game_id,
            "site_id" => $this->_api['site_id'],
            "service_id" => $this->conf['table_id'],
            "type_id" => $type,
        );
        if($type == 1 )
        {
            $api_log['platform_id'] = $this->out_platform_id;
            $api_log['game_id'] = $this->last_game_id;
            $api_log['money'] = $this->out_money;
            $this->_api['wallet'] = $this->current_api['wallet']  + $this->out_money;
            $update = array(
                "wallet" => array( '+' => $this->out_money)
            );
        }else{
            $api_log['platform_id'] = $this->logo_pid;
            $api_log['game_id'] = $this->game_id;
            $api_log['money'] = '-'.$this->logo_money;
            $this->_api['wallet'] = $this->current_api['wallet'] - $this->logo_money;
            $update = array(
                "wallet" => array( '-' => $this->logo_money)
            );
        }
        $this->current_api['wallet'] = $this->_api['wallet'];
        $this->api->update1($this->_api['id'],$update);
        $this->api_log->add($api_log);
        $this->cache_redis->hIncrBy($this->api_log_key,'wallet',$api_log['money']*10000);
    }

    /**
     * 检查游戏状态
     */
    private function check_permission()
    {
        if(empty($this->_games_list[$this->game_id])){
            return $this->echo_cmd('gid_error');
        }else if($this->logo_money > 0 && !preg_match('/^[0-9]+(.[0-9]{1,4})?$/',$this->logo_money)){
            return $this->echo_cmd('amount_four_decimal');
        }else{
            $this->_platform_list[$this->logo_pid]['module_status'] = json_decode($this->_platform_list[$this->logo_pid]['module_status'], true);
            if($this->_games_list[$this->game_id]['status'] == 2 or $this->_platform_list[$this->logo_pid]['status'] == 2 or $this->_platform_list[$this->logo_pid]['module_status'][$this->_games_list[$this->game_id]['type_id']] == 0){
                return $this->echo_cmd('game_maintain');
            }
        }
    }


    /**获取用户在平台的金额
     * @param int $platform_id
     * @param array $user
     * @param int $return
     */
    function on_look_user_money($platform_id = 0, $user = array(), $return = 0){
        if(empty($platform_id)){
            $this->check_user_parameter();
            $platform_id = intval(core::gpc('pid', 'P'));//平台ID
        }else{
            $this->username = $user['username'];
            $this->uid = $user['uid'];
        }
        if(empty($platform_id)){
            $this->echo_cmd('pid_error');
        }
        $this->check_lock("look_user_money");
        $user = array(
            'uid' => $this->uid,
            'old_username' => $this->username,
            'site_id' => $this->_api['site_id'],
            'ip' => $this->ip
        );
        $class_name = $this->_platform_list[$platform_id]['class_name'];
        $this->c($class_name);
        $this->_user = $this->$class_name->check_user($user);
        $this->$class_name->site_id = $this->_api['site_id'];
        $money = $this->$class_name->get_money();
        $money['balance'] = $money['balance']+$this->_user['balance'];
        $money['user_name'] = $this->_user['username'];
        $this->cache_redis->del(md5($this->uid."look_user_money"));
        if($return == 1){
            return $money;
        }
        return $this->echo_cmd($money);
    }

    /**
     * 网站或服务器拉取数据
     */
    function on_get_data(){
        $service_id = intval(core::gpc('service_id', 'P'));//服务器ID
        $start_id = core::gpc('start_id', 'P');//上次一次获取到的最后一条数据ID，如果第一次获取，递交0
        $num = intval(core::gpc('num', 'P'));//数据量
        $is_infos = core::gpc('is_infos','P');
        $this->c('id_to_code');
        $this->za->make_log($this->api_secret,$_SERVER['time'],'start',json_encode($_POST),$this->method);
        if((!empty($service_id) && $this->_api['service_data_status'] != 1 ) or (!empty($service_id) && $this->_api['service_id'] != $service_id)){
            $this->echo_cmd('no_authority');
        }
        if(!empty($start_id)){
            $start_id = intval($this->id_to_code->de_username($start_id)[0]);
        }else{
            $start_id = 0;
        }
        $this->check_lock($service_id);
        $this->c('order');
        $where = array(
            'id' => array(
                '>' => $start_id,
            ),
        );
        if($num < 1 or $num > 5000){
            $this->echo_cmd('data_num_error');
        }
        if(!empty($service_id)){
            $where['service_id'] = $service_id;
        }else{
            $where['site_id'] = $this->_api['site_id'];
        }
        $data = $this->order->index_fetch($where, array('id' => 1), 0, $num);
        $log_data = array();

        if(!empty($data)){
            //这里加工处理数据再提供给接口，默认处理是为了处理数组的$key
            if($is_infos == 1 )
            {
                foreach($data as $k => $v){
                    $v['id'] = $this->id_to_code->en_username($v['id'], '', 6, 20);
                    $log_data[] = $v;
                    unset($data[$k]);
                }
            }else{
                foreach($data as $k => $v){
                    $v['id'] = $this->id_to_code->en_username($v['id'], '', 6, 20);
                    unset($v['infos']);
                    $log_data[] = $v;
                    unset($data[$k]);
                }
            }

        }
        $return = array(
            'status' => 1,
            'data' => $log_data,
        );
        $this->cache_redis->del(md5($service_id));
        return $this->echo_cmd($return);
    }

    /**  沒充值使用的统一订单号
     * @param $name
     * @return string
     */
    static function order_id($name)
    {
        $Current_ms = round(microtime(true)*1000);
        return 'mb_'.$Current_ms.'_'.$name;
    }

    /**
     * 判断方法是否存在
     */
    private function isset_method()
    {
        $method = 'on_'.core::gpc('method', 'P');
        if(method_exists($this,$method))
        {
            return $this->$method();
        }else
        {
            return $this->echo_cmd('api_method_error');
        }
    }

    /**
     * 检查key与ip
     */
    private function check_parameter()
    {
        if(empty($this->api_key)  || empty($this->api_secret)){
            header("HTTP/1.1 404 Not Found");
            header("Status: 404 Not Found");
            exit;
        }else if(empty($this->api_list[$this->api_key]) or $this->api_list[$this->api_key]['api_key'] != $this->api_key){
            $this->echo_cmd('api_key_error');
        }else if( $this->api_list[$this->api_key]['api_secret'] != $this->api_secret){
            $this->echo_cmd('api_secret_error');
        }else if($this->api_list[$this->api_key]['ip'] != $this->za->get_ip(2)){
            // $this->echo_cmd('ip_error');
        }
    }

    /** 公共打印error方法
     * @param $name  code 下标
     */
    private function echo_cmd($data)
    {
        if(is_array($data))
        {
            echo  json_encode($data);
            $this->za->make_log($this->uid,time(),'end',json_encode($data),$this->method);
            exit;
        }
        if(!empty($this->error->code($data)))
        {
            echo  json_encode($this->error->code($data));exit;
        }else
        {
            echo  json_encode('不存在的下标');exit;
        }
    }

    /** 检测用户参数
     * @return string|void
     */
    private function check_user_parameter()
    {
        if(empty(core::gpc('uid', 'P')))
        {
            return $this->echo_cmd('uid_error');
        }
        if( preg_replace('/[^(0-9)]/', '@', core::gpc('uid', 'P')) !== core::gpc('uid', 'P')   || strlen(core::gpc('uid', 'P')) > 11 )
        {
            return $this->echo_cmd('uid_int_error');
        }
        if($this->_api['service_data_status'] != 2)
        {
            $this->echo_cmd('no_authority');
        }
        $this->ip = $this->za->iptoint(core::gpc('ip', 'P'));//客户IP
        $this->method = core::gpc('method', 'P');//客户IP
        $this->username = core::gpc('user_name', 'P');//用户名
        $this->uid = core::gpc('uid', 'P');//用户ID
        $this->orders_id = core::gpc('order_id', 'P');//商户订单号
        $this->za->make_log($this->uid,time(),'start',json_encode($_POST),$this->method);
    }

    /**
     * 写入平台的游戏 没对外开放
     */
    private function on_insert_games()
    {
        if(empty(core::gpc('platform_id', 'P')) || empty($this->_platform_list[core::gpc('platform_id', 'P')]))
        {
            return $this->echo_cmd('pid_error');
        }
        $pid = core::gpc('platform_id', 'P');
        /*$user = array(
            'uid' => $this->uid,
            'old_username' => $this->username,
            'site_id' => $this->_api['site_id'],
            'ip' => $this->ip,
        );*/
        $class_name = $this->_platform_list[$pid]['class_name'];
        $this->c($class_name);
        //$this->_user = $this->$class_name->check_user($user);
        $this->$class_name->site_id = $this->_api['site_id'];
        $result = $this->$class_name->get_game();
        $this->c("games");
        $New_game = [];
        exit;
        if(!empty($result['msg'])) {
            foreach ($result['msg'] as $key => $value)
            {
                $isset  = $this->games->index_fetch(array("game_name_cn"=>trim($value["game_name_cn"]),"platform_id" => $pid),array('id'=>2),0,1);
                if(empty($isset))
                {
                    $New_game[$key] = $value;
                }
            }
        }
        if(!empty($New_game))
        {
            $this->games->add_list($New_game);
            $this->_games_list = $this->mcache->clear('games');
        }
        echo  true;exit;
    }

    /**
     * 退出一周内登陆过的游戏的金额
     */
    private function on_query_all_balance()
    {
        $this->check_user_parameter();
        $this->check_lock("query_all_balance");
        $this->c('loginlog');
        $this->c('user');
        $max_time =  $_SERVER['time'] - (60*60*24*7) ;
        $uid = $this->_api['site_id'].sprintf("%011s",$this->uid);
        $platform = $this->user->get($uid);
        $user = array(
            'uid' => $this->uid,
            'old_username' => $this->username,
            'site_id' => $this->_api['site_id'],
            'ip' => $this->ip,
        );
        $arr_out_game = array();
        $Total_money = 0;
        $user_game_log = json_decode($platform['platform_log'],true);
        foreach($user_game_log as $key => $value)
        {
            if(isset($this->_platform_list[$key]))
            {
                if($value['last_time'] > $max_time)
                {
                    $class_name =   $this->_platform_list[$key]['class_name'];
                    $this->c($class_name);
                    $this->_user = $this->$class_name->check_user($user);
                    $this->$class_name->site_id = $user['site_id'];
                    $this->$class_name->return_type = 2;
                    $this->$class_name->game_info = $this->_games_list[$value['game_id']];
                    $this->$class_name->game_info['last_game_id']  = $value['game_id'];
                    $this->$class_name->game_user['order_id'] = $this->orders_id;

                    $get_money = $this->$class_name->get_money();
                    $arr_out_game[$class_name]['get_money'] = $get_money;
                    if($get_money['status'] == 1  && $get_money['balance'] > 0 )
                    {
                        $orders = $this->$class_name->set_order_id();
                        $transfer = $this->$class_name->in_out_money($get_money['balance'],2);
                        $arr_out_game[$class_name]['in_out_money'] = $transfer;
                        if($transfer['status'] == 1 )
                        {
                            $Total_money += $transfer['money'];
                        }
                    }
                }

            }
        }
        $loginlog_data = array(
            'uid' => $uid,
            'site_id' => $this->_api['site_id'],
            'add_time' => time(),
            'ip' => $this->ip,
            'money' => '-'.$Total_money,
            'orders_number' => '',
            'infos' => json_encode($arr_out_game),
            'typeid' => 3,
            'platform_id' => '0',
            'game_id' => '0',
            'order_id' => $this->orders_id,
        );
        $this->loginlog->add($loginlog_data);
        $this->cache_redis->del(md5($this->uid."query_all_balance"));
        $result = array("status" => 1 , "total_money" => $Total_money , "data" => "" , "order_id" => $this->orders_id);
        $this->echo_cmd($result);
    }

    /**
     * get all games
     */
    private function on_get_games()
    {
        $this->za->make_log($this->_api['site_id'],$_SERVER['time'],'start',json_encode($_POST),$this->method);
        $this->check_lock($this->api_key.$this->api_secret);
        $this->mcache->clear('platform');
        $this->mcache->clear('games');
        $platform = $this->mcache->read('platform');
        $games = $this->mcache->read('games');
        $result  =  array(
            "status" =>1 ,
            "message" => "success" ,
            "platform" => $platform ,
            "games" =>$games ,
        );
        $this->cache_redis->del(md5($this->api_key.$this->api_secret));
        $this->echo_cmd($result);
    }

    /**
     * 获取用户数据
     */
    private function on_get_user()
    {
        $this->check_user_parameter();
        $this->check_lock("get_user");
        $this->c('user');
        $platform_id = core::gpc("platform_id","P");
        $user = array(
            'uid' => $this->uid,
            'old_username' => $this->username,
            'site_id' => $this->_api['site_id'],
            'ip' => $this->ip,
        );
        if(empty($platform_id))
        {
            $id = $user['site_id'].sprintf("%011s",$user['uid']);
            $this->_user  = $this->user->get($id);
        }else{
            $class_name = $this->_platform_list[$platform_id]['class_name'];
            $this->c($class_name);
            $this->_user = $this->$class_name->check_user($user);
        }
        unset($this->_user['site_id']);
        unset($this->_user['password']);
        unset($this->_user['ip']);
        $this->cache_redis->del(md5($this->uid."get_user"));
        $this->echo_cmd($this->_user);
    }

    /**
     * 查询全部登录过的平台余额
     */
    private function on_query_get_money()
    {
        $this->check_user_parameter();
        $this->check_lock("query_get_money");
        $this->c('user');
        $platform = $this->user->get($this->_api['site_id'].sprintf("%011s",$this->uid));
        $user = array(
            'uid' => $this->uid,
            'old_username' => $this->username,
            'site_id' => $this->_api['site_id'],
            'ip' => $this->ip,
        );
        $result = array(
            "status" => 1,
            "data" => array(
                "0" => array(
                    "status" => 1 ,
                    "balance" => $platform['balance'] ,
                    "deny_balance" => 0 ,
                    "user_name" => $platform['username'] ,
                )
            ),
        );
        $user_game_log = json_decode($platform['platform_log'],true);
        $max_time = time() - 60*60*24*30;

        foreach($this->_platform_list  as $key => $value)
        {
            if(isset($user_game_log[$key]))
            {
                if( $user_game_log[$key]['last_time'] > $max_time )
                {
                    $class_name = $this->_platform_list[$key]['class_name'];
                    $this->c($class_name);
                    $this->_user = $this->$class_name->check_user($user);
                    $this->$class_name->site_id = $user['site_id'];
                    $this->$class_name->return_type = 2;
                    $this->$class_name->game_info = $this->_games_list[$user_game_log[$key]['game_id']];
                    $this->$class_name->game_info['last_game_id']  = $user_game_log[$key]['game_id'];
                    $get_money = $this->$class_name->get_money();
                    if($get_money['status'] == 1 )
                    {
                        $result['data'][$key] = $get_money;
                        $result['data'][$key]['user_name'] = $this->_user['username'];
                    }else
                    {
                        $result['data'][$key] = array(
                            "status" => 2,
                            "user_name" => $this->_user['username'],
                        );
                    }
                }else
                {
                    $result['data'][$key]['status'] = 1;
                    $result['data'][$key]['balance'] = 0;
                    $result['data'][$key]['deny_balance'] = 0;
                    $result['data'][$key]['user_name'] = $platform['username'];
                    $result['data'][$key]['last_time'] = $user_game_log[$key]['last_time'];
                }
            }else
            {
                $result['data'][$key]['status'] = 1;
                $result['data'][$key]['balance'] = 0;
                $result['data'][$key]['deny_balance'] = 0;
                $result['data'][$key]['user_name'] = "未注册";
            }
        }
        $this->cache_redis->del(md5($this->uid."query_get_money"));
        $this->echo_cmd($result);
    }

   /* public function on_user_insert()
    {
        $this->check_lock("user_insert");
        $this->c('user');
        $this->c('loginlog');
        $user_data = $this->user->index_fetch('',array('id' => 1),0,9999);
        $platform = array();
        foreach($user_data as $key => $value)
        {
            $user_game_log = $this->loginlog->group( array("typeid" => 1 , "uid" =>$value['id']), 'platform_id',array('platform_id','game_id') );
            if(!empty($user_game_log))
            {
                foreach ($user_game_log as $k => $v)
                {
                    $platform[$v['platform_id']]  = array(
                        "last_time" => time(),
                        "game_id" => $v['game_id'],
                    );
                }
            }
            if(!empty($platform))
            {
                $this->user->update1($value['id'],array('platform_log' => json_encode($platform)));
            }
        }

        $this->cache_redis->del(md5($this->uid."user_insert"));
        echo 'ok';exit;
    }*/



}
?>