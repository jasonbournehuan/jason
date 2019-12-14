<?php

/**cq9接口
 * Class cq9
 * 最短拉取时间 无间隔
 */
class cq9 extends base_model{
    function __construct() {
        parent::__construct();
        //加载ID转CODE类和错误代码类
        date_default_timezone_set("Etc/GMT+4");
        $this->c('id_to_code');
        $this->c('error');
        //网站ID
        $this->platform_id = 9;
        $this->platform_name = 'cq9';
        //API接口域名
        $this->api_url = $this->conf['platform'][$this->platform_id]['url'];
        $this->Token = $this->conf['platform'][$this->platform_id]['token'];
        //用户信息
        $this->game_user = array();
        $this->site_id = 0;
        $this->en_site_id = '';
        $this->game_type = 'h5';//默认H5页面，支持H5和APP两个模式
        $this->user_ip = '';//用户IP
        $this->site_url = '';//客户端网站地址，
        //用户名最大最小长度限制
        $this->max_username_len = 36;
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
     * @return array
     */
    public function header()
    {
        $header = array(
            "Content-Type:application/x-www-form-urlencoded","Authorization:".$this->Token,
        );
        return $header;
    }

    //通用递交接口
    public function api_query($api, $data, $apiid = '', $result_type = 1, $view_info = 0){
        if(!empty($apiid)){
            $url = $this->bbin_api2_url.$api;//要抓取数据的页面地址
        }else{
            $url = $api;//要抓取数据的页面地址
        }

        $info = $this->za->curlPost($url, $data, 3, 5, '', $this->header(), '', $view_info);//请求接口数据
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
        $api_url = $this->api_url."/gameboy/player";
        $api_data = array(
            'account' => $this->game_user['username'],
            'password' => $this->game_user['password'],
            'nickname' => $this->game_user['username'],
        );
        $data = $this->za->curlPost($api_url, $api_data, 3, 5, '', $this->header(), '', 0);
        $data = json_decode($data,true);
        if(!empty($data['data']) )
        {
            $data_code = isset($data['status']['code']) ? $data['status']['code'] : '';
            $data_message = isset($data['status']['message']) ? $data['status']['message'] : '';
            if($data_message == "Success" || $data_code == '6' )
            {     //用户被注册也表示用户已经开户好了，直接返回成功  6
                return array('status' => 1, 'msg' => 'registered success');
            }
            else
            {
                return $this->echo_cmd('reg_user_error');
            }
        }
            $num += 1;
            return $this->reg($num );
    }


    /**登陆接口
     * @param string $game_id
     * @param int $num
     * @param string $data_code
     * @param string $message
     * @return array
     */
    public function login($game_id = '', $num = 1){
        //H5版界面不兼容PC，PC版界面兼容全局，所以使用PC版接口即可
        if($num > 3){
            return $this->echo_cmd('login_user_error');
        }
            $this->outlogin();
      $token = $this->user_token();
        if(!empty($game_id))
        {
            $api_url  = "/gameboy/player/gamelink";
            $api_data = array(
                'usertoken' => $token['msg'],
                'gamehall' => "cq9",
                'gamecode' => $this->game_info['game_code'],
                'gameplat' => 'web',//遊戲平台，請填入 web 或 mobile※若gameplat 不為該遊戲平台時，將帶入預設值，預設值為web
                'lang' => "zh-cn",
                'app' => "Y",//是否是透過app 執行遊戲，Y=是，N=否，預設為N
                'detect' => "Y",//是否開啟阻擋不合遊戲規格瀏覽器提示， Y=是，N=否，預設為N
            );
        }else{
            $api_url = "/gameboy/player/lobbylink";
            $api_data = array(
                'usertoken' => $token['msg'],
                'lang' => "zh-cn",
            );
        }
        $data = $this->za->curlPost($this->api_url.$api_url, $api_data, 3, 5, '', $this->header(), '', 0);
        $data = json_decode($data, true);
        if(!empty($data))
        {
            $data_message = isset($data['status']['message']) ? $data['status']['message'] : '';
            if($data_message=="Success")
            {
                return array('status' => 1, 'msg' => $data['data']['url']);
            }
            $num += 3;
            return $this->login($game_id, $num );
        }else
        {
            $num += 1;
            return $this->login($game_id, $num);
        }
    }

    /**   获取用户token
     * @param int $num
     * @param string $data_code
     * @param string $message
     * @return array
     */
    private function user_token($num = 1)
    {
        if ($num > 3) {
            return $this->echo_cmd('login_user_error');
        }
        $this->check_info();
        $check_user =  $this->check_game_user($this->game_user['username']);
        if(empty($check_user['status']))
        {
            $this->reg();
        };
        $this->outlogin();
        $api_url = $this->api_url . "/gameboy/player/login";
        $api_data = array(
            'account' => $this->game_user['username'],
            'password' => $this->game_user['password'],
        );
        $data = $this->za->curlPost($api_url, $api_data, 3, 5, '', $this->header(), '', 0);
        $data = json_decode($data, true);
        if (!empty($data['data']))
        {
            $data_message = isset($data['status']['message']) ? $data['status']['message'] : '';
            if($data_message == "Success")
            {
                return array('status' => 1, 'msg' => $data['data']['usertoken']);
            }
        }
            $num += 1;
            return $this->user_token($num);
    }

    /**检查用户是否存在
     * @param $account  账户名
     * @param int $num
     * @param string $data_code
     * @param string $message
     * @return array
     */
    private function check_game_user($account,$num = 1)
    {
          if(empty($account) or is_array($account))
          {
              return $this->echo_cmd('user_empty');
          }
          if($num > 3 )
          {
              return $this->echo_cmd('check_user_error');
          }
        $this->check_info();
        $api_url = $this->api_url."/gameboy/player/check/".$account;
        $api_data = array();
        $data = $this->za->curlPost($api_url, $api_data, 3, 5, '', $this->header(), '', 0);
        $data = json_decode($data,true);
        if(!empty($data))
        {
            $data_message = isset($data['status']['message']) ? $data['status']['message'] : '';
            if($data_message == "Success")
            {
                   return array(
                       "status" => $data['data'],
                       "msg"   => ''
                   );
            }else
            {
                return array(
                    "status" => -1,
                    "msg"   => $data,
                );
            }
        }else{
            $num+=1;
            return $this->check_game_user($account, $num );
        }
    }

    /**会员登出接口
     * @param int $num
     * @param string $message
     * @return array
     */
    public function outlogin($num = 1 ){
        if($num > 3){
            return $this->echo_cmd('user_outlogin_error');
        }
        $this->check_info();
        $api_url =  '/gameboy/player/logout';
        $api_data = array(
            'account' => $this->game_user['username'], //player帳號※字串長度限制36個字元
        );
        $data = $this->za->curlPost($this->api_url.$api_url, $api_data, 3, 5, '', $this->header(), '', 0);
        $data = json_decode($data,true);
        if(!empty($data)){
            $data_message = isset($data['status']['message']) ? $data['status']['message'] : '';
            $code = isset($data['status']['code']) ? $data['status']['code'] : '';
            if($data_message == "Success" || $code == 2 )
            {
                return array('status' => 1, 'msg' => 'outlogin success');
            }else{
                $num += 1;
                return $this->outlogin($num );
            }
        }else{
            $num += 1;
            return $this->outlogin($num );
        }

    }

    /**
     * 生成订单id
     */
    private function set_order_id()
    {
        list($use,$sec) = explode(' ',microtime());
        $Current_ms = sprintf('%.0f',(floatval($use)+floatval($sec)) * 1000 );
        $this->order_id  =  substr($Current_ms.'_'.$this->game_user['username'],0,70);
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
     * @param $money  金额
     * @param $type 1 转入 2  转出 默认 1
     * @param int $num
     * @return array
     */
    public function in_out_money($money, $type = 1 , $num = 1){
        if($num > 3){
            return $this->echo_cmd('in_out_money_error');
        }
        $order_id = $this->get_order_id();
        if($type == 1 )
        {
            $api_url = "/gameboy/player/deposit";
        }
        if($type == 2 )
        {
            $api_url = "/gameboy/player/withdraw";
        }
        $api_data = array(
            'account' => $this->game_user['username'],
            'mtcode' => $order_id,
            'amount' => $money,
        );
        $data = $this->za->curlPost($this->api_url.$api_url, $api_data, 3, 5, '', $this->header(), '', 0);
        $this->log('start',$data);
        $result = $this->check_transfer($order_id,$money);
        if($result['status'] == 1 ){
                    return array(
                        'status' => 1,
                        'platform_order_id' => $order_id ,
                        'balance' => '',
                        'money' => $result['money'],);
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
        $api_url =  '/gameboy/transaction/record/'.$order_id;
        $api_data = array(
        );
        $data = $this->za->curlPost($this->api_url.$api_url, $api_data, 3, 5, '', $this->header(), '', 0);
        $this->log('end',$data);
        $data = json_decode($data,true);
        if(isset($data['data']['status']) && $data['data']['status'] == 'success')
        {
            return array('status' => 1, 'msg' => '', 'data' => '' , 'money' => $data['data']['amount']);
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
     * @param string $message
     * @return array
     */
    public function get_money($num = 1 ){
        if($num > 3){
            return $this->echo_cmd('get_user_money_out');
        }
        $this->check_info();
        $api_url =  '/gameboy/player/balance/'.$this->game_user['username'];
        $api_data = array(
        );
        $data = $this->za->curlPost($this->api_url.$api_url, $api_data, 3, 5, '', $this->header(), '', 0);
        $data = json_decode($data,true);
        $data_message = isset($data['status']['message']) ? $data['status']['message'] : '';
            if(!empty($data)){
                if($data_message == "Success"){
                    return array('status' => 1, 'balance' => $data['data']['balance']);
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

    }

    //电子投注记录格式化
    public function format_log_5($data){
        $new_data = array();
        return $new_data;
    }

    /**获取记录接口
     * @param string $game_id
     * @param $start_time
     * @param $end_time
     * @param int $num
     * @param string $error
     * @return array
     */
    public function get_log( $start_time , $end_time , $num = 1 ,$error=''){
        if($num > 3 or  $start_time > $end_time){
            return array(
                'status' => -1,
                'msg' => '采集失败',
                'error' => $error,
                'end_time' => $end_time,
            );
        }
        $api_data = array(
            "starttime" => date("Y-m-d\TH:i:s-04:00",$start_time),
            "endtime" => date("Y-m-d\TH:i:s-04:00",$end_time),
            "page" => "1",
            "pagesize" => "20000",
        );
        $url = $this->api_url.'/gameboy/order/view?'.$this->za->arrToDate($api_data);
        $data = $this->za->curlPost($url, array(), 3, 2, '', $this->header(), '', 0);
        $data = json_decode($data,true);
        $data_code = isset($data['status']['code']) ? $data['status']['code'] : '';
        $data_message = isset($data['status']['message']) ? $data['status']['message'] : '';
        if(!empty($data)){
            if($data_message == "Success" || $data_code == 8 )
            {
                $return = array('status' => 1, 'msg' => '采集成功', 'end_time' => 0, 'end_id' => 0, 'end_page' => '', 'data' => array());
                if(!empty($data['data']['Data'])){
                    foreach(array_reverse($data['data']['Data']) as $k => $v){
                        if($v['gamecode'] == "AD02" || $v['gamecode'] == "AD03")
                        {
                            $v['win'] = $v['win'] - $v['rake'];
                        }else{
                            $v['win'] = $v['win'] - $v['bet'];
                        }
                        $return['data'][] = $v;
                    }
                    $total_page = ceil($data['data']['TotalSize']/$api_data['pagesize']);
                    if($total_page > 1){
                        for($i = 2; $i <= $total_page; $i++){
                            $api_data['page'] = $i;
                            $url = $this->api_url.'/gameboy/order/view?'.$this->za->arrToDate($api_data);
                            $data = $this->za->curlPost($url, array(), 3, 2, '', $this->header(), '', 0);
                            $data = json_decode($data,true);
                            if(!empty($data['data']['Data'])){
                                foreach($data['data']['Data']  as $k => $v){
                                    if($v['gamecode'] == "AD02" || $v['gamecode'] == "AD03")
                                    {
                                        $v['win'] = $v['win'] - $v['rake'];
                                    }else{
                                        $v['win'] = $v['win'] - $v['bet'];
                                    }
                                    $return['data'][] = $v;
                                }
                            }else{
                                //防止接口请求失败丢失数据，只要抓取失败就停止循环
                                break;
                            }
                        }
                    }
                }
                $return['end_time'] =  $end_time;
                return $return;
            }else{
                return  array('status' => -1, 'msg' => $data_code,'error' => $data_message);
            }

        }else{
            $num += 1;
            return $this->get_log($start_time , $end_time ,$num,$data_message);
        }

    }


    /**获取游戏接口  无法使用
     * @param int $num
     * @param string $code
     * @param string $message
     * @return array
     */
    public function get_game( $num = 1)
    {
        if($num > 3)
        {
            return $this->echo_cmd('get_game_time_out');
        }
        $this->check_info();
        $api = '';//要抓取数据的页面地址
        $api_data = array();
        $data = $this->api_query($api, $api_data);
        if(!empty($data['data']))
        {
            return array('status' => 1, 'msg' => $data);
        }else{
            $num += 1;
            return $this->get_game($num );
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
                $this->set_order_id();
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
                $this->set_order_id();
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