<?php

/**bg接口
 * Class ug
 * 最短拉取时间 10秒
 */
class ug extends base_model{
    private $order_id;
    function __construct() {
        parent::__construct();
        //加载ID转CODE类和错误代码类
        //date_default_timezone_set("Etc/GMT+4");
        $this->c('id_to_code');
        $this->c('error');
        $this->platform_id = 8;
        $this->platform_name = 'ug';
        //API接口域名
        $this->api_url = $this->conf['platform'][$this->platform_id]['url'];
        $this->api_url2 = $this->conf['platform'][$this->platform_id]['url1'];
        $this->secretKey = $this->conf['platform'][$this->platform_id]['secretKey'];
        //用户信息
        $this->game_user = array();
        $this->site_id = 0;
        $this->en_site_id = '';
        $this->game_type = 'h5';//默认H5页面，支持H5和APP两个模式
        $this->user_ip = '';//用户IP
        $this->site_url = '';//客户端网站地址，返回使用
        $this->ug_error = array(
            "000000" => "操作成功",
            "000001" => "系统维护中",
            "000002" => "操作权限被关闭",
            "000003" => "IP不在白名单",
            "000004" => "API密码错误",
            "000005" => "系统繁忙",
            "000006" => "查询时间范围越界",
            "000007" => "输入参数错误",
            "000008" => "请求过于频繁",
            "010001" => "会员帐号不存在",
            "100001" => "货币不可用,请联系技术",
            "100002" => "无效帐号,帐号包含无效字符",
            "100003" => "会员帐号已经被使用",
            "100004" => "添加帐号失败",
            "100005" => "货币错误",
            "200001" => "登录操作失败",
            "200002" => "帐号关闭",
            "300001" => "输入存取款金额小于或者等于0",
            "300002" => "存取款失败",
            "300003" => "存款流水号已经存在系统中",
            "300004" => "会员余额不足",
            "300005" => "存取款Key校验不正确",
            "400001" => "存取款流水号不存在",
            "500001" => "修改限额错误",
            "500002" => "佣金级别不存在",
            "600001" => "限额不存在",
            "800001" => "修改会员状态错误",
        );

        //用户名最大最小长度限制
        $this->max_username_len = 16;
        $this->min_username_len = 5;
        $this->game_info = array();//20190625新增
        $this->return_type = 1;
    }

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

    /**   开户接口
     * @param int $num
     * @param string $message
     * @return array
     */
    public function reg($num = 1){
        if($num > 3){
            return $this->echo_cmd('reg_user_error');
        }
        $this->check_info();
        $api_url = $this->api_url.'Register';

        $api_data = array(
            'APIPassword' => $this->secretKey, //登录API秘钥
            'MemberAccount' => $this->game_user['username'],   //会员帐号
            'NickName' => $this->game_user['username'],  //会员昵称,用于显示到用户界面
            'Currency' => 'RMB',   //会员货币
        );

        $data = $this->za->curlPost($api_url, $api_data, 3, 5, '', array(), '', 0);
        $data = $this->xml_parser($data);
        $data_code = isset($data['errcode']) ? $data['errcode'] : "9999";
        if(!empty($data))
        {
            switch($data_code)
            {
                case '000000':
                    return array('status' => 1, 'msg' => 'registered success');
                    break;
                //用户被注册也表示用户已经开户好了，直接返回成功  100003
                case '100003':
                    return array('status' => 1, 'msg' => 'registered success');
                    break;
                default:
                    return $this->echo_cmd('reg_user_error');
            }
        }
        $num += 1;
        return $this->reg($num );
    }


    //登陆接口
    public function login($game_id = '', $num = 1){
        //H5版界面不兼容PC，PC版界面兼容全局，所以使用PC版接口即可
        if($num > 3){
            return $this->echo_cmd('login_user_error');
        }
        $this->check_info();
        $this->outlogin();
        $api_url = $this->api_url.'Login';
        $api_data = array(
            'APIPassword' => $this->secretKey, //登录API密码
            'MemberAccount' => $this->game_user['username'],   //会员帐号
            'GameID' => 1,  //游戏编号 ( 游戏编号= 1 )
            'WebType' => 'Smart',   //网站类型 ( Pc / Smart / Wap )
            'LoginIP' => "",  //会员登录IP
            'Language' => "CH",  //语言
            'PageStyle' => "SP1",
           /* 界面主题 SP1	UG界面  SP2	利记界面 SP3	沙巴界面 SP4	新皇冠界面
           手机版 (Smart)  SP1	蓝色 SP2	灰色SP3	红色 SP4	橘黄色SP5	黑色SP9	皇冠棕色*/
         );
        $data = $this->za->curlPost($api_url, $api_data, 3, 5, '', array(), '', 0);
        $data = $this->xml_parser($data);
        $data_code = isset($data['errcode']) ? $data['errcode'] : "9999";
        if(!empty($data))
        {
            switch($data_code)
            {
                case '000000':
                    return array('status' => 1, 'msg' => $data['result']);
                    break;
                case '010001':
                    $reg = $this->reg();
                    $num += 1;
                    return $this->login($game_id, $num);
                default:
                    $num += 1;
                    return $this->login($game_id, $num);
            }
        }else{
            $num += 1;
            return $this->login($game_id, $num);
        }
    }


    //会员登出接口
    public function outlogin($num = 1 ,$message=''){
        if($num > 3){
            return $this->echo_cmd('user_outlogin_error');
        }
        $this->check_info();
        $api_url = $this->api_url.'Logout';
        $api_data = array(
            'APIPassword' => $this->secretKey, //登录API密码
            'MemberAccount' => $this->game_user['username'],   //会员帐号
            'GameID' => 1,  //游戏编号 ( 游戏编号= 1 )
        );
        $data = $this->za->curlPost($api_url, $api_data, 3, 5, '', array(), '', 0);
        $data = $this->xml_parser($data);
        if(!empty($data)){
            $data_code = isset($data['errcode']) ? $data['errcode'] : "99999999";
            if($data_code == "000000" || $data_code == "010001")
            {
                return array('status' => 1, 'msg' => 'outlogin suceess');
            }else{
                return $this->echo_cmd('user_outlogin_error');
            }
        }else{
            $num += 1;
            return $this->outlogin($num );
        }

    }


    //转入资金接口，部分接口不是同接口互转，所以独立一个函数方便整合，若接口支持同接口互转则不使用该函数，但是必须保留函数名称，防止出错
    //BBIN转入转出接口通用一个，所以该函数可以不使用
    public function in_money($money){
        return 1;
    }

    //转出资金接口，部分接口不是同接口互转，所以独立一个函数方便整合，若接口支持同接口互转则不使用该函数，但是必须保留函数名称，防止出错
    //BBIN转入转出接口通用一个，所以该函数可以不使用
    public function out_money($money){
        return 1;
    }

    /**
     * 生成订单id
     */
    public function set_order_id()
    {
        $Current_ms = round(microtime(true)*1000);
        $this->order_id  =  substr($Current_ms.'_'.$this->game_user['username'],0,100);
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
        $order_id = $this->order_id;
        if($type == 1 )
        {
            $TransferType = "0";
        }
        if($type == 2 )
        {
            $TransferType = 1;
        }
        $api_url = $this->api_url.'Transfer';
        $api_data = array(
            'APIPassword' => $this->secretKey, //登录API密码
            'MemberAccount' => $this->game_user['username'],   //会员帐号
            'SerialNumber' => $order_id,  //流水单号
            'Amount' => $money,   //转账金额
            'TransferType' => $TransferType,  //转账类型;  0:存款到API  1:从API取款
            'Key' => $this->transfer_key($this->game_user['username'],$money),  //验证码: 格式:MD5(APIPassword+MemberAccount+Amount)取后6位 注意:Amount必须是4位小数 例如: f0a3ae129d0685a3073c7c6f5bcc6107test10000.0000 未加密 MD5 前 必须全部小字母
               );
        $data = $this->za->curlPost($api_url, $api_data, 3, 5, '', array(), '', 0);
        $logo_data = array(
            "request_info" => $api_data,
            "return" => $data,
        );
        $log = $this->log('start',$logo_data);
        $result  = $this->check_transfer($money);
        if($result['status'] == 1 ){
                    return array('status' => 1, 'platform_order_id' => $order_id , 'data' => '' ,'money' => $result['money']);
        }else{
            $num += 1;
            return $this->in_out_money($money, $type, $num);
        }
    }

    /**  支付key
     * @param $account
     * @param $Amount
     * @return bool|string
     */
    public function transfer_key($account,$Amount)
    {
        if(empty($account) || is_array($account))
        {
            echo   'account error'; exit;
        }
        return  substr(md5(strtolower($this->secretKey.$account.sprintf('%.4f',$Amount))),-6);
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
        $api_url = $this->api_url.'CheckTransfer';
        $api_data = array(
            'APIPassword' => $this->secretKey, //登录API密码
            'SerialNumber' => $this->order_id,   //会员帐号
        );
        $data = $this->za->curlPost($api_url, $api_data, 3, 5, '', array(), '', 0);
        $logo_data = array(
            "request_info" => $api_data,
            "return" => $data,
        );
        $log = $this->log('end',$logo_data);
        if(!empty($data))
        {
            $data = $this->xml_parser($data);
            $data_code = isset($data['errcode']) ? $data['errcode'] : "99999999" ;
            if($data_code== "000000"){
                return array('status' => 1, 'msg' => 'transfer success' , 'money' => abs($data['result']['Amount']) );
            }else{
                $num += 1;
                return $this->check_transfer( $money , $num , $data);
            }
        }else{
            sleep(1);
            $num += 1;
            return $this->check_transfer( $money , $num , $data);
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
    public function get_money($num = 1 ){
        if($num > 3){
            return $this->echo_cmd('get_user_money_out');
        }
        $this->check_info();
        $api_url = $this->api_url.'GetBalance';
        $api_data = array(
            'APIPassword' => $this->secretKey, //登录API密码
            'MemberAccount' => $this->game_user['username'],   //会员帐号
        );
        $data = $this->za->curlPost($api_url, $api_data, 3, 5, '', array(), '', 0);
        if(!empty($data))
        {
            $data = $this->xml_parser($data);
            $data_code = isset($data['errcode']) ? $data['errcode'] : "99999999" ;
            if($data_code== "000000"){
                return array(
                    'status' => 1,
                    'balance' => $data['result']['Balance'] ,
                    'deny_balance' => '0',
                    );
            }else{
                return $this->echo_cmd('get_user_money_out');
            }
        }else{
            $num += 1;
            return $this->get_money($num );
        }
    }



    //获取记录接口
    public function get_log($last_id = '', $num = 1 ,$error=''){
        if($num > 3 ){
            return array(
                'status' => -1,
                'msg' => '采集失败',
                'error' => $error,
                'end_id' => $last_id,
                'end_time' => '',
            );
        }
        if($last_id=='')
        {
            $last_id = '0';
        }
        $api_url = $this->api_url2.'GetBetSheetBySort';
        $api_data = array(
            'APIPassword' => $this->secretKey, //登录API密码
              //'SortNo' => "44749482",   //最小排序编号 ( 返回>Sort结果) 每个注单都有对应的Sort No
            'SortNo' => $last_id,   //最小排序编号 ( 返回>Sort结果) 每个注单都有对应的Sort No
            'Rows' => "1000",   //返回数据行数 (条数), 当<=0时,Rows=1000
        );

        $data = $this->za->curlPost($api_url, $api_data, 3, 5, '', array(), '', 0);
        $data = $this->xml_parser($data);
        $data_message = isset($this->ug_error[$data['errcode']]) ? $this->ug_error[$data['errcode']] : "default message" ;
        if(!empty($data) ){
            if($data['errcode'] ==  "000000"){
                $return = array('status' => 1, 'msg' => '采集成功', 'end_time' => 0, 'end_id' => 0, 'end_page' => '', 'data' => array());
                if(!empty($data['result']['bet'])){
                    if(count($data['result']['bet']) == count($data['result']['bet'],1) )
                    {
                        $return['data'][] = $data['result']['bet'];
                        $ug_log_endtime = strtotime($data['result']['bet']['BetDate']);
                        $ug_log_end_id = $data['result']['bet']['SortNo'];
                    }else{
                        foreach($data['result']['bet'] as $k => $v){
                            $return['data'][] = $v;
                        }
                        $ug_log_endtime = strtotime(end($data['result']['bet'])['BetDate']);
                        $ug_log_end_id = end($data['result']['bet'])['SortNo'];
                    }
                }
                $return['end_time']       = isset($ug_log_endtime)  ? $ug_log_endtime   : $_SERVER['time'];
                $return['end_id']         = isset($ug_log_end_id)   ? $ug_log_end_id    : $last_id;
                return $return;
            }else{
                $num += 1;
                return $this->get_log($last_id ,$num,$data_message);
            }

        }else{
            $num += 1;
            return $this->get_log($last_id ,$num,$data_message);
        }

    }

    private function xml_parser($str){
        $xml_parser = xml_parser_create();
        if(xml_parse($xml_parser,$str)){
            return (json_decode(json_encode(simplexml_load_string($str)),true));
        }else {
            return false;
        }
    }


    //获取游戏接口
    public function get_game($game_id = '', $num = 1){
        if($num > 3){
            return $this->echo_cmd('get_game_time_out');
        }
        $this->check_info();
        $api = "/api/log/category";//要抓取数据的页面地址
        $api_data = array();
        $data = $this->api_query($api, $api_data);
        if(isset($data['success'])){
            if($data['success'] == 1){
                $game_list = array();
                foreach($data['info']['list'] as $k => $v){
                    if($v['IsOpen'] == 1){
                        $game_list[] = array(
                            'id' => $v['ID'],
                            'name' => $v['Name'],
                            'pic' => $v['Avatar'],
                        );
                    }
                }
                return array('status' => 1, 'msg' => $game_list);
            }else{
                $num += 1;
                return $this->get_game($num);
            }
        }else{
            $num += 1;
            return $this->get_game($num);
        }
    }

    //进入游戏
    public function go_game($gamekind = 3, $gametype = 3001, $gamecode = 1, $num = 1){
        //H5页面不适配电脑与应用，全面使用PC页面，可以适配WAP
        if($num > 3){
            return $this->echo_cmd('get_game_time_out');
        }
        $this->check_info();

        $login = $this->login();
        $api_key = '05Rz1lv';

        $api = "/PlayGame";
        $api_data = array(
            'website' => $this->website,
            'username' => $this->game_user['username'],
            'gamekind' => $gamekind,
            'gametype' => $gametype,
            'gamecode' => $gamecode,
            'lang' => 'zh-cn',
            'key' => 'sdfqfrxo'.md5($this->website.$this->game_user['username'].$api_key.date("Ymd", time())).'qwertyue',
        );
        //}
        $api = $this->bbin_api2_url.$api.'?'.http_build_query($api_data);
        $data = $this->api_query($api, $api_data, 2);

        if(isset($data['result'])){
            if($data['success'] == 1){
                $game_list = array();
                foreach($data['info']['list'] as $k => $v){
                    if($v['IsOpen'] == 1){
                        $game_list[] = array(
                            'id' => $v['ID'],
                            'name' => $v['Name'],
                            'pic' => $v['Avatar'],
                        );
                    }
                }
                return array('status' => 1, 'msg' => $game_list);
            }else{
                $num += 1;
                return $this->get_game($num);
            }
        }else{
            $num += 1;
            return $this->get_game($num);
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
                $set_order_id = $this->set_order_id();
                $in_money = $this->in_out_money($money, 1);
                if($in_money['status'] == 1){
                    $data['money'] = $money;
                    $data['orders_number'] = $in_money['platform_order_id'];
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
                //查询判断是否有余额需要转出并全部转出
                $set_order_id = $this->set_order_id();
                $out_money = $this->in_out_money($user_money, 2);
                if($out_money['status'] != 1){
                    $num += 1;
                    return $this->user_out_game($user_money, 1, $num);
                }
            }
        }
        $return = array(
            'status' => 1,
            'money' => $user_money,
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
        $api = "/api/user/guest";//要抓取数据的页面地址
        $api_data = array();
        $data = $this->api_query($api, $api_data);
        if(isset($data['success'])){
            if($data['success'] == 1){
                return array('status' => 1, 'msg' => $data['info']['Url']);
            }else{
                $num += 1;
                return $this->demo($game_id, $num);
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