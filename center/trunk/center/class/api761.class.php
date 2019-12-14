<?php

/** 761接口
 * Class api761
 * 最短拉取时间 无间隔
 */
class api761 extends base_model{

    //endlog表类型标志
    const endlog_type = array(
        "get_log" => 01
    );

    function __construct(){
        parent::__construct();
        $this->platform_id = 2;
        //加载id_code和error类
        $this->c("id_to_code");
        $this->c("error");
        //定义api接口上主域名
        $this->api761_url = $this->conf['platform'][$this->platform_id]['url'];
        //API授权信息
        $this->api761_key = $this->conf['platform'][$this->platform_id]['key'];
        $this->agent = $this->conf['platform'][$this->platform_id]['agent'];
        $this->iv = $this->conf['platform'][$this->platform_id]['iv'];
        //定义用户信息
        $this->game_user = array();
        //网站ID
        $this->site_id = 1;
        $this->en_site_id = "";
        $this->game_type = "h5";
        $this->user_ip = "";
        $this->site_url = "";
        //用户名最长最短限制
        $this->max_username_len = 16;
        $this->min_username_len = 5;
        $this->game_info = array();//20190625新增
        $this->return_type = 1;
    }
    private $order_id;

    //转换用户信息
    public function check_info(){
        if(empty($this->game_user)){
            return $this->echo_cmd("user_empty");
        }elseif(empty($this->site_id)){
            return $this->echo_cmd("site_empty");
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

    /**    各自单独解密
     * @param $en_username
     * @return array
     */
    public function de_username($en_username){
        $de_username = $this->id_to_code->tid_decode($en_username, 0);
        $de_username = explode("-",$de_username);
        return $de_username;
    }

    /*
     * 通用递交接口
     */
    public function api_query($api,$data,$type = 1){
        $timestamp = $_SERVER["time"];
        $sign = md5($this->agent.$timestamp.$this->api761_key);
        $param2 = "agent=".$this->agent."&timestamp=".$timestamp."&sign=".$sign;
        $url = $this->api761_url.$api.$param2;
        $info = $this->za->curlPost($url,$data,3,5);
        if($type == 1){
            $json_info = json_decode($info,true);
            return $json_info;
        }else{
            return $info;
        }
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

    /**
     * 生成订单id
     */
    private function set_order_id()
    {
        list($use,$sec) = explode(' ',microtime());
        $Current_ms = sprintf('%.0f',(floatval($use)+floatval($sec)) * 1000 );
        $this->order_id  =  $Current_ms.'_'.$this->game_user["username"];
    }

    /** 获取订单id
     * @return mixed
     */
    private function get_order_id()
    {
        return $this->order_id;
    }

    //开户接口（对外）
    public function reg($num = 1 ,$error=""){
        if($num > 3){
            return $this->echo_cmd("reg_user_error");
        }
        if( $error == 8 )
        {
            return $this->echo_cmd("no_authority");
        }
        $result = $this->login_api();
        if(isset($result["code"])){
            if($result["code"] == 0){
                return array("status"=>1,"msg"=>'registered success');
            }else{
                $num += 1;
                return $this->reg($num , isset($result['code']) ? $result['code'] : '');
            }
        }else{
            $num += 1;
            return $this->reg($num , isset($result['code']) ? $result['code'] : '');
        }
    }

    //登录接口 （对外）
    public function login($game = '', $num = 1){
        if($num > 3){
            return $this->echo_cmd("login_user_error");
        }
        if(!empty($game)){
            $game = "game=".$this->game_info['game_code'];
        }
        $this->outlogin();
        $result = $this->login_api($game);
        if(isset($result["code"])){
            if($result["code"] == 0){
                return array("status"=>1,"msg"=>$result["d"]["url"]);
            }else{
                $num += 1;
                return $this->reg($num , isset($result['code']) ? $result['code'] : '');
            }
        }else{
            $num += 1;
            return $this->reg($num  , isset($result['code']) ? $result['code'] : '' );
        }
    }

    //登录注册接口
    private function login_api($param3 = ''){
        $this->check_info();
        $acc = $this->game_user["username"];
        $nick = $this->game_user["username"];
        $gline = "gline".$this->site_id;
        $param_arr = array(
            "acc" => $acc,
            "nick" => $nick,
            "gline" => $gline
        );
        $param_encrypt = $this->encrypt($param_arr);
        $params = "params=".$param_encrypt."&";
        if(!empty($param3)){
            $params = $params.$param3."&";
        }
        $api = "agent/login?".$params;
        $result = $this->api_query($api,array(),1);
        return $result;
    }

    //退出登录
    public function outlogin($num = 1){
        if($num > 3){
            return $this->echo_cmd("user_outlogin_error");
        }
        $this->check_info();
        $params_arr = array(
            "acc" => $this->game_user["username"]
        );
        $params = "params=".$this->encrypt($params_arr);
        $api = "agent/kickout?".$params."&";
        $result = $this->api_query($api,array());
        $status = isset($result["d"]["status"]) ? $result["d"]["status"] :'';
        $result_code = isset($result["code"]) ? $result["code"] : '9999' ;
        if(!empty($result))
        {
            if( $status == true || $result_code== 11 || $result_code == 10)
            {
                return array("status"=>1,"msg"=>"outlogin success");
            }
            else
            {
                return $this->echo_cmd("user_outlogin_error");
            }
        }
        $num += 1;
        return $this->outlogin($num);
    }

    //转入资金接口
    public function in_money($money){
        return $this->in_out_money($money,1);
    }

    /**转出资金接口
     * @param $money
     * @return array|void
     */
    public function out_money($money){
        return $this->in_out_money($money,2);
    }

    /**转入转出资金接口(提供外部使用) 1：转入，2：转出
     * @param $money
     * @param $type
     * @param int $num
     * @return array|string
     */
    public function in_out_money($money, $type, $num = 1){
        if($num > 3){
            return $this->echo_cmd("in_money_error");
        }
        $order_id =  $this->get_order_id();
        $param_arr = array(
            "acc" => $this->game_user["username"],
            "orderid" => $order_id,
            "money" => $money
        );
        $params = "params=".$this->encrypt($param_arr);
        if($type == 1){//转入
            $api_url = "agent/payup?".$params."&";
        }else if($type == 2){//转出
            $api_url = "agent/paydown?".$params."&";
        }else{
            return $this->echo_cmd("in_out_money_number_error");
        }
        $result = $this->api_query($api_url,array());
        $this->log('start',$result);
        $check_money = $this->check_transfer($order_id,$money);
        if($check_money["status"] == 1){
                return array("status"=>1,"platform_order_id"=>$order_id,'data' => '','money' => $check_money['money']);
        }else{
            $num += 1;
            return $this->in_out_money($money, $type,$num);
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
            return $this->echo_cmd("transfer_time_out");
        }
        $params_arr = array(
            "acc" => $this->game_user["username"],
            "orderid" => $order_id
        );
        $params = "params=".$this->encrypt($params_arr);
        $api = "agent/getorderstatus?".$params."&";
        $result = $this->api_query($api,array());
        $this->log('end',$result);
        if(isset($result["d"]["status"]) && $result["d"]["status"] == 3)
        {
            return array(
                "status" => 1,
                "msg" => '',
                "data" => '',
                'money' => abs($result['d']['money']));
        }else
        {
            sleep(1);
            $num += 1;
            return $this->check_transfer($order_id , $money , $num , $result);
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

    /**查询用户资金接口(提供外部使用)
     * @param int $num
     * @return array|void
     */
    public function get_money($num = 1){
        if($num > 3){
            return $this->echo_cmd("get_user_money_out");
        }
        $this->check_info();
        $params_arr = array(
            "acc" => $this->game_user["username"]
        );
        $params = "params=".$this->encrypt($params_arr);
        $api = "agent/getbalance?".$params."&";
        $result = $this->api_query($api,array());
        if(isset($result["code"]) && $result["code"] === 0){
                return array("status"=>1,"balance"=> $result["d"]["balance"]);
        }else{
            $num += 1;
            return $this->get_money($num);
        }
    }

    //获取游戏记录接口
    public function get_log($start_time,$end_time, $num = 1){
        if($num > 3){
            return $this->echo_cmd("get_log_time_out");
        }
        $result = $this->get_log_api($start_time,$end_time);
        return  $result;

    }
    //获取操作日志接口
    private function get_log_api($stime,$etime,$page = 1,$data = array()){
        $page_num = 1000;
        $params_arr = array(
            "expids" => [1,2],
            "stime" => $stime,
            "etime" => $etime,
            "pagenum" => $page_num,
            "page" => $page,
            "esc" => 'esc',
        );
        $params = "params=".$this->encrypt($params_arr);
        $api = "record/loadrecords?".$params."&";
        $result = $this->api_query($api,array());
        $result_message = isset($result["m"]) ? $result["m"]  : "";
        $result_code =  isset($result["code"]) ? $result["code"]  : "";
        if(is_array($result))
        {
            if($result_code == 0 ){
                if(!empty($result["d"]["data"])){
                    $totalPages = ceil($result["d"]["total"]/$page_num);
                    $totalPages = $totalPages==0?1:$totalPages;
                    $data = array_merge_recursive($data,$result["d"]["data"]);
                    if($totalPages >= $result["d"]["curpage"]){
                        return array(
                            "status" => 1,
                            "msg" =>$result_message ,
                            "end_time" => $etime,
                            "data" => $data,
                        );
                    }else{
                        $this->get_log_api($stime,$etime,$result["d"]["curpage"]+1,$data);
                    }
                }else{
                    return array(
                        "status" => 1,
                        "msg" =>$result_message,
                        "end_time" => $etime,
                        "data" => $data,
                    );
                }
            }else{
                return array(
                    "status" => -1,
                    "msg" => $result_code ,
                    "error" => $result_message ,
                    "end_time" => $etime,
                );
            }
        }
        return array(
            "status" => -1,
            "msg" => $result_code ,
            "error" => $result ,
            "end_time" => $etime,
        );
    }

    //获取游戏接口
    public function get_game($game_id = '', $num = 1){
        if($num > 3){
            return $this->echo_cmd("get_user_money_out");
        }
        $api = "agent/loadkind?";
        $result = $this->api_query($api,array());
        if(isset($result["code"]) && $result["code"] === 0){
            return array("status"=>1,"balance"=> $result["d"]);
        }else{
            $num += 1;
            return $this->get_money($num);
        }
    }

    //用户进入游戏一键转入金额接口，整合多接口使用同一函数，如未指定进入的游戏，则进入大厅(提供外部使用)
    public  function user_in_game($money = 0, $game_id = '', $step = 1, $data = array(),$num = 1){
        if($num > 3){
            return $this->echo_cmd("in_money_login_time_out");
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

    //用户退出游戏一键转出金额接口(提供外部使用)
    public function user_out_game($user_money = 0, $step = 1, $num = 1){
        if($num > 3){
            return $this->echo_cmd("out_money_login_time_out");
        }
        if($step == 1){
            $outlogin = $this->outlogin();
            if($outlogin['status'] != 1){
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
                //查询判断是否有余额需要转出并全部转出
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

    //试玩接口
    public function demo($game_id = '', $num = 1){
        return array('status' => 1, 'msg' => "" );
    }

    //加密参数
    private function encrypt($param = ''){
        $method="AES-256-CBC";
        $data = json_encode($param);
        $encode = openssl_encrypt($data, $method, $this->api761_key , OPENSSL_RAW_DATA, $this->iv);
        $base64 = base64_encode($encode);
        $urlEncode = urlencode($base64);
        return $urlEncode;
    }

    public function game_code($code){
       $result =  array('0' => 0,'1' => 1,'101001' => 101,'101002' => 101,'101003' => 101,'101004' => 101,'11001' => 11,'11002' => 11,'11003' =>
            11,'11004' => 11,'11005' => 11,'11006' => 11,'111001' => 111,'111002' => 111,'111003' => 111,'111004' => 111,'121001' =>
            121,'121002' => 121,'121003' => 121,'121004' => 121,'2' => 2,'3' => 3,'300101' => 300,'300102' => 300,'300201' =>
           300,'300202' => 300,'300301' => 300,'300302' => 300,'300303' => 300,'300304' => 300,'31001' => 31,'31002' =>
            31,'31003' => 31,'31004' => 31,'32001' => 32,'32002' => 32,'32003' => 32,'32004' => 32,'33001' => 33,'33002' =>
            33,'33003' => 33,'33004' => 33,'34001' => 34,'34002' => 34,'34003' => 34,'34004' => 34,'400001' => 4000,'400002' =>
            4000,'400003' => 4000,'400004' => 4000,'400005' => 4000,'400006' => 4000,'400007' => 4000,'51001' => 51,'51002' =>
            51,'51003' => 51,'51004' => 51,'52001' => 52,'52002' => 52,'52003' => 52,'52004' => 52,'53001' => 53,'53002' =>
            53,'53003' => 53,'53004' => 53,'54001' => 54,'54002' => 54,'54003' => 54,'54004' => 54,'61001' => 61,'61002' =>
            61,'61003' => 61,'61004' => 61,'62001' => 62,'62002' => 62,'62003' => 62,'62004' => 62,'63001' => 63,'63002' =>
            63,'63003' => 63,'63004' => 63,'64001' => 64,'64002' => 64,'64003' => 64,'64004' => 64,'65001' => 65,'65002' =>
            65,'65003' => 65,'65004' => 65,'66001' => 66,'66002' => 66,'66003' => 66,'66004' => 66,'67001' => 67,'67002' =>
            67,'67003' => 67,'67004' => 67,'81001' => 81,'81002' => 81,'81003' => 81,'81004' => 81,'82001' => 82,'82002' =>
            82,'82003' => 82,'82004' => 82,'9' => 9,'91001' => 91,'91002' => 91,'91003' => 91,'91004' => 91,);
       if(isset($result[$code]))
       {
           return $result[$code];
       }
       return '';
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