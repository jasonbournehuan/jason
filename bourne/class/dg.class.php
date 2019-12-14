<?php
/**
 * Class dg视讯接口
 * 最短拉取时间10秒 超过24小时的数据默认不推送，需要通知对方重新推送才能获取
 */
class dg extends base_model{
    private $order_id;
    function __construct() {
        parent::__construct();
        //网站ID
        $this->platform_id = 7;
        $this->platform_name = 'DG';
        //API接口域名
        $this->api_url = $this->conf['platform'][$this->platform_id]['url'];
        //API授权信息
        $this->api_key = $this->conf['platform'][$this->platform_id]['key'];
        $this->agent = $this->conf['platform'][$this->platform_id]['agent'];
        //加载ID转CODE类和错误代码类
        $this->c('id_to_code');
        $this->c('error');
        //用户信息
        $this->game_user = array();
        $this->site_id = 0;
        $this->en_site_id = '';
        $this->game_type = 'h5';//默认H5页面，支持H5和APP两个模式
        $this->user_ip = '';//用户IP
        $this->site_url = '';//客户端网站地址，返回使用
        //用户名最大最小长度限制
        $this->max_username_len = 16;
        $this->min_username_len = 5;
        $this->game_info = array();//20190625新增
        $this->return_type = 1;
    }

    /**检测接口需求信息，转换用户用等数据
     * @return array|string
     */
    public function check_info(){
        if(empty($this->game_user)){
            return $this->echo_cmd('user_empty');
        }else if(empty($this->site_id)){
            return $this->echo_cmd('site_empty');
        }
    }

    /**通用递交接口
     * @param $api
     * @param $data
     * @return mixed
     */
    public function api_query($api, $data){
        $url = $this->api_url.$api.'/'.$this->agent.'/';
        $random = $this->za->make_code(rand(10,40));
        $token = md5($this->agent.$this->api_key.$random);
        $param = array(
            "token"=>$token,
            "random"=>$random
        );
        $data = json_encode(array_merge($param,$data));
       /* $info = $this->za->curlPost($url,$data,3,5, '', array('Content-Type:application/json','Content-Length: '.strlen($data)));*/
        $info = $this->za->post($url,$data, array('Content-Type:application/json','Content-Length: '.strlen($data)));
        $result = json_decode($info,true);
        return $result;
    }

    /**开户接口
     * @param int $num
     * @return array|string
     */
    public function reg($num = 1){
        if($num > 3){
            return $this->echo_cmd('reg_user_error');
        }
        $this->check_info();
        $api_url = '/user/signup';
        $param = array(
            "data" => "A",
            "member" => array(
                "username" => $this->game_user["username"],
                "password" => $this->game_user["password"],
                "currencyName" => "CNY",
                "winLimit" => 0
            )
        );
        $result = $this->api_query($api_url,$param);
        if(isset($result['codeId'])){
            switch($result['codeId'])
            {
                case '0':
                    return array("status"=>1,"msg"=>'registered success');
                    break;
                case 116:  //116 账户名已经注册过
                    return array("status"=>1,"msg"=>'registered success');
                    break;
                case 400:
                    return $this->echo_cmd('ip_no');
                    break;
                default:
                    $num += 1;
                    return $this->reg($num);
            }
        }else{
            $num += 1;
            return $this->reg($num);
        }
    }

    /*登陆接口
     * @param type 0 pc、1 wap
     */
    public function login($game_id = '', $num = 1, $type = 0){
        if($num > 3){
            return $this->echo_cmd('login_user_error');
        }
        $this->check_info();
        $api_url = '/user/login';
        $param = array(
            "lang" => "cn",
            "member" => array(
                "username" => $this->game_user["username"],
                "password" => $this->game_user["password"]
            )
        );
        $result = $this->api_query($api_url,$param);
        $num += 1;
        if(isset($result['codeId'])){
            switch($result['codeId'])
            {
                case '0':
                    return array("status"=>1,"msg"=>$result['list'][$type].$result['token'].'&language=cn');
                    break;
                case 102:
                    $this->reg();
                    return $this->login($game_id,$num);
                    break;
                default:
                    return $this->login($game_id,$num);
                    break;
            }
        }else{
            return $this->login($game_id,$num);
        }
    }

    /**退出接口，有则接入，无则直接返回成功 $step 0停用账户 1启用账户
     * @param int $num
     * @param int $step
     * @return array|string
     */
    public function outlogin($num = 1,$step = 0){
        if($num > 3){
            return $this->echo_cmd('user_outlogin_error');
        }
        $this->check_info();
        $api_url = '/user/update';
        $param = array(
            "member" => array(
                "username" => $this->game_user["username"],
                "password" => md5($this->game_user["password"]),
                "winLimit" => 0.0,
                "status" => $step
            )
        );
        $result = $this->api_query($api_url,$param);
        if(isset($result["codeId"])){
            if($result["codeId"] == 0){
                if($step == 0){
                    $step++;
                    //sleep(5);
                    return $this->outlogin(1,$step);
                }else if($step == 1){
                    return array("status"=>1,"msg"=>"outlogin success");
                }
            }else{
                $num ++;
                return $this->outlogin($num,$step);
            }
        }else{
            $num ++;
            return $this->outlogin($num,$step);
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
    public function set_order_id()
    {
        $Current_ms = round(microtime(true)*1000);
        $this->order_id  =  substr($Current_ms.'_'.$this->game_user['username'],0,35);
    }


    //转入资金接口，部分接口不是同接口互转，所以独立一个函数方便整合，若接口支持同接口互转则不使用该函数，但是必须保留函数名称，防止出错
    //泛亚转入转出接口通用一个，所以该函数可以不使用
    public function in_money($money){
        return $this->in_out_money($money,1);
    }

    //转出资金接口，部分接口不是同接口互转，所以独立一个函数方便整合，若接口支持同接口互转则不使用该函数，但是必须保留函数名称，防止出错
    //泛亚转入转出接口通用一个，所以该函数可以不使用
    public function out_money($money){
        return $this->in_out_money($money,2);
    }

    //转入转出资金接口 1：转入，2：转出
    public function in_out_money($money, $type, $num = 1){
        if($num > 3){
            return $this->echo_cmd('in_out_money_error');
        }
        if($type == 1){
            $money_type = '';
        }else{
            $money_type = '-';
        }
        $api_url = '/account/transfer';
        //转账流水号
        $order_id = $this->order_id;
        $param = array(
            'data' => $order_id,
            'member' => array(
                'username' =>  $this->game_user["username"],
                'amount' => $money_type.$money
            )
        );
        $result = $this->api_query($api_url,$param);
        $logo_data = array(
            "request_info" => $param,
            "return" => $result,
        );
        $log = $this->log('start',$logo_data);
        $check_result = $this->check_transfer($money);
        if($check_result['status'] == 1 ){
            return array("status"=>1,'platform_order_id' => $order_id , 'data'=>'' , 'money' => $money);
        }else{
            $num ++;
            return $this->in_out_money($money, $type, $num);
        }
    }


    /**查询转账接口
     * @param int $num
     * @param string $data
     * @return array|string
     */
    public function check_transfer( $money , $num = 1 , $data = ''){
        if($num > 20){
            $this->za->login_log($this->game_user['id'],$this->game_user['site_id'],'',$money,$this->order_id,$data,4,$this->platform_id,$this->game_info['id'],$this->game_user['order_id']);
            return $this->echo_cmd('transfer_time_out');
        }
        $api_url = '/account/checkTransfer';
        $param = array(
            'data' => $this->order_id
        );
        $result = $this->api_query($api_url,$param);
        $logo_data = array(
            "request_info" => $param,
            "return" => $result,
        );
        $log = $this->log('end',$logo_data);
        if(isset($result["codeId"]) && $result["codeId"] == '0')
        {
            return array("status"=>1,'msg' => 'transfer success');
        }else{
            sleep(1);
            $num ++;
            return $this->check_transfer( $money , $num , $result);
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


    /**查询用户资金接口
     * @param int $num
     * @return array|string
     */
    public function get_money($num = 1){
        if($num > 3){
            return $this->echo_cmd('get_user_money_out');
        }
        $this->check_info();
        $api_url = '/user/getBalance';
        $param = array(
            'member' => array('username' => $this->game_user["username"])
        );
        $result = $this->api_query($api_url,$param);
        $num ++;
        if(isset($result["codeId"])){
            if($result["codeId"] == 0){
                return array(
                    "status"=>1,
                    'balance' => $result["member"]['balance'],
                    'deny_balance' => '0',
                    );
            }else{
                return $this->get_money($num);
            }
        }else{
            return $this->get_money($num);
        }
    }

    //获取记录接口
    public function get_log( $num = 1,$code ='' , $message =""){
        if($num > 3){
            $return = array(
                "system" => $this->error->code('get_log_time_out'),
                "code"   => $code,
                "message"   => $message,
            );
            $this->echo_cmd($return);
        }
        $api_url = '/game/getReport';
        $param = array();
        $result = $this->api_query($api_url,$param);
        $code = isset($result['codeId']) ? $result['codeId'] : '';
        $message = isset($result['data']) ? $result['data'] : '';
        if($code === 0){
            if(!empty($result['list']))
            {
                $list = array();
                $old_ids = array();
                    foreach ($result["list"] as $k => $v){
                        $v['winOrLoss'] = $v['winOrLoss'] - $v['betPoints'];
                        $list[] = $v;
                        $old_ids[json_encode($v['id'])] = 1;
                    }
            }else{
                $list    = '';
                $old_ids = '';
            }
            return array("status"=>1,'msg' => '获取数据成功','data' => $list, 'ids_list'=>$old_ids);
        }else{
            $num ++;
            return $this->get_log($num, $code , $message);
        }
    }

    //标记注单记录
    public function markReport($list,$num = 1){
        if($num > 3){
            return array("status"=>-1,'msg' => '标记失败');
        }
        $api_url = '/game/markReport';
        $param = array(
            'list' => array_keys($list)
        );
        $result = $this->api_query($api_url,$param);
        $num ++;
        if(isset($result["codeId"])){
            if($result["codeId"] == 0){
                return array("status"=>1,'msg' => '标记成功');
            }else{
                return $this->markReport($list,$num);
            }
        }else{
            return $this->markReport($list,$num);
        }
    }

    //获取游戏接口
    public function get_game($game_id = '', $num = 1){
        return 1;
    }

    //用户进入游戏一键转入金额接口，整合多接口使用同一函数，如未指定进入的游戏，则进入大厅
    public function user_in_game($money = 0, $game_id = '', $step = 1, $data = array(), $num = 1){
        if($num > 3){
            return $this->echo_cmd('in_money_login_time_out');
        }
        $num += 1;
        if($step == 1){
            $login = $this->login();
            if($login['status'] == 1){
                $data = $login;
                $step = 2;
            }else{
                return $this->user_in_game($money, $game_id, $step, $data, $num);
            }
        }
        $data['money'] = 0;
        $data['orders_number'] = '';
        if($step == 2){
            if($money > 0){
                $amount = $this->check_money($money);
                $set_order_id = $this->set_order_id();
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
                    return $this->user_out_game($user_money, $step, $num);
                }
                $user_money = $money['balance'];
            }
            if($user_money > 0){
                //查询判断是否有余额需要转出并全部转出
                $set_order_id = $this->set_order_id();
                $out_money = $this->in_out_money($user_money, 2);
                if($out_money['status'] != 1){
                    $num += 1;
                    return $this->user_out_game($user_money, $step, $num);
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
            'deny_balance' =>  '0',
        );
        return $return;
    }

    //试玩接口，暂时不使用
    public function demo($game_id = '', $num = 1){
        if($num > 3){
            return $this->echo_cmd('demo_time_out');
        }
        $this->check_info();
        $api = "/user/free";//要抓取数据的页面地址
        $api_data = array(
            'lang' => 'cn',
            'device' => '5'
        );
        $data = $this->api_query($api, $api_data);
        if(isset($data['codeId'])){
            if($data['codeId'] == 0){
                return array('status' => 1, 'msg' => $data['list'][1].$data['token'].'&language=cn');
            }else{
                $num += 1;
                return $this->demo($game_id, $num);
            }
        }else{
            $num += 1;
            return $this->demo($game_id, $num);
        }
    }

    /*
     * 转换用户信息
     */
    public function check_user($user_data){
        $this->c('user');
        $id = $user_data['site_id'].sprintf("%011s",$user_data['uid']);
        $user_list = $this->user->get($id);
        if(empty($user_list)){
            //用户不存在，则入库用户数据
            $en_username = $this->id_to_code->en_username($user_data['site_id'], $user_data['uid'], $this->min_username_len, $this->max_username_len);
            $user_data['password'] = md5($user_data['site_id'].$en_username.$user_data['old_username']);
            $user_data['username'] = $en_username;
            $user_data['add_time'] = $user_data['end_time'] = $_SERVER['time'];
            $user_data['id']  =  $id;
            $user_data['money']  =  '';
            $user_data['platform_log']  =  '';
            $user_data['balance']  =  '';
            if($this->user->add_list($user_data)!= 1)
            {
                return $this->echo_cmd('reg_user_error');
            }
        }else{
            $ip = $user_data['ip'];
            $user_data = $user_list;
            $user_data['ip'] = $ip;
        }
        $user_data['username'] = 'dg_'.$user_data['username'];
        return  $this->game_user = $user_data;
    }

    //账号解密
    public function de_username($en_username){
        $username = substr($en_username,strpos($en_username,'_')+1);
        $de_username = $this->id_to_code->de_username(strtolower($username));
        return $de_username;
    }

    //错误码转换
    private function error($errid){
        $arr = array(
            4 => 'illeage_error',
            97 => 'no_authority',
            100 => 'user_frozen',
            102 => 'user_nothing',
            103 => 'user_used',
            120 => 'user_money_insufficient',
            300 => 'platform_maintain',
            324 => 'in_out_money_error',
            400 => 'ip_no',
            406 => 'time_out',
            501 => 'platform_error',
            502 => 'platform_error'
        );
        if(!isset($arr[$errid])){
            $arr[$errid] = 'platform_error';
        }
        return $this->echo_cmd($arr[$errid]);
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