<?php

/**bg接口
 * Class bg
 * 最短拉取时间 无间隔
 */
class bg extends base_model{
    function __construct() {
        parent::__construct();
        //加载ID转CODE类和错误代码类
        date_default_timezone_set("Etc/GMT+4");
        $this->c('id_to_code');
        $this->c('error');
        //网站ID
        $this->platform_id = 6;
        $this->platform_name = 'bg';
        //API接口域名
        $this->api_url = $this->conf['platform'][$this->platform_id]['url'];
        $this->api_sn = $this->conf['platform'][$this->platform_id]['sn'];
        $this->api_secretKey = $this->conf['platform'][$this->platform_id]['secretKey'];
        //用户信息
        $this->game_user = array();
        $this->site_id = 0;
        $this->en_site_id = '';
        $this->game_type = 'h5';//默认H5页面，支持H5和APP两个模式
        $this->user_ip = '';//用户IP
        $this->site_url = '';//客户端网站地址，返回使用
       // $this->website = 'avia';//网站，应该是泛亚的
        $this->uppername = $this->conf['platform'][$this->platform_id]['uppername'];//代理账号
        $this->password = $this->conf['platform'][$this->platform_id]['password'];//代理密码
        $this->proxy_id = $this->conf['platform'][$this->platform_id]['proxy_id'];//代理id
        $this->secretCode = base64_encode(sha1($this->password,true));
        $this->games_data  = array(
            "1" => "open.game.bg.egame.url",
            "3" => "open.game.bg.fishing.url",
            "5" => "open.video.game.url",
            "400" => "105",
            "401" => "411",
        );

        //用户名最大最小长度限制
        $this->max_username_len = 16;
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

    /**    各自单独解密
     * @param $en_username
     * @return array
     */
    public function de_username($en_username){
        $de_username = $this->id_to_code->tid_decode($en_username, 0);
        $de_username = explode("-",$de_username);
        return $de_username;
    }

    /**
     * @param $sign 生成令牌
     * @param string $type 类型
     * @param string $loginId
     * @param string $amount
     * @return string
     */
    public function sign($sign,$type = '' , $loginId = '' ,$amount = '')
    {
        if(!empty($sign))
        {
           switch($type)
           {
               case 0:
                   return  md5($sign.$this->api_sn.$this->api_secretKey);
                   break;
               case 1:
                   return  md5($sign.$this->api_sn.$this->secretCode);
                   break;
               case 2:
                   return  md5($sign.$this->api_sn.$loginId.$this->secretCode);
                   break;
               case 3:
                   return md5($sign.$this->api_sn.$loginId.$amount.$this->secretCode);
                   break;
               case 4:
                   return md5($sign.$this->api_sn.$loginId.$amount.$this->api_secretKey);
                   break;
               default:
                   echo  'sign 500';
                   break;
                   exit;
           }

        }
       return  "required password";
    }

    //通用递交接口
    public function api_query($api, $data, $apiid = '', $result_type = 1, $view_info = 0){
        if(!empty($apiid)){
            $url = $this->bbin_api2_url.$api;//要抓取数据的页面地址
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

    //开户接口
    public function reg($num = 1){
        if($num > 3){
            return $this->echo_cmd('reg_user_error');
        }
        $this->check_info();
        $api_data = array(
            'id' => $this->game_user['uid'],
            'method' => "open.user.create",
            'random' => $this->game_user['password'],
            'digest' => $this->sign($this->game_user['password'],1),
            'sn' => $this->api_sn,
            'loginId' => $this->game_user['username'],
            'nickname' => $this->game_user['username'],
            'agentLoginId' => $this->uppername,

        );
        $data = $this->za->curlPost($this->api_url, $api_data, 3, 5, '', array(), '', 0);
        $data = json_decode($data,true);
        if(is_array($data) ){
            if( (!empty($data['result']['success']) && $data['result']['success'] == 1) || $data['error']['code'] == '2206' )
            {      //用户被注册也表示用户已经开户好了，直接返回成功 2206
                return array('status' => 1, 'msg' => 'registered success');
            }else
            {
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





    //登陆接口
    public function login($game_id = '', $num = 1,$message = ""){
        //H5版界面不兼容PC，PC版界面兼容全局，所以使用PC版接口即可
        if($num > 3){
            return $this->echo_cmd('login_user_error');
        }
        $this->check_info();
        if(  $this->game_info['last_game_id'] == 401 ){
            $this->outlogin1(411);
        }else{
            $this->outlogin1(105);
        }
        $api_method = $this->games_data[$this->game_info['type_id']];
        $api_data = array(
            'id' => $this->game_user['uid'],
            'method' => $api_method,
            'random' => $this->game_user['password'],
            'isMobileUrl' => '1',
            'sn' => $this->api_sn,
            'loginId' => $this->game_user['username'],
         );
           switch($this->game_info['type_id'])
           {
               case 1:
                   $api_data['sign'] = $this->sign($this->game_user['password']);
                   $api_data['gameId'] = $this->game_info['module_id'];
                   break;
               case 3:
                   $api_data['sign'] = $this->sign($this->game_user['password']);
                   $api_data['gameType'] = $this->game_info['module_id'];
                   break;
               case 5:
                   $api_data['digest'] = $this->sign($this->game_user['password'],2 ,$this->game_user['username']);
                   break;
               default:
                   return $this->echo_cmd('login_user_error');
                   break;
           }
        $data = $this->za->curlPost($this->api_url, $api_data, 3, 5, '', array(), '', 0);
        $data = json_decode($data,true);
        $data_message = isset($data['error']['message']) ? $data['error']['message'] : "default message";
        if(!empty($data)){
            if(empty($data['error']))
            {
                return array('status' => 1, 'msg' => $data['result']);
            }else if($data['error']['code'] == '2213' || $data['error']['code'] == '41140' ){
                $reg = $this->reg();
                $num += 1;
                return $this->login($game_id, $num,$data_message);
            }
            $num += 1;
            return $this->login($game_id, $num,$data_message);
        }else{
            $num += 1;
            return $this->login($game_id, $num,$data_message);
        }

    }


    //强制捕鱼退出接口
    public function outlogin1($gameType , $num = 1){
        if($num > 3){
            return $this->echo_cmd('user_outlogin_error');
        }
        $this->check_info();
        $api_data = array(
            'id' => $this->game_user['uid'],
            'method' => "open.user.bgfish.logout",
            'random' => $this->game_user['password'],
            'digest' => $this->sign($this->game_user['password'],2,$this->game_user['username']),
            'sn' => $this->api_sn,
            'loginId' => $this->game_user['username'],
            'gameType' =>  $gameType,
        );
        $data = $this->za->curlPost($this->api_url, $api_data, 3, 5, '', array(), '', 0);
        $data = json_decode($data,true);
        $data_message = isset($data['error']['message']) ? $data['error']['message'] : "default message" ;
        if(is_array($data)){
            if(   empty($data['error'])  || $data['error']['code'] == 20020 ||  $data_message == 3202)
            {
                return array('status' => 1, 'msg' => 'out login success');
            }else{
                $num += 1;
                return $this->outlogin1($gameType , $num);
            }
        }else{
            $num += 1;
            return $this->outlogin1($gameType , $num);
        }

    }

    //停用账号接口
    public function outlogin($num = 1 ,$message=''){
        if($num > 3){
            return $this->echo_cmd('user_outlogin_error');
        }
        $this->check_info();
        $api_data = array(
            'id' => $this->game_user['uid'],
            'method' => "open.user.disable",
            'random' => $this->game_user['password'],
            'digest' => $this->sign($this->game_user['password'],2,$this->game_user['username']),
            'sn' => $this->api_sn,
            'loginId' => $this->game_user['username'],
        );
        $data = $this->za->curlPost($this->api_url, $api_data, 3, 5, '', array(), '', 0);
        $data = json_decode($data,true);
        $data_message = isset($data['error']['message']) ? $data['error']['message'] : "default message" ;
        if(!empty($data)){
            if(empty($data['error']) || $data['error']['code'] == 2213)
            {
                $this->user_start();
                return array('status' => 1, 'msg' => $data['result']);
            }else{
                $num += 1;
                return $this->outlogin( $num,$data_message);
            }
        }else{
            $num += 1;
            return $this->outlogin($num ,$data_message);
        }

    }
  /*启用账号*/
    function user_start($num = 1 ,$message=''){
        if($num > 3){
            return $this->echo_cmd('login_user_error');
        }
        $this->check_info();
        $api_data = array(
            'id' => $this->game_user['uid'],
            'method' => "open.user.enable",
            'random' => $this->game_user['password'],
            'digest' => $this->sign($this->game_user['password'],2,$this->game_user['username']),
            'sn' => $this->api_sn,
            'loginId' => $this->game_user['username'],
        )   ;
        $data = $this->za->curlPost($this->api_url, $api_data, 3, 5, '', array(), '', 0);
        $data = json_decode($data,true);
        $data_message = isset($data['error']['message']) ? $data['error']['message'] : "default message" ;
        if(!empty($data)){
            if(empty($data['error'])  || $data['error']['code'] == 2213)
            {
                return array('status' => 1, 'msg' => $data['result']);
            }else{
                $num += 1;
                return $this->outlogin( $num,$data_message);
            }
        }else{
            $num += 1;
            return $this->outlogin($num , $data_message);
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
         $Current_ms = sprintf('%.0f',(floatval($use)+floatval($sec)) * 1000);
         $this->order_id  =  substr($Current_ms,0,64);
     }

    /** 获取订单id
     * @return mixed
     */
    private function get_order_id()
    {
        return $this->order_id;
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
        if($money < 1 )
        {
            return $this->echo_cmd('amount_mix');
        }
        $order_id =  $this->get_order_id();
        if($type == 2 )
        {
            $money = -$money;
        }
        $api_data = array(
            'id' => $this->game_user['uid'],
            'method' => "open.balance.transfer",
            'random' => $this->game_user['password'],
            'digest' => $this->sign($this->game_user['password'],3,$this->game_user['username'],$money),
            'sn' => $this->api_sn,
            'loginId' => $this->game_user['username'],
            'amount' => $money,
            'bizId' => $order_id,
            'checkBizId' => 1
        );
        $data = $this->za->curlPost($this->api_url, $api_data, 3, 5, '', array(), '', 0);
        $this->log('start',$data);
        $check_money = $this->check_transfer($order_id,$money);
        if($check_money['status'] == 1 ){
               return array('status' => 1, 'platform_order_id' => $order_id , 'data' => '' ,'money' => $check_money['money']);
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
        $api_data = array(
            'method' => "open.balance.transfer.query",
            'random' => $this->game_user['password'],
            'sign' => $this->sign($this->game_user['password']),
            'sn' => $this->api_sn,
            'loginId' => $this->game_user['username'],
            'bizId' => $order_id,
            'sortHint' => 'desc',
            'pageSize' => '3',
        );
        $data = $this->za->curlPost($this->api_url, $api_data, 3, 3, '', array(), '', 0);
        $this->log('end',$data);
        $data = json_decode($data,true);
        if( !empty($data['result']['items'][0]['bizId']) ){
                return array('status' => 1, 'msg' => '', 'data' => '' ,'money' => abs($data['result']['items'][0]['amount']) );
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
        $this->za->make_log($this->platform_id.'_'.$this->game_user['uid'],time(),$type,$data,"transfer");
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
        $api_data = array(
            'id' => $this->game_user['uid'],
            'method' => "open.balance.get",
            'random' => $this->game_user['password'],
            'digest' => $this->sign($this->game_user['password'],2,$this->game_user['username']),
            'sn' => $this->api_sn,
            'loginId' => $this->game_user['username'],
        )   ;
        $data = $this->za->curlPost($this->api_url, $api_data, 3, 5, '', array(), '', 0);
        $data = json_decode($data,true);
            if(!empty($data)){
                if(empty($data['error'])){
                    return array('status' => 1, 'balance' => $data['result'] >=1 ? $data['result'] : 0);
                }else if(isset($data['error']['code']) ){
                    return $this->echo_cmd('get_user_money_out');
                }else{
                    $num += 1;
                    return $this->get_money($num );
                }
            }else{
                $num += 1;
                return $this->get_money($num );
            }

    }

    //获取记录接口最后记录时间缓存，如果不存在就转入数据库读取
    public function get_log_cache($game_id){

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
    public function get_log($game_id = '', $start_time , $end_time , $num = 1 ,$error=''){
        if($num > 3 or  $start_time > $end_time){
            $error  = "可能开始时间大于结束时间";
            return array(
                'status' => -1 ,
                'msg' => '采集失败',
                'error' => $error,
                'end_time' => $end_time,
            );
        }
        $api_data = array(
            'method' => "open.order.agent.query",
            'random' => $_SERVER['time'],
            'digest' => $this->sign($_SERVER['time'],1),
            'sn' => $this->api_sn,
            'agentId' => $this->proxy_id,
            'agentLoginId' => $this->uppername,
            /*'startTime' => "2019-08-20 07:52:36",
            'endTime' => "2019-08-20 07:52:37",*/
            'startTime' => date("Y-m-d H:i:s",$start_time),
            'endTime' => date("Y-m-d H:i:s",$end_time),
            'pageIndex' =>1,
            'pageSize' => 1,
        );
        $data = $this->za->curlPost($this->api_url, $api_data, 3, 5, '', array(), '', 0);
        $data = json_decode($data,true);
        $data_message = isset($data['error']['message']) ?  $data['error']['message'] : '';
        if(!empty($data['result']) && is_array($data)){
            $return = array('status' => 1, 'msg' => '采集成功', 'end_time' => 0, 'end_id' => 0, 'end_page' => '', 'data' => array());
            if(!empty($data['result']['items'])){
                foreach(array_reverse($data['result']['items']) as $k => $v){
                    $return['data'][] = $v;
                }
                $total_page = ceil($data['result']['total']/$api_data['pageSize']);
                if($total_page > 1){
                    for($i = 2; $i <= $total_page; $i++){
                        $api_data['pageIndex'] = $i;
                        $data = $this->za->curlPost($this->api_url, $api_data, 3, 5, '', array(), '', 0);
                        $data = json_decode($data,true);
                        if(!empty($data['result']['items'])){
                            foreach(array_reverse($data['result']['items'])  as $k => $v){
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
            return $this->get_log($game_id , $start_time , $end_time ,$num,$data_message);
        }

    }

    public function get_solt($game_id = '', $start_time , $end_time , $num = 1 ,$error=''){
        if($num > 3 or  $start_time > $end_time){
            $error  = "可能开始时间大于结束时间";
            return array(
                'status' => -1 ,
                'msg' => '采集失败',
                'error' => $error,
                'end_time' => $end_time,
            );
        }

        $api_data = array(
            'method' => "open.order.bg.egame.agent.query",
            'random' => $_SERVER['time'],
            'digest' => $this->sign($_SERVER['time'],1),
            'sn' => $this->api_sn,
            'agentId' => $this->proxy_id,
            'agentLoginId' => $this->uppername,
            /* 'beginTime' => date("Y-m-d H:i:s",$start_time),
              'endTime' => date("Y-m-d H:i:s",$end_time),*/
             'settleStartTime' => date("Y-m-d H:i:s",$start_time),
             'settleEndTime' => date("Y-m-d H:i:s",$end_time),
             'timeType' => "2",
            'pageIndex' =>1,
            'pageSize' => 500,
        );
        $data = $this->za->curlPost($this->api_url, $api_data, 3, 5, '', array(), '', 0);
        $data = json_decode($data,true);
        $data_message = isset($data['error']['message']) ?  $data['error']['message'] : '';
        if(!empty($data['result'])  && is_array($data)){
            $return = array('status' => 1, 'msg' => '采集成功', 'end_time' => 0, 'end_id' => 0, 'end_page' => '', 'data' => array());
            if(!empty($data['result']['items'])){
                foreach(array_reverse($data['result']['items']) as $k => $v){

                    $return['data'][] = $v;
                }
                $total_page = ceil($data['result']['total']/$api_data['pageSize']);
                if($total_page > 1){
                    for($i = 2; $i <= $total_page; $i++){
                        $api_data['pageIndex'] = $i;
                        $data = $this->za->curlPost($this->api_url, $api_data, 3, 5, '', array(), '', 0);
                        $data = json_decode($data,true);
                        if(!empty($data['result']['items'])){
                            foreach(array_reverse($data['result']['items'])  as $k => $v){
                                $return['data'][] = $v;
                            }
                        }else{
                            //防止接口请求失败丢失数据，只要抓取失败就停止循环
                            break;
                        }
                    }
                }
            }
            $return['end_time']       =   $end_time;
            $return['end_total_page'] =   '';
            return $return;
        }else{
            $num += 1;
            return $this->get_solt($game_id , $start_time , $end_time ,$num,$data_message);
        }

    }

    public function get_fish($game_id = '', $start_time , $end_time , $num = 1 ,$error=''){
        if($num > 3 or  $start_time > $end_time){
            $error  = "可能开始时间大于结束时间";
            return array(
                'status' => -1 ,
                'msg' => '采集失败',
                'error' => $error,
                'end_time' => $end_time,
            );
        }

        $api_data = array(
            'method' => "open.order.bg.fishing.agent.query",
            'random' => $_SERVER['time'],
            'digest' => $this->sign($_SERVER['time'],1),
            'sn' => $this->api_sn,
            'agentId' => $this->proxy_id,
            'agentLoginId' => $this->uppername,
         /*   'startTime' => "2019-08-12 08:06:49",
            'endTime' => "2019-08-20 08:06:50",*/
            'gameType' => $game_id,
            'startTime' => date("Y-m-d H:i:s",$start_time),
            'endTime' => date("Y-m-d H:i:s",$end_time),
            'timeZone' => "2",
            'pageIndex' =>1,
            'pageSize' => 500,
        );
        $data = $this->za->curlPost($this->api_url, $api_data, 3, 5, '', array(), '', 0);
        $data = json_decode($data,true);
        $data_message = isset($data['error']['message']) ?  $data['error']['message'] : '';
        if(!empty($data['result']) && is_array($data)){
            $return = array('status' => 1, 'msg' => '采集成功', 'end_time' => 0, 'end_id' => 0, 'end_page' => '', 'data' => array());
            if(!empty($data['result']['items']) && is_array($data)){
                foreach(array_reverse($data['result']['items']) as $k => $v){
                    $return['data'][] = $v;
                }
                $total_page = ceil($data['result']['total']/$api_data['pageSize']);
                if($total_page > 1){
                    for($i = 2; $i <= $total_page; $i++){
                        $api_data['pageIndex'] = $i;
                        $data = $this->za->curlPost($this->api_url, $api_data, 3, 5, '', array(), '', 0);
                        $data = json_decode($data,true);
                        if(!empty($data['result']['items'])){
                            foreach(array_reverse($data['result']['items'])  as $k => $v){
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
            return $this->get_fish($game_id , $start_time , $end_time ,$num,$data_message);
        }

    }



    //获取游戏接口
    public function get_game($game_id = '', $num = 1){

    }

    //进入游戏
    public function go_game($gamekind = 3, $gametype = 3001, $gamecode = 1, $num = 1){
        //H5页面不适配电脑与应用，全面使用PC页面，可以适配WAP
        if($num > 3){
            return $this->echo_cmd('get_game_time_out');
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
            if( $this->game_info['last_game_id'] == 401 ){
                $login =  $this->outlogin1(411);
            }else{
                $login = $this->outlogin1(105);
            }
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