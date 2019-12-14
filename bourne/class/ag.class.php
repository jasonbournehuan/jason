<?php

/**leg接口
 * Class leg
 * 最短拉取时间 10秒
 */
class ag extends base_model{
    private $order_id;
    private   $code_cn = array(
        0 => '成功',
        1 => 'TOKEN 丢失（重新调用登录接口获取）',
        3 => '验证时间超时（请检查 timestamp 是否正确）',
        4 => '验证错误',
        5 => '渠道白名单错误（请联系客服添加服务器白名单）',
        6 => '验证字段丢失（请检查参数完整性）',
        7 => '',
        8 => '不存在的请求（请检查子操作类型是否正确）',
        9 => '',
        10 => '',
        11 => '',
        12 => '',
        13 => '',
        14 => '',
        15 => '渠道验证错误（1.MD5key 值是否正确；2.生成 key 值中的 timestamp 与
参数中的是否一致；3. 生成 key 值中的 timestamp 与代理编号以字符串
形式拼接）',
        16 => '数据不存在（当前没有注单）',
        17 => '',
        18 => '',
        19 => '',
        20 => '账号禁用',
        21 => '',
        22 => 'AES 解密失败',
        23 => '',
        24 => '渠道拉取数据超过时间范围',
        25 => '',
        26 => '订单号不存在',
        27 => '数据库异常',
        28 => 'ip 禁用',
        29 => '订单号与订单规则不符',
        30 => '获取玩家在线状态失败',
        31  => '更新的分数小于或者等于 0',
        32  => '更新玩家信息失败',
        33  => '更新玩家金币失败',
        34  => '订单重复',
        35  => '获取玩家信息失败（请调用登录接口创建账号）',
        36  => 'KindID 不存在',
        37  => '登录瞬间禁止下分，导致下分失败',
        38  => '余额不足导致下分失败',
        39  => '禁止同一账号登录带分、上分、下分并发请求，后一个请求被拒',
        40  => '单次上下分数量不能超过一千万',
        41  => '拉取对局汇总统计时间范围有误',
        42  => '代理被禁用',
        43  => '拉单过于频繁(两次拉单时间间隔必须大于 5 秒)',
        44  => '订单正在处理中',
        1001  => '注册会员账号系统异常',
        1002  => '代理商金额不足',

    );
    function __construct() {
        parent::__construct();
        //加载ID转CODE类和错误代码类
        //date_default_timezone_set("Etc/GMT+4");
        $this->c('id_to_code');
        $this->c('error');
        //API接口域名
        $this->current_time = round(microtime(true)*1000);

        //用户信息
        $this->game_user = array();
        //网站ID
        $this->platform_id = 13;
        $this->platform_name = 'ag';
        $this->api_url  = $this->conf['platform'][$this->platform_id]['url'];
        $this->api_url2 = $this->conf['platform'][$this->platform_id]['url1'];
        $this->agent = $this->conf['platform'][$this->platform_id]['agent'];
        $this->deskey = $this->conf['platform'][$this->platform_id]['desKey'];
        $this->md5key = $this->conf['platform'][$this->platform_id]['md5Key'];
        $this->site_id = 0;
        $this->en_site_id = '';
        $this->game_type = 'h5';//默认H5页面，支持H5和APP两个模式
        $this->user_ip = '';//用户IP
        $this->site_url = '';//客户端网站地址，

        //用户名最大最小长度限制
        $this->max_username_len = 20;
        $this->min_username_len = 5;
        $this->game_info = array();//20190625新增
        $this->return_type = 1;
    }

    /**检测接口需求信息
     * @return array|string
     */
    public function check_info()
    {
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

    /**
     * @return string
     */
    private function leg_key()
    {
        return md5($this->agent.$this->current_time.$this->md5key);
    }

    //通用递交接口
    public function api_query($params, $url_type = '',$data = array(), $result_type = 1, $view_info = 0){
        if(empty($url_type)){
            $key = strtolower(md5($params.$this->md5key));
            $url = $this->api_url."params=".$params."&key=".$key;
        }else{
            $key = strtolower(md5($params.$this->md5key));
            $url = $this->api_url2."params=".$params."&key=".$key;
            return $url;
        }
        $info = $this->za->curlPost($url, $data, 3, 30, '', array(), '', $view_info);//请求接口数据
        if($result_type == 1){
            $data = $this->xml_parser($info);
            return $data;
        }else{
            return $info;
        }
    }

    /**
     * 生成订单id
     */
    public function set_order_id()
    {
        $Current_ms = round(microtime(true)*1000);
        $this->order_id  =  substr($this->agent.'_'.$Current_ms.'_'.$this->game_user['username'],0,30);
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

    /**开户接口  登录包含了注册  没有该接口
     * @param int $num
     * @return array|string
     */
    public function reg($num = 1){
        if($num > 3){
            return $this->echo_cmd('reg_user_error');
        }
        $this->check_info();
        $api_data = array(
            'cagent' => $this->agent, //代理编码，数值 =“XXXXXXXX”, 这是一個常數, 請參考”发布说明 / 上线说明第 1 项
            'loginname' => $this->game_user['username'],  //游戏账号的登錄名, 必須少于 20 個字元 不可以带特殊字符，只可以数字，字母，下划线
            'method' => 'lg',  //数值 = “lg” 代表 ”检测并创建游戏账号(CheckOrCreateGameAccout)”, 是一個常數
            'actype' => '1',  //actype=1 代表真錢账号; actype=0 代表试玩账号,
            'password' => $this->game_user['password'],  //游戏账号的密码必须少于20字符不支持以下字符:' , “ , \ , / , > , < , & , # , -- , % , ? , $, 空格, 双节字 符(全角字), TAB键, NULL, 換行符(\N)
            'oddtype' => 'A',  //详情请参考 “参数文档.pdf” 2 oddtype 参数
            'cur' => 'CNY',  //货币转换的具体数值等详情请参考 “参数文档.pdf” 3 currency 参数 一旦创建成功后便不能修改
        );
        $params = $this->encrypt($api_data);
        $data = $this->api_query($params);
        if(isset($data['@attributes'])   ){
            //  用户被注册也表示用户已经开户好了，直接返回成功
            if(  $data['@attributes']['info'] === '0'    ) {
                return array('status' => 1, 'msg' => '');
            }
            $num += 1;
            return $this->reg($num);
        }else{
            $num += 1;
            return $this->reg($num);
        }
    }


    private function encrypt($data){
        $data = http_build_query($data,'',"/\\\\/");
        $data = addslashes($data);
        $encode = openssl_encrypt($data,"DES-ECB",$this->deskey);
        return $encode;
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
        $this->check_info();
        $api_data = array(
            "cagent" => $this->agent, //代理编码，数值 =“XXXXXXXX”, 这是一個常數, 請參考”发布说明 / 上线说明第 1 项”
            "loginname" => $this->game_user['username'],//游戏账号的登錄名, 必須少于 20 個字元不可以带特殊字符，只可以数字，字母，下划线
            "password" => $this->game_user['password'],//请參考 ‘检测或创建游戏账号 CheckOrCreateGameAccount’(3.1.3.1) 的密碼描述
            "dm" => '',//dm’ 代表返回的网站域名例如：您的网站域名是 www.bet.com, dm = www.bet.com
            "sid" => $this->order_id,//sid = (cagent+序列), 序列是唯一的 13~16 位数,例如: cagent = ‘XXXXX’ 及 序列 = 1234567890987,sid = XXXXX1234567890987
            "actype" => 1, //actype=1 代表真钱账号 actype=0 代表试玩账号
            "lang" => 'zh-cn',//详情请参考 “参数文档.pdf” 4 language 参数
            "gameType" => $this->game_info['game_code'],//各平台最新gametype游戏列表，请參考 “参数文档.pdf” 1 gametype参数和”XIN gametype文档.pdf”
            "oddtype" => 'A',  //盘口, 设定新玩家可下注的范围值: A、B、C、D、E、F、G、H 及 I默认值: A玩家的下注范围(人民币):**其他币种的下注范围, 请参考 AG 国际厅游戏后台管理系统内“系统公共盘口”A (20~50000)
            "cur" => 'CNY',//详情请参考 “参数文档.pdf” 3 currency参数
            "mh5" => 'y',//mh5=y 代表 AGIN 移动网页版
            "session_token" => '',//生成方式：当用戶登陆网站，网站保存Session Token在内存，用于验证用户合法性
        );
        $params = $this->encrypt($api_data);
        $data = $this->api_query($params,1);
        $form = sprintf("<form id = 'formData' method = 'post' action = '%s'>",$data);
        foreach($api_data as $key => $value)
        {
            $form .= sprintf("<input type = 'hidden' name = '%s' value = '%s'/>",$key,$value);
        }
        $form .= "</form><script langugua = 'javascript'>document.getElementById('formData').submit()</script>";
        $this->c('url');
        $result = $this->url->add_url($form);
        if($result['status'] == 1 ){
                return array('status' => 1, 'msg' => $result['url']);
        }else{
            $num += 1;
            return $this->login($game_id,$num);
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
        $param = array(
            's' => 8,//操作子类型
            'account' => $this->game_user['username'],//会员帐号(64 位字符)
        );
        $param = $this->encrypt($param);
        $data = $this->api_query($param, array(), '', 1, '');
        $data_code = isset($data['d']['code']) ? $data['d']['code'] : '9999';
        if(!empty($data['s'])){
            if($data_code == "0"  || $data_code == '35')
            {
                return array('status' => 1, 'msg' => '');
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

    /** ag转账需要两步操作 预转账接口
     * @param $type
     * @param $money
     * @param int $num
     * @return array|string
     */
    public function prepare_transfer( $type  , $money , $num = 1)
    {
        if($num > 3)
        {
            return $this->echo_cmd('in_out_money_error');
        }
        if(empty($type))
        {
            return $this->echo_cmd('in_out_money_error');
        }
        $api_data = array(
            'cagent' => $this->agent, //代理编码，数值 =“XXXXXXXX”, 这是一個常數, 請參考”发布说明 / 上线说明第 1 项
            'loginname' => $this->game_user['username'],  //游戏账号的登錄名, 必須少于 20 個字元 不可以带特殊字符，只可以数字，字母，下划线
            'method' => 'tc',  //值 = “tc” 代表”预备转账 PrepareTransferCredit”, 是一个常数
            'billno' => $this->order_id,  //billno = (cagent+序列), 序列是唯一的 13~16 位数, 例如:cagent = ‘XXXXX’ 及 序列 = 1234567890987, 那么billno = XXXXX1234567890987
            'type' => $type,  //值 = “IN” or “OUT”IN: 从网站账号转款到游戏账号; OUT: 從遊戲账號转款到網站賬號
            'credit' => $money,  //转款额度(如 000.00), 只保留小数点后两个位, 即:100.00
            'actype' => '1',  //actype=1 代表真錢账号; actype=0 代表试玩账号,
            'password' => $this->game_user['password'],  //游戏账号的密码必须少于20字符不支持以下字符:' , “ , \ , / , > , < , & , # , -- , % , ? , $, 空格, 双节字 符(全角字), TAB键, NULL, 換行符(\N)
            'cur' => 'CNY',  //货币转换的具体数值等详情请参考 “参数文档.pdf” 3 currency 参数 一旦创建成功后便不能修改
        );
        $params = $this->encrypt($api_data);
        $data = $this->api_query($params);
        if(isset($data['@attributes']) && $data['@attributes']['info'] === '0' )
        {
                return array(
                    "status" => 1,
                    "msg" => 'prepare transfer success',
                );
        }else
        {
            $num++;
            return $this->prepare_transfer( $type  , $money , $num );
        }
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
        //订单号使用1-19位数字，所以与其他不同，不可直接加密
        if($type == 1){
            $in_out_type = "IN";
        }else{
            $in_out_type = "OUT";
        }
        $this->set_order_id();
        $prepare_transfer_status = $this->prepare_transfer($in_out_type,$money);
        if($prepare_transfer_status['status'] != 1 )
        {
            return $this->echo_cmd('in_out_money_error');
        }
        $api_data = array(
            'cagent' => $this->agent, //代理编码，数值 =“XXXXXXXX”, 这是一個常數, 請參考”发布说明 / 上线说明第 1 项
            'loginname' => $this->game_user['username'],  //游戏账号的登錄名, 必須少于 20 個字元 不可以带特殊字符，只可以数字，字母，下划线
            'method' => 'tcc',  //值= “tcc” 代表“转账确认 TransferCreditComfirm”, 是一个常数
            'billno' => $this->order_id,  //数值跟‘預備轉賬 PrepareTransferCredit’ API 的 billno
            'type' => $in_out_type,  //数值跟‘預備轉賬 PrepareTransferCredit’ API 的 type
            'credit' => $money,  //数值跟‘預備轉賬 PrepareTransferCredit’ API 的 credit
            'actype' => '1',  //actype=1 代表真錢账号; actype=0 代表试玩账号,
            'flag' => '1',  //值 = 1 代表调用‘预备转账 PrepareTransferCredit’ API 成功 值 = 0 代表调用‘預備轉賬 PrepareTransferCredit’出错或出现错误码
            'password' => $this->game_user['password'],  //游戏账号的密码必须少于20字符不支持以下字符:' , “ , \ , / , > , < , & , # , -- , % , ? , $, 空格, 双节字 符(全角字), TAB键, NULL, 換行符(\N)
            'cur' => 'CNY',  //货币转换的具体数值等详情请参考 “参数文档.pdf” 3 currency 参数 一旦创建成功后便不能修改
        );
        $params = $this->encrypt($api_data);
        $data = $this->api_query($params);
        $logo_data = array(
            "request_info" => $api_data,
            "return" => $data,
        );
        $log = $this->log('start',$logo_data);
        $result = $this->check_transfer($money);
        if($result['status'] == 1 ){
            return array('status' => 1, 'platform_order_id' => $this->order_id , 'data' => '' , 'money' => $money);
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
        $api_data = array(
            'cagent' => $this->agent, //代理编码，数值 =“XXXXXXXX”, 这是一個常數, 請參考”发布说明 / 上线说明第 1 项
            'billno' => $this->order_id,  //billno = (cagent+序列), 序列是唯一的 13~16 位数, 例如:cagent = ‘XXXXX’ 及 序列 = 1234567890987, 那么billno = XXXXX1234567890987
            'method' => 'qos',  //值 = “qos” 代表”查询(QueryOrderStatus)”, 是一个常数
            'actype' => '1',  //actype=1 代表真錢账号; actype=0 代表试玩账号,
            'cur' => 'CNY',  //货币转换的具体数值等详情请参考 “参数文档.pdf” 3 currency 参数 一旦创建成功后便不能修改
        );
        $params = $this->encrypt($api_data);
        $data = $this->api_query($params);
        $logo_data = array(
            "request_info" => $api_data,
            "return" => $data,
        );
        $log = $this->log('end',$logo_data);
        if(isset($data['@attributes']) && $data['@attributes']['info'] === '0' )
        {
            return array('status' => 1, 'msg' => 'check orders success' , 'money' => '');
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
     * @param string $message
     * @return array
     */
    public function get_money($num = 1 ){
        if($num > 3){
            return $this->echo_cmd('get_user_money_out');
        }
        $this->check_info();
        $api_data = array(
            'cagent' => $this->agent, //代理编码，数值 =“XXXXXXXX”, 这是一個常數, 請參考”发布说明 / 上线说明第 1 项
            'loginname' => $this->game_user['username'],  //游戏账号的登錄名, 必須少于 20 個字元 不可以带特殊字符，只可以数字，字母，下划线
            'method' => 'gb',  //值 = “gb” 代表”查询余额(GetBalance)”, 是一个常数
            'actype' => '1',  //actype=1 代表真錢账号; actype=0 代表试玩账号,
            'password' => $this->game_user['password'],  //游戏账号的密码必须少于20字符不支持以下字符:' , “ , \ , / , > , < , & , # , -- , % , ? , $, 空格, 双节字 符(全角字), TAB键, NULL, 換行符(\N)
            'cur' => 'CNY',  //货币转换的具体数值等详情请参考 “参数文档.pdf” 3 currency 参数 一旦创建成功后便不能修改
        );
        $params = $this->encrypt($api_data);
        $data = $this->api_query($params);
        if(isset($data['@attributes']['info']) && $data['@attributes']['info'] !== "error"){
                return array(
                    'status' => 1,
                    'balance' => $data['@attributes']['info'],
                    'deny_balance' => '0',
                );
        }else{
            $num += 1;
            return $this->get_money($num);
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
    public function get_log($game_id = '', $start_time , $end_time , $num = 1 ,$error=''){
        if($num > 3 or  $start_time > $end_time){
            return array(
                'status' => -1,
                'msg' => '采集失败',
                'error' => $error,
                'end_time' => $end_time,
            );
        }
          $url = "http://fa3gn1.gdcapi.com:3333/getslotorders_ex.xml?startdate=2019-12-15 03:50:00&enddate=2019-12-15
04:00:00&cagent=TST";
        $api_data = array(
            "cagent" => $this->agent, //代理编码，数值 =“XXXXXXXX”, 这是一個常數, 請參考”发布说明 / 上线说明第 1 项”
            "loginname" => "",//游戏账号的登錄名, 必須少于 20 個字元不可以带特殊字符，只可以数字，字母，下划线
            "password" => $this->game_user['password'],//请參考 ‘检测或创建游戏账号 CheckOrCreateGameAccount’(3.1.3.1) 的密碼描述
            "slotgametype:" => '',//dm’ 代表返回的网站域名例如：您的网站域名是 www.bet.com, dm = www.bet.com
            "billno" => $this->order_id,//sid = (cagent+序列), 序列是唯一的 13~16 位数,例如: cagent = ‘XXXXX’ 及 序列 = 1234567890987,sid = XXXXX1234567890987
            "actype" => 1, //actype=1 代表真钱账号 actype=0 代表试玩账号
            "lang" => 'zh-cn',//详情请参考 “参数文档.pdf” 4 language 参数
            "gameType" => $this->game_info['game_code'],//各平台最新gametype游戏列表，请參考 “参数文档.pdf” 1 gametype参数和”XIN gametype文档.pdf”
            "oddtype" => 'A',  //盘口, 设定新玩家可下注的范围值: A、B、C、D、E、F、G、H 及 I默认值: A玩家的下注范围(人民币):**其他币种的下注范围, 请参考 AG 国际厅游戏后台管理系统内“系统公共盘口”A (20~50000)
            "cur" => 'CNY',//详情请参考 “参数文档.pdf” 3 currency参数
            "mh5" => 'y',//mh5=y 代表 AGIN 移动网页版
            "session_token" => '',//生成方式：当用戶登陆网站，网站保存Session Token在内存，用于验证用户合法性
        );
        $params = $this->encrypt($api_data);
        $data = $this->api_query($params,1);



        $data_code = isset($data['d']['code']) ? $data['d']['code'] : '';
        $data_message = isset($this->code_cn[$data_code]) ? $this->code_cn[$data_code] : '';
        if(!empty($data)){
            if ($data['d']['code'] == 0 && $data['d']['count'] >= 1) {
                $result_data =  array(
                    "status" => 1 ,
                    'msg' => $data_message ,
                    "data" => $data['d']['list'] ,
                    'end_time' => $end_time,
                    'end_id' => '',
                    'end_page' => '',);
                return $result_data;
            } else if($data_code == 16){
                return  array(
                    "status" => 1 ,
                    'msg' => $data_message ,
                    "data" => '' ,
                    'end_time' => $end_time,
                    'end_id' => '',
                    'end_page' => '',
                );
            }else{
                return array(
                    'status' => -1,
                    'msg' => $data_code ,
                    'error' =>$data_message,
                    'end_time' => $end_time,
                );
            }
        }else{
            $num += 1;
            return $this->get_log($game_id, $start_time, $end_time, $num,$data_code);
        }

    }


    /**获取游戏接口
     * @param int $num
     * @param string $code
     * @param string $message
     * @return array
     */
    public function get_game( $num = 1){
        if($num > 3)
        {
            return $this->echo_cmd('get_game_time_out');
        }
        $kye_str = "BA0B0E0E06A387683BDF9958601C90DB";
        $lang_cns = 'zh-cn';  //language具体语言类型支持请参考”支持语言类型” ,若为空则默认为 lang_cns (简体中文)
        $withLink = 0 ;//包括多台类型：withlink, 0 为不包含多台类型, 1 为包含多台类型, 默认为 1
        $agent = "FN4";
        $key = md5($agent.$lang_cns.$withLink.$kye_str);
        $url = "http://f9bgn4.gdcapi.com:3333/gametypes.xml";
        $data = array(
            "cagent" => $agent,
            "language" => $lang_cns,
            "withlink" => $withLink,
            "key" => $key,
        );
        $result = $this->za->curlPost($url,$data,3, 5, '', array(), '', '');
        $result = $this->xml_parser($result);
        if(!empty($result))
        {
            $game_list = array();
            foreach($result['row'] as $key => $value)
            {
                switch($value['@attributes']['TYPE'])
                {
                    case "LOTTO":
                        $type_id = '';
                        break;
                    case "HUNTER":
                        $type_id = 3;
                        break;
                    case "VIDEO":
                        $type_id = 5;
                        break;
                    default:
                        $type_id = 1;
                }
                if(empty($type_id))
                {
                    continue;
                }
                $new_array = array(
                    "platform_id" => $this->platform_id,
                    "game_code" => $value['@attributes']['GAMETYPE'],
                    "game_name_cn" => trim($value['@attributes']['GAMENAME']),
                    'game_name_en' => '',
                    'game_name_tw' => '',
                    'pic' => '',
                    "module_id" => '',
                    "type_id" => $type_id,
                    "status" => 2,
                    "query_info" => '',
                    "screen" => 2,
                    "pc" => 1,
                    "wap" => 1,
                    "paixu" => '0',
                    "remarks" => '0',
                );
                $game_list[] = $new_array;
            }
            return array('status' => 1 , 'msg' => $game_list);
        }else{
            $num += 1;
            return $this->get_game($num);
        }
    }

    /** xml  to  array
     * @param $str
     * @return bool|mixed
     */
    private function xml_parser($str){
        $xml_parser = xml_parser_create();
        if(xml_parse($xml_parser,$str)){
            return (json_decode(json_encode(simplexml_load_string($str)),true));
        }else {
            return false;
        }
    }

    //进入游戏
    public function go_game($gamekind = 3, $gametype = 3001, $gamecode = 1, $num = 1){
    }

    //用户进入游戏一键转入金额接口，整合多接口使用同一函数，如未指定进入的游戏，则进入大厅
    public function user_in_game($money = 0, $game_id = '', $step = 1, $data = array(), $num = 1){

        if($num > 3){
            return $this->echo_cmd('in_money_login_time_out');
        }
        if($step == 1){
            $set_order_id = $this->set_order_id();
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
        return $this->echo_cmd('no_shiwan_error');
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