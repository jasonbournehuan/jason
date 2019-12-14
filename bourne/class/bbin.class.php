<?php

/** BBIN接口
 * Class bbin
 * 最短拉取时间 无间隔
 */
class bbin extends base_model{
    private $order_id;
    function __construct() {
        parent::__construct();
        //BBIN使用美东时间
        date_default_timezone_set("Etc/GMT+4");
        $this->platform_id = 3;
        $this->platform_name = 'BBIN';
        //加载ID转CODE类和错误代码类
        $this->c('id_to_code');
        $this->c('error');
        //API接口域名
        $this->bbin_api_url = $this->conf['platform'][$this->platform_id]['url'];
        $this->bbin_api2_url = $this->conf['platform'][$this->platform_id]['url1'];
        //API授权信息
        $this->fanya_Authorization = $this->conf['platform'][$this->platform_id]['Authorization'];
        //用户信息
        $this->game_user = array();
        //网站ID
        $this->site_id = '';
        $this->en_site_id = '';
        $this->game_type = 'h5';//默认H5页面，支持H5和APP两个模式
        $this->user_ip = '';//用户IP
        $this->site_url = '';//客户端网站地址，返回使用
        $this->website = $this->conf['platform'][$this->platform_id]['website'];//网站，应该是泛亚的
        $this->uppername = $this->conf['platform'][$this->platform_id]['uppername'];//代理账号
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

    //通用递交接口
    public function api_query($api, $data, $apiid = '', $result_type = 1, $view_info = 0){
        if(!empty($apiid)){
            $url = $this->bbin_api2_url.$api;//登录游戏的页面地址
        }else{
            $url = $this->bbin_api_url.$api;//要抓取数据的页面地址
        }
        $info = $this->za->curlPost($url, $data, 3, 5, '', array(), '', $view_info);//请求接口数据
        if($result_type == 1){
            $data = json_decode($info, true);
            return $data;
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
        $amount = intval($money);
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
        $this->order_id  =   substr($Current_ms.$this->site_id.$this->game_user['uid'],0,19) ;
    }


    //开户接口
    public function reg($num = 1){
        if($num > 3){
            return $this->echo_cmd('reg_user_error');
        }
        $this->check_info();
        $api_key = '3QcgFxyY0';//api keyB
        $api = "/CreateMember";//api接口
        $api_data = array(
            'website' => $this->website,
            'username' => $this->game_user['username'],
            'uppername' => $this->uppername,
            'key' => 'qwertyu'.md5($this->website.$this->game_user['username'].$api_key.date("Ymd", time())).'x',
        );
        $data = $this->api_query($api, $api_data);
        if(isset($data['result']))
        {
            $data_code = isset($data['data']['Code']) ? $data['data']['Code'] : '9999';
            if($data_code == '21100' or $data_code == '21001'){
                //用户被注册也表示用户已经开户好了，直接返回成功
                return array('status' => 1, 'msg' => 'registered success');
            }else{
                return $this->echo_cmd('reg_user_error');
            }
        }
        $num += 1;
        return $this->reg($num);
    }

    //转换游戏ID
    public function id_to_gameid($game_id = ''){
        $new_game_id = '';
        $game_id_list = array(
            '3' => 'live',//3：BB视讯
            '5' => 'game',//5：BB电子
            '19' => 'live',//19：AG视讯
            '20' => 'pt',//20：PT电子
            '22' => 'live',//22：欧博视讯
            '23' => 'mg',//23：MG电子
            '24' => 'live',//24：OG视讯
            '27' => 'live',//27：GD视讯
            '28' => 'gns',//28：GNS电子
            '29' => 'isb',//29：ISB电子
            '32' => 'game',//32：HB电子
            '36' => 'live',//36：BG视讯
            '37' => 'game',//37：PP电子
            '39' => 'game',//39：JDB电子
            '40' => 'game',//40：AG电子
        );
        if(!empty($game_id_list[$game_id])){
            $new_game_id = $game_id_list[$game_id];
        }
        return $new_game_id;
    }

    //进入指定游戏
    public function login_5($num = 1){
        $api_key = '05Rz1lv';//api keyB
        $exp_query = explode("_", $this->game_info['query_info']);
        if(empty($exp_query[2])){
            return $this->echo_cmd('game_maintain');
        }
        $api = "/ForwardGameH5By".$exp_query[2];//api接口，
        $api_data = array(
            'website' => $this->website,
            'username' => $this->game_user['username'],
            'uppername' => $this->uppername,
            'gametype' => '',
            'lang' => 'zh-cn',
            'key' => 'qwertyus'.md5($this->website.$this->game_user['username'].$api_key.date("Ymd", time())).'xgddfrax',
        );
        if(!empty($exp_query[1])){
            $api_data['gametype'] = $exp_query[1];
        }

        $url = $this->bbin_api2_url.$api.'?'.http_build_query($api_data);
        return json_encode(array('status' => 1, 'msg' => $url));
    }

    //进入大厅  真人進入大廳
    public function login_3($num = 1){
        $api_key = 'fV98jAu';//api keyB
        $api = "/Login";//api接口，
        $api_data = array(
            'website' => $this->website,
            'username' => $this->game_user['username'],
            'uppername' => $this->uppername,
            'lang' => 'zh-cn',
            //Login时需要以下参数，返回内容为网页表单代码
            'page_site' => '',
            'page_present' => '',
            'maintenance_page' => 0,
            'key' => 'qwertyus'.md5($this->website.$this->game_user['username'].$api_key.date("Ymd", time())).'x',
        );
        $exp_query = explode("_", $this->game_info['query_info']);
        if(!empty($exp_query[1])){
            $api_data['page_site'] = $exp_query[1];
        }
        if(!empty($exp_query[2])){
            $api_data['page_present'] = $exp_query[2];
        }
        if(!empty($exp_query[3])){
            $api_data['maintenance_page'] = $exp_query[3]; //0:维护时回传讯息、1:维护时导入整合页(预设为0)
        }
        $url = $this->bbin_api2_url.$api.'?'.http_build_query($api_data);
        return json_encode(array('status' => 1, 'msg' => $url));
    }

    //登陆接口
    public function login($game_id = '', $num = 1){
        //H5版界面不兼容PC，PC版界面兼容全局，所以使用PC版接口即可
        if($num > 3){
            return $this->echo_cmd('login_user_error');
        }
        $this->check_info();
        $this->login2();
        $exp_query = explode("_", $this->game_info['query_info']);
        if(!empty(method_exists($this, 'login_'.$exp_query[0]))){
            $method_name = 'login_'.$exp_query[0];
            return $this->$method_name();
        }else{
            echo json_encode("require query_info");exit;
        }
    }


    /** PlayGame  进入指定游戏
     * @param int $num
     * @return array|false|string
     */
    public function login_4($num = 1){
        $api_key = '05Rz1lv';//api keyB
        $exp_query = explode("_", $this->game_info['query_info']);
        $api = "/PlayGame";//api接口，
        $api_data = array(
            'website' => $this->website,
            'username' => $this->game_user['username'],
            'gamekind' => 5,
            'gamecode' => '', //请详查附件三(gamekind=3时，需强制带入)
            'lang' => 'zh-cn',
            'key' => strtolower('qwertyus'.md5($this->website.$this->game_user['username'].$api_key.date("Ymd", time())).'xgddfrax'),
        );
        if(!empty($exp_query[1])){
            $api_data['gametype'] = $exp_query[1];
        }
        $url = $this->bbin_api2_url.$api.'?'.http_build_query($api_data);
        return json_encode(array('status' => 1, 'msg' => $url));
    }


    //登陆接口
    public function login2($num = 1){
        if($num > 3){
            return $this->echo_cmd('login_user_error');
        }
        $api_key = 'fV98jAu';//api keyB
        $api = "/Login2";//api接口，
        $api_data = array(
            'website' => $this->website,
            'username' => $this->game_user['username'],
            'uppername' => $this->uppername,
            'lang' => 'zh-cn',
            'key' => 'qwertyus'.md5($this->website.$this->game_user['username'].$api_key.date("Ymd", time())).'x',
        );
        $data = $this->api_query($api, $api_data, 2);
        if(isset($data['result'])){
            if($data['data']['Code'] == '99999'){
                return array('status' => 1, 'msg' => '');
            }else{
                $num += 1;
                return $this->login2($num);
            }
        }else{
            $num += 1;
            return $this->login2($num);
        }
    }

    //退出接口，有则接入，无则直接返回成功
    public function outlogin($num = 1){
        if($num > 3){
            return $this->echo_cmd('user_outlogin_error');
        }
        $this->check_info();
        $api_key = 'x2b7x';//api keyB
        $api = "/Logout";//api接口，
        $api_data = array(
            'website' => $this->website,
            'username' => $this->game_user['username'],
            'key' => 'qwertyu'.md5($this->website.$this->game_user['username'].$api_key.date("Ymd", time())).'xwsawq',
        );
        $data = $this->api_query($api, $api_data);
        if(isset($data['result'])){
            if($data['data']['Code'] == '22001' or $data['data']['Code'] == '22000'){
                return array('status' => 1, 'msg' => 'outlogin success');
            }else{
                $num += 1;
                return $this->outlogin($num);
            }
        }else{
            $num += 1;
            return $this->outlogin($num);
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

    //转入转出资金接口
    public function in_out_money($money, $type, $num = 1){
        if($num > 3){
            return $this->echo_cmd('in_out_money_error');
        }
        if($money <= 0){
            return $this->echo_cmd('in_out_money_number_error');
        }else if($money != intval($money)){
            return $this->echo_cmd('money_not_integer');
        }
        if($type == 1){
            $in_out_type = 'IN';
        }else{
            $in_out_type = 'OUT';
        }
        $api_key = '10WyHdOdZ';
        $api = "/Transfer";//api接口
        //订单号使用1-19位数字，所以与其他不同，不可直接加密
        $order_id = $this->order_id;
        $api_data = array(
            'website' => $this->website,
            'uppername' => $this->uppername,
            'username' => $this->game_user['username'],
            'key' => 'qwertyuyc'.md5($this->website.$this->game_user['username'].$order_id.$api_key.date("Ymd", time())).'xwsq',
            'remit' => $money,
            'action' => $in_out_type,
            'remitno' => $order_id,
        );
        $data = $this->api_query($api, $api_data);
        $logo_data = array(
            "request_info" => $api_data,
            "return" => $data,
        );
        $log = $this->log('start',$logo_data);
        $check_money = $this->check_transfer($money);
        if($check_money['status'] == 1 ){
            return array('status' => 1, 'platform_order_id' => $order_id , 'data' => '','money'
            => $money );
        }else{
            $num += 1;
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
        $api_key = '5Jr57Ya8c7';
        $api = "/CheckTransfer";//api接口
        $api_data = array(
            'website' => $this->website,
            'transid' => $this->order_id,
            'key' => 'qwertyuc'.md5($this->website.$api_key.date("Ymd", time())).'xwsqfasb',
        );
        $data = $this->api_query($api, $api_data);
        $api_data['old_key'] = 'qwertyuc'.$this->website.$api_key.date("Ymd", time()).'xwsqfasb';
        $logo_data = array(
            "request_info" => $api_data,
            "return" => $data,
        );
        $log = $this->log('end',$logo_data);
        if(isset($data['data']['Status']) && $data['data']['Status'] == '1'){
            return array('status' => $data['data']['Status'], 'msg' => '', 'data' => '');
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
        date_default_timezone_set('Asia/Shanghai');
        $this->za->make_log($this->platform_id.'_'.$this->game_user['uid'],time(),$type,json_encode($data),"transfer");
        date_default_timezone_set("Etc/GMT+4");
    }

    //查询用户资金接口
    public function get_money($num = 1){
        if($num > 3){
            return $this->echo_cmd('get_user_money_out');
        }
        $this->check_info();
        $api_key = '7pxyd9c0a';//api keyB
        $api = "/CheckUsrBalance";//api接口
        $api_data = array(
            'website' => $this->website,
            'username' => $this->game_user['username'],
            'uppername' => $this->uppername,
            'page' => 1,
            'pagelimit' => 100,
            'key' => 'sdfq'.md5($this->website.$this->game_user['username'].$api_key.date("Ymd", time())).'qwertyu',
        );
        $data = $this->api_query($api, $api_data);
        if(isset($data['result'])){
            if(!empty($data['data'])){
                if(isset($data['data'][0]['Balance'])){
                    //Balance:额度,TotalBalance:总额度，具体确定使用哪个，pagination为列表记录，暂时不知道作用
                    return array(
                        'status' => 1,
                        'balance' => intval($data['data'][0]['Balance']),
                        'deny_balance' => $data['data'][0]['Balance'] - intval($data['data'][0]['Balance']),
                    );
                }else if(isset($data['data']['Code']) and $data['data']['Code'] == '22002'){
                    return $this->echo_cmd('user_nothing');
                }else{
                    $num += 1;
                    return $this->get_money($num);
                }
            }else{
                $num += 1;
                return $this->get_money($num);
            }
        }else{
            $num += 1;
            return $this->get_money($num);
        }
        return $data;
    }

    //获取记录接口最后记录时间缓存，如果不存在就转入数据库读取
    public function get_log_cache($game_id){
        $this->c('cache_redis');
        $this->c('endlog');
        $this->cache_redis->select($this->conf['redis_db']);

        $start_time =  '';
        $page = 1;
        $end_log_id = '';
        $total_page = '';
        $cache_name = 'bbin_get_log_cache_'.$game_id;
        $cache = $this->cache_redis->kGet($cache_name);

        if(!empty($cache_log) && $cache_log != 'false'){
            $json = json_decode($cache,true);
            $end_log_data = explode('_',$json['log_end_info']);
            $start_time =  $json['up_time'];
            $page =  $end_log_data['0'];
            $total_page = isset($end_log_data['1']) ?  $end_log_data['1'] :  '';
            $end_log_id = isset($end_log_data['2'])   ? $end_log_data['2'] : '';

        }else{
            $data = $this->endlog->get($game_id);
            if(!empty($data)){
                $json = explode('_',$data['log_end_info']);
                $start_time =  $data['up_time'];
                $page =  isset($json['0']) ? $json['0']  :  '';
                $total_page = isset($json['1']) ? $json['0']  :  '';
                $end_log_id = isset($json['2']) ? $json['0']  :  '';

            }else
            {
                $start_time =  $_SERVER['time'] - 86400;
                $page =  '';
                $total_page = '';
                $end_log_id = '';
            }

        }

        return array('start_time' => $start_time ?  $start_time : '00:00:00', 'page' => $page, 'end_log_id' => $end_log_id, 'total_page' => $total_page,
            "starttime" => $start_time ?  $start_time : '00:00:00');
    }

    //视讯投注记录格式化
    public function format_log_3($data){
        $new_data = array();
        $de_username = $this->id_to_code->de_username($data['UserName']);
        if(!empty($de_username)){
            $exp_username = explode('-', $de_username);
            $new_data = array(
                'site_id' => $exp_username[0],
                'uid' => $exp_username[0],
                'platform_id' => $this->platform_id,
                'game_id' => $data[''],
                'money' => $data['BetAmount'],
                'win_money' => $data['Payoff'],
                'game_time' => strtotime($data['WagersDate']),
                'infos' => json_encode($data),
                'game_info' => $data[''],
                'order_id' => $data['WagersID'],
                'bet_money' => $data['Commissionable'],
                'up_time' => strtotime($data['ModifiedDate']),
            );
        }
        return $new_data;
    }

    //电子投注记录格式化
    public function format_log_5($data){
        $new_data = array();
        return $new_data;
    }

    //获取记录接口
    public function get_log($game_id = '',$GameKind ,$subgamekind = '1' ,$gametype = "0" , $num = 1 ,$error=''){
        if($num > 3){
            return array(
                'status' => -1,
                'msg' => '采集失败',
                'error' => $error,
                'end_time' => '',
            );
        }
        $log_cache = $this->get_log_cache($game_id);
        $api_key = '6kqBB1';//api keyB

        $rounddate = $log_cache['start_time'] ? $log_cache['start_time'] : $_SERVER['time'];
        if($_SERVER['time'] - $rounddate > 604800)
        {
            $rounddate = $_SERVER['time'] - 86400;
        }
        $api = "/BetRecord";//api接口
        $api_data = array(
            'website' => $this->website,
            'username' => '',
            'uppername' => $this->uppername,
            'rounddate' => date('Y-m-d',$rounddate),
            'starttime' => date("H:i:s",$rounddate+1),
            'endtime' => date("H:i:s",$rounddate+3601),
            'gamekind' => $GameKind, //游戏种类(1：BB体育、3：BB视讯、5：BB电子、12：BB彩票、
            'subgamekind' => $subgamekind, //(gamekind=5时，值:1、2、3、5，预设为1)
            'gametype' => $gametype,
            'page' => $log_cache['page'],
            'pagelimit' => 500,//一次只能拉取500条记录
            'key' => 'x'.md5($this->website.$api_key.date("Ymd", $_SERVER['time'])).'wqwertyu',
        );
        if($_SERVER['time'] < $rounddate+3601)
        {
            $api_data['endtime'] = date("H:i:s",$_SERVER['time']-90);
            $end_time  = $_SERVER['time']-90;
        }else{
            $end_time = $rounddate+3601;
        }
        $data = $this->api_query($api, $api_data);
        if(isset($data['result']) && $data['result'] == 1){
            $return = array('status' => 1, 'msg' => '采集成功', 'end_time' => 0, 'end_id' => '', 'end_page' => '', 'data' => array());
            if(!empty($data['data'])){
                foreach($data['data'] as $k => $v){
                    $return['data'][] = $v;
                }
                $total_page = ceil($data['pagination']['TotalPage']);
                if($total_page > 1){
                    for($i = 2; $i <= $total_page; $i++){
                        $api_data['page'] = $i;
                        $data = $this->api_query($api, $api_data);
                        if(!empty($data['data'])){
                            foreach($data['data'] as $k => $v){
                                $return['data'][] = $v;
                            }
                        }else{
                            //防止接口请求失败丢失数据，只要抓取失败就停止循环
                            break;
                        }
                    }
                }
            }
            $return['end_time']       =  $end_time;
            return $return;
        }else{
            $num += 1;
            return $this->get_log($game_id ,$GameKind,$subgamekind  ,$gametype  ,$num,'');
        }

    }

    public function get_sports($logid , $api , $num = 1 , $error = '')
    {
        if($num > 3)
        {
            return  array(
                'status' => -1 ,
                'msg' => '采集失败',
                'error' => $error,
                'end_time' => '',
            );
        }
        $log_cache = $this->get_log_cache($logid);
        $api_key = "6kqBB1";

        $round_date = $log_cache["start_time"] ? $log_cache['start_time'] : $_SERVER['time'];
        // $round_date = strtotime("2019-07-25 23:58:50");
        if($_SERVER['time'] - $round_date > 604800)
        {
            $round_date = $_SERVER['time'] - 86400;
        }
        $api_data = array(
            "website" => $this->website,//网站名称
            "action"  => "ModifiedTime",//BetTime / ModifiedTime：须选一。（BetTime：使用下注时间查询信息/ ModifiedTime：使用异动时间查询资讯）
            "uppername" => $this->uppername,// 否 上层帐号(action=BetTime时，需强制带入)
            "date" => date("Y-m-d",$round_date+1),//日期ex：2012/03/21、2012-03-21
            "starttime" => date("H:i:s",$round_date+1),//开始时间ex：00:00:00
            "endtime" => date("H:i:s",$round_date+301),//结束时间ex：00:00:00
            "gametype" => "",//否  附件 2
            "page" => $log_cache['page'],//否 查询页数
            "pagelimit" => 500,//否 每页数量
            "key" => 'x'.md5($this->website.$api_key.date("Ymd",$_SERVER['time']))."nishizhu",//验证码(需全小写)，组成方式如下: key=A+B+C(验证码组合方式) A= 无意义字串长度1码B=MD5(website + KeyB + YYYYMMDD) C=无意义字串长度8码YYYYMMDD为美东时间(GMT-4)(20190327)
        );

        if($_SERVER['time'] - 120 <   $round_date+1)
        {
            return  array('status' => -1 , 'msg' => '采集失败,采集间隔过短', 'error' => $error,'end_time' => '');
        }
        //结束时间大于当前时间
        if($_SERVER['time']-120 < $round_date+301 )
        {
            $end_time = $round_date+61;
            $api_data['endtime'] = date("H:i:s",$round_date+61 );
        }else{
            $end_time = $round_date+301;
        }

        if(empty($this->rangeTime( $api_data['date'],$round_date+1,$end_time)))
        {
            $api_data['endtime'] = "23:59:59";
            $end_time = strtotime($api_data['date'].$api_data['endtime']);
        }
        $data = $this->api_query($api,$api_data);
        if(isset($data['result']) && $data['result'] == 1){
            $return = array('status' => 1, 'msg' => '采集成功', 'end_time' => 0, 'end_id' => 0, 'end_page' => '', 'data' => array());
            if(!empty($data['data'])){
                foreach($data['data'] as $k => $v){
                    $return['data'][] = $v;
                }
                $total_page = ceil($data['pagination']['TotalPage']);
                if($total_page > 1){
                    for($i = 2; $i <= $total_page; $i++){
                        $api_data['page'] = $i;
                        $data = $this->api_query($api, $api_data);
                        if(!empty($data['data'])){
                            foreach($data['data'] as $k => $v){
                                $return['data'][] = $v;
                            }
                        }else{
                            //防止接口请求失败丢失数据，只要抓取失败就停止循环
                            break;
                        }
                    }
                }

            }
            $return['end_time']       =  $end_time;
            return $return;
        }else{
            $num += 1;
            return $this->get_sports($logid  , $api , $num,'');
        }


    }
    //捕鱼大师
    public function get_fish2($logid , $api , $num = 1 , $error = '')
    {
        if($num > 3)
        {
            return  array(
                'status' => -1 ,
                'msg' => '采集失败',
                'error' => $error,
                'end_time' => '',
            );
        }
        $log_cache = $this->get_log_cache($logid);
        $api_key = "6kqBB1";

        $round_date = $log_cache["start_time"] ? $log_cache['start_time'] : $_SERVER['time'];
        if($_SERVER['time'] - $round_date > 604800)
        {
            $round_date = $_SERVER['time'] - 86400;
        }
        $api_data = array(
            "website" => $this->website,//网站名称
            "action"  => "ModifiedTime",//BetTime / ModifiedTime：须选一。（BetTime：使用下注时间查询信息/ ModifiedTime：使用异动时间查询资讯）
            "uppername" => $this->uppername,// 否 上层帐号(action=BetTime时，需强制带入)
            "date" => date("Y-m-d",$round_date+1),//日期ex：2012/03/21、2012-03-21
            "starttime" => date("H:i:s",$round_date+1),//开始时间ex：00:00:00
            "endtime" => date("H:i:s",$round_date+301),//结束时间ex：00:00:00
            "gametype" => "",//否  附件 2
            "page" => $log_cache['page'],//否 查询页数
            "pagelimit" => 500,//否 每页数量
            "key" => 'x'.md5($this->website.$api_key.date("Ymd",$_SERVER['time']))."nishizhu",//验证码(需全小写)，组成方式如下: key=A+B+C(验证码组合方式) A= 无意义字串长度1码B=MD5(website + KeyB + YYYYMMDD) C=无意义字串长度8码YYYYMMDD为美东时间(GMT-4)(20190327)
        );

        if($_SERVER['time'] - 120 <   $round_date+1)
        {
            return  array('status' => -1 , 'msg' => '采集失败,采集间隔过短', 'error' => $error,'end_time' => '');
        }
        //结束时间大于当前时间
        if($_SERVER['time']-120 < $round_date+301 )
        {
            $end_time = $round_date+61;
            $api_data['endtime'] = date("H:i:s",$round_date+61 );
        }else{
            $end_time = $round_date+301;
        }

        if(empty($this->rangeTime( $api_data['date'],$round_date+1,$end_time)))
        {
            $api_data['endtime'] = "23:59:59";
            $end_time = strtotime($api_data['date'].$api_data['endtime']);
        }
        $data = $this->api_query($api,$api_data);

        if(isset($data['result']) && $data['result'] == 1){
            $return = array('status' => 1, 'msg' => '采集成功', 'end_time' => 0, 'end_id' => 0, 'end_page' => '', 'data' => array());
            if(!empty($data['data'])){
                $data['data'] = array_reverse($data['data']);
                foreach($data['data'] as $k => $v){
                    $return['data'][] = $v;
                }
                $total_page = ceil($data['pagination']['TotalPage']);
                if($total_page > 1){
                    for($i = 2; $i <= $total_page; $i++){
                        $api_data['page'] = $i;
                        $data = $this->api_query($api, $api_data);
                        if(!empty($data['data'])){
                            foreach($data['data'] as $k => $v){
                                $return['data'][] = $v;
                            }
                        }else{
                            //防止接口请求失败丢失数据，只要抓取失败就停止循环
                            break;
                        }
                    }
                }
            }
            $return['end_time']       =  $end_time;
            return $return;
        }else{
            $num += 1;
            return $this->get_fish2($logid  , $api , $num,'');
        }


    }



    //bbin捕鱼
    public function get_fish($logid , $api , $num = 1 , $error = '')
    {
        if($num > 3)
        {
            return  array(
                'status' => -1 ,
                'msg' => '采集失败',
                'error' => $error,
                'end_time' => '',
            );
        }
        $log_cache = $this->get_log_cache($logid);
        $api_key = "6kqBB1";
        $time_out = 600; //不能超过当前    分钟
        $auto_ent_time = 300;  //每次增加  分钟

        $round_date = $log_cache["start_time"] ? $log_cache['start_time']+1 : $_SERVER['time']+1;
        // $round_date = strtotime("2019-07-30 04:40:00");
        if($_SERVER['time'] - $round_date > 604800)
        {
            $round_date = $_SERVER['time'] - 86400;
        }
        $api_data = array(
            "website" => $this->website,//网站名称
            "action"  => "ModifiedTime",//BetTime / ModifiedTime：须选一。（BetTime：使用下注时间查询信息/ ModifiedTime：使用异动时间查询资讯）
            "uppername" => $this->uppername,// 否 上层帐号(action=BetTime时，需强制带入)
            "date" => date("Y-m-d",$round_date),//日期ex：2012/03/21、2012-03-21
            "starttime" => date("H:i:s",$round_date),//开始时间ex：00:00:00
            "endtime" => date("H:i:s",$round_date+$auto_ent_time),//结束时间ex：00:00:00
            "gametype" => "",//否  附件 2
            "page" => $log_cache['page'],//否 查询页数
            "pagelimit" => 500,//否 每页数量
            "key" => 'x'.md5($this->website.$api_key.date("Ymd",time()))."nishizhu",//验证码(需全小写)，组成方式如下: key=A+B+C(验证码组合方式) A= 无意义字串长度1码B=MD5(website + KeyB + YYYYMMDD) C=无意义字串长度8码YYYYMMDD为美东时间(GMT-4)(20190327)
        );


        if($_SERVER['time'] - $time_out <   $round_date+1)
        {
            return  array('status' => -1 , 'msg' => '采集失败,采集间隔过短', 'error' => $error,'end_time' => '');
        }
        //结束时间大于当前时间
        if($_SERVER['time']-$time_out < $round_date+$auto_ent_time )
        {
            $end_time = $round_date+61;
            $api_data['endtime'] = date("H:i:s",$round_date+61 );
        }else{
            $end_time = $round_date+$auto_ent_time;
        }

        if(empty($this->rangeTime( $api_data['date'],$round_date+1,$end_time)))
        {
            $api_data['endtime'] = "23:59:59";
            $end_time = strtotime($api_data['date'].$api_data['endtime']);
        }

        $data = $this->api_query($api,$api_data);

        if(!empty($data['result']) && $data['result'] == 1){
            $return = array('status' => 1, 'msg' => '采集成功', 'end_time' => 0, 'end_id' => 0, 'end_page' => '', 'data' => array());
            if(!empty($data['data'])){
                foreach($data['data'] as $k => $v){
                    $return['data'][] = $v;
                    /*$bbin_log_endtime = strtotime(isset($v['UPTIME']) ? $v['UPTIME'] : $v['ModifiedDate']);
                    $bbin_log_end_id = $v['WagersID'];
                    $bbin_log_end_page = $data['pagination']['Page'];*/
                }
                $total_page = ceil($data['pagination']['TotalPage']);
                if($total_page > 1){
                    for($i = 2; $i <= $total_page; $i++){
                        $api_data['page'] = $i;
                        $data = $this->api_query($api, $api_data);
                        if(!empty($data['data'])){
                            foreach($data['data'] as $k => $v){
                                $return['data'][] = $v;
                                /*$bbin_log_endtime = strtotime(isset($v['UPTIME']) ? $v['UPTIME'] : $v['ModifiedDate']);
                                $bbin_log_end_id = $v['WagersID'];
                                $bbin_log_end_page = $data['pagination']['Page'];*/
                            }
                        }else{
                            //防止接口请求失败丢失数据，只要抓取失败就停止循环
                            break;
                        }
                    }
                }
            }
            $return['end_time']       =  $end_time;
            /*$return['end_time']       = isset($bbin_log_endtime)  ? $bbin_log_endtime  : $end_time;
            $return['end_id']         = isset($bbin_log_end_id)   ? $bbin_log_end_id   : '';
            $return['end_page']       = isset($bbin_log_end_page) ? $bbin_log_end_page : '';
            $return['end_total_page'] = isset($total_page)        ? $total_page        : '';*/
            return $return;
        }else{
            $num += 1;
            return $this->get_fish($logid  , $api , $num,'');
        }


    }



    public function rangeTime($date,$start,$end)
    {

        $now = strtotime($date." "."23:59:59");
        if($now > $start && $now > $end)
        {
            return true;
        }else{
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
            $login = json_decode($this->login($game_id),true);
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
                if( $this->game_info['last_game_id'] == 330 || $this->game_info['last_game_id'] == 463)
                {
                    sleep(5);
                }
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
            'deny_balance' => isset($money['deny_balance']) ? $money['deny_balance'] : '0',
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