<?php
/**jdb接口
 * Class jdb
 * 最短拉取时间 无间隔
 */
class jdb extends base_model{
    private $order_id;
    function __construct() {
        parent::__construct();
        //加载ID转CODE类和错误代码类
        date_default_timezone_set("Etc/GMT+4");
        $this->c('id_to_code');
        $this->c('error');
        //网站ID
        $this->platform_id = 10;
        $this->platform_name = 'jdb';
        //API接口域名
        $this->api_url = $this->conf['platform'][$this->platform_id]['url'];
        $this->dc = $this->conf['platform'][$this->platform_id]['dc'];
        $this->iv = $this->conf['platform'][$this->platform_id]['iv'];
        $this->key = $this->conf['platform'][$this->platform_id]['key'];
        $this->jdb_agent = $this->conf['platform'][$this->platform_id]['agent'];
        $this->jdb_agent_password = $this->conf['platform'][$this->platform_id]['agent_password'];
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

    private function current_time()
    {
        return round(microtime(true)*1000);
    }
    
    /**检测接口需求信息
     * @return array|string
     */
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



    /** 加密
     * @param $str
     * @return string
     */
    private function encrypt($str){
        if(empty($str))
        {
            echo  'str   null';
        }
        $str = json_encode($str);
        $iv = $this->iv;
        $td = mcrypt_module_open('rijndael-128', '', 'cbc', $iv);
        mcrypt_generic_init($td, $this->key, $iv);
        $str= $this->padString($str);
        $encrypted = mcrypt_generic($td, $str);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        return base64_encode($encrypted);
    }

    /** 解密
     * @param $code
     * @return string
     */
    private function decrypt($code) {
        $code = base64_decode($code);
        $iv = $this->iv;
        $td = mcrypt_module_open('rijndael-128', '', 'cbc', $iv);
        mcrypt_generic_init($td, $this->key, $iv);
        $decrypted = mdecrypt_generic($td, $code);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        return utf8_encode(trim($decrypted));
    }

    protected function hex2bin($hexdata) {
        $bindata = '';
        for ($i = 0; $i<strlen($hexdata); $i += 2) {
            $bindata .=chr(hexdec(substr($hexdata, $i, 2)));
        }
        return $bindata;
    }

    /**  补足数量
     * @param $source
     * @return string
     */
    private function padString($source) {
        $paddingChar = ' ';
        $size = 16;
        $x = strlen($source) % $size;
        $padLength = $size - $x;
        for ($i = 0; $i< $padLength; $i++) {
            $source .= $paddingChar;
        }
        return $source;
    }

    //通用递交接口
    public function api_query($api, $data=''){

            $url = $this->api_url;//要抓取数据的页面地址
            $data = array(
                "dc" => $this->dc,
                "x" => $api,
            );
        $info = $this->za->curlPost($url, $data, 3, 5);//请求接口数据
        return json_decode($info,true);
    }

    //开户接口
    public function reg($num = 1,$code = '' , $message=""){
        if($num > 3){
            return $this->echo_cmd('reg_user_error');
        }
        $this->check_info();
        $api_data = array(
            "action" => 12,
            "ts"     => $this->current_time(),
            "parent" => $this->jdb_agent,
            "uid"   => $this->game_user['username'],
            "name"   => $this->game_user['username'],
            "credit_allocated"   => "0",
        );
        $x = $this->encrypt($api_data);
        $data = $this->api_query($x, $api_data);
        $data_code = isset($data['status']) ? $data['status'] : '';
        $data_message = isset($data['err_text']) ? $data['err_text'] : '';

        if(!empty($data) ){
            if($data_code == "0000" )
            {
                return array('status' => 1, 'msg' => $data_message);
            }else if($data_code == '7602' ){
                //用户被注册也表示用户已经开户好了，直接返回成功
                return array('status' => 1, 'msg' => $data_message);
            }else{
                $num += 3;
                return $this->reg($num,$data_code , $data_message);
            }
        }
        $num += 1;
        return $this->reg($num,$data_code , $data_message);
    }


    /**登陆接口
     * @param string $game_id
     * @param int $num
     * @param string $data_code
     * @param string $message
     * @return array
     */
    public function login($game_id = '', $num = 1,$data_code = '' , $message = ""){
        //H5版界面不兼容PC，PC版界面兼容全局，所以使用PC版接口即可
        if($num > 3){
            return $this->echo_cmd('login_user_error');
        }
        $this->check_info();
        $this->outlogin();
        $encrypt_data = array(
            "action" => '11',
            "ts"     => $this->current_time(),
            "uid" => $this->game_user['username'],
            "lang"   => "ch",
            "gType"   => $this->game_info['query_info'],
            "mType"   => $this->game_info['game_code'],
            "windowMode"   => "2",//1: 包含游戏大厅（默认值）※若未带入 gType 及 mType，则直接到游戏大厅※若带入 gType 及 mType 时，直接进入游戏。2: 不包含游戏大厅，隐藏游戏中的关闭钮※gType 及 mType 为必填字段。
            "isAPP"   => false, //当为 true 时，代表使用 app webview 进入游戏预设为 false.
            "lobbyURL"   => '1', //游戏大厅网址当 windowMode 为 2 时, 此参数才会有作用,如果不是合法的网址或是空的值会隐藏游戏中的关闭钮
            "moreGame"   => '0', //0: 不显示更多游戏   1: 显示更多游戏（默认值）
            "mute"   => '0', //預設音效開關0: 开启音效（默认值）1: 静音
            "cardGameGroup"   => '', //棋牌游玩群组可输入范围 0 ~ 499 （默认值 0）
        );
        $x = $this->encrypt($encrypt_data);
        $data = $this->api_query($x);
        $data_code = isset($data['status']) ? $data['status'] : '';
        $data_message = isset($data['err_text']) ? $data['err_text'] : '';
        if(!empty($data)){
            if($data_code==="0000")
            {
                return array('status' => 1, 'msg' => $data['path']);
            }else if($data_code == '7501')
            {
                $this->reg();
            }
            $num += 1;
            return $this->login($game_id, $num , $data_code ,$data_message);
        }else{
            $num += 1;
            return $this->login($game_id, $num , $data_code ,$data_message);
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
        $encrypt_data = array(
            "action" => '17',
            "ts"     => $this->current_time(),
            "parent" => $this->jdb_agent,
            "uid" => $this->game_user['username'],
        );

        $x = $this->encrypt($encrypt_data);
        $data = $this->api_query($x);
        if(isset($data['status'])){
            if($data['status'] === '0000' || $data['status'] == '7405' || $data['status'] == '7501' )
            {
                return array('status' => 1, 'msg' => '');
            }
            return $this->echo_cmd('user_outlogin_error');
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

    /**
     * 生成订单id
     */
    public function set_order_id()
    {
        $Current_ms = round(microtime(true)*1000);
        $this->order_id  =  substr($Current_ms.$this->game_user['username'],0,50);
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
        $order_id = $this->order_id;
        if($type == 1 )
        {
            $Amount = $money;
        }
        if($type == 2 )
        {
            $Amount = -$money;
        }
        $encrypt_data = array(
            "action" => '19',
            "ts"     => $this->current_time(),
            "parent" => $this->jdb_agent,
            "uid" => $this->game_user['username'],
            "serialNo" => $order_id,
            "amount" => $Amount,
        );
        $x = $this->encrypt($encrypt_data);
        $data = $this->api_query($x);
        $logo_data = array(
            "request_info" => $encrypt_data,
            "return" => $data,
        );
        $log = $this->log('start',$logo_data);
        $result = $this->check_transfer($money);
        if($result['status'] == 1 ){
            return array(
                'status' => 1,
                'platform_order_id' => $order_id ,
                'money' => abs($data['amount']) , );
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
        $encrypt_data = array(
            "action" => '55',
            "ts"     => $this->current_time(),
            "parent" => $this->jdb_agent,
            "serialNo" => $this->order_id,
        );
        $x = $this->encrypt($encrypt_data);
        $data = $this->api_query($x);
        $logo_data = array(
            "request_info" => $encrypt_data,
            "return" => $data,
        );
        $log = $this->log('end',$logo_data);
        if(isset($data['status']) && $data['status'] === '0000'){
            return array('status' => 1, 'msg' => '', 'data' => '');
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
        $encrypt_data = array(
            "action" => '15',
            "ts"     => $this->current_time(),
            "parent" => $this->jdb_agent,
            "uid" => $this->game_user['username'],
        );
        $x = $this->encrypt($encrypt_data);
        $data = $this->api_query($x);
        $data_code = isset($data['status']) ? $data['status'] : ''; 
        if(!empty($data)){
            if($data_code === "0000"){
                return array(
                    'status' => 1,
                    'balance' => intval($data['data'][0]['balance']*100)/100,
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

    /**获取记录接口
     * @param string $game_id
     * @param $start_time
     * @param $end_time
     * @param int $num
     * @param string $error
     * @return array
     */
    public function get_log($game_id = '', $start_time , $end_time , $num = 1 ,$error=''){
        if($num > 3 or  $start_time > $end_time){
            return array(
                'status' => -1,
                'msg' => '采集失败',
                'error' => $error,
                'end_time' => $end_time,
            );
        }

        $encrypt_data = array(
            "action" => '29',
            "ts"     => $this->current_time(),
            "parent" => $this->jdb_agent,
            "starttime" => date("d-m-Y H:i:00",$start_time),
            "endtime" => date("d-m-Y H:i:00",$end_time),
        );
        print_r($encrypt_data);
        $x = $this->encrypt($encrypt_data);
        $data = $this->api_query($x);
        $data_code = isset($data['status']) ? $data['status'] : '';
        $data_message = isset($data['err_text']) ? $data['err_text'] : '';

        if(!empty($data)){
            if(  $data_code == '0000' )
            {
                $return = array('status' => 1, 'msg' => '采集成功', 'end_time' => 0, 'end_id' => 0, 'end_page' => '', 'data' => array());
                if(!empty($data['data'])){
                    foreach($data['data'] as $k => $v){
                        $v['bet'] = abs($v['bet']);
                        $return['data'][] = $v;
                    }
                }
                $return['end_time'] =  $end_time;
                return $return;
            }else{
                return  array(
                    'status' => -1,
                    'msg' => $data_code,
                    'error' => $data_message,
                    'end_time' => $end_time,
                );
            }

        }else{
            $num += 1;
            return $this->get_log($game_id , $start_time , $end_time ,$num,$data_message);
        }

    }


    /**获取游戏接口
     * @param int $num
     * @param string $code
     * @param string $message
     * @return array
     */
    public function get_game( $num = 1,$code ='' , $message = ''){
        if($num > 3)
        {
            return $this->echo_cmd('get_game_time_out');
        }
        $this->check_info();
        $encrypt_data = array(
            "action" => '49',
            "ts"     => $this->current_time(),
            "parent" => $this->jdb_agent,
            "lang"   => "ch",
        );
        $x = $this->encrypt($encrypt_data);
        $data = $this->api_query($x);
        $encrypt_data['lang'] = 'en';
        $en_x = $this->encrypt($encrypt_data);
        $en_data = $this->api_query($en_x);
        $data_code = isset($data['status']) ? $data['status'] : '';
        $data_message = isset($data['err_text']) ? $data['err_text'] : '';
        if(!empty($data['data'])){
            if($data_code == "0000"){
                $game_list = array();
                foreach($data['data'] as $k => $v) {
                    if ($v['gType'] == 7 || $v['gType'] == 0 || $v['gType'] == 9 || $v['gType'] == 18) {
                        switch($v['gType'])
                        {
                            case 7:
                                $type_id = 3;
                                break;
                            case 0:
                                $type_id = 1;
                                break;
                            case 9:
                                $type_id = 1;
                                break;
                            case 18:
                                $type_id = 2;
                                break;
                            default:
                        }
                        foreach ($v['list'] as $key => $value) {
                            $new_array = array(
                                "platform_id" => $this->platform_id,
                                "game_code" => $value['mType'],
                                "game_name_cn" => $value['name'],
                                'game_name_en' => $en_data['data'][$k]['list'][$key]['name'],
                                'game_name_tw' => '',
                                'pic' => $value['image'],
                                "module_id" => '',
                                "type_id" => $type_id,
                                "status" => 1,
                                "query_info" => $v['gType'],
                                "screen" => 2,
                                "pc" => 1,
                                "wap" => 1
                            );
                            $game_list[$value['mType']] = $new_array;
                        }
                    }
                }
                return array('status' => 1, 'msg' => $game_list);
            }else{
                $num += 1;
                return $this->get_game($num , $data_code , $data_message);
            }
        }else{
            $num += 1;
            return $this->get_game($num , $data_code , $data_message);
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
            $login['status'] = 1;
            if($login['status'] != 1  ){
                $num += 1;
                return $this->user_out_game($user_money, $step, $num);
            }
            $step = 2;
        }
        if($step == 2){
            if($user_money == 0){
                switch($this->game_info['type_id'])
                {
                    case 2:
                        sleep(30);
                        break;
                    case 3:
                        sleep(2);
                        break;
                    default:
                        break;
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