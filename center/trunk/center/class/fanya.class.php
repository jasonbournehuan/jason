<?php
/**泛亚接口
 * Class fanya
 * 最短拉取时间 无间隔
 */
class fanya extends base_model{
    function __construct() {
        parent::__construct();
        //网站ID
        $this->platform_id = 4;
        $this->platform_name = '泛亚电竞';
        //API授权信息
        $this->fanya_Authorization = $this->conf['platform'][$this->platform_id]['Authorization'];
        //加载ID转CODE类和错误代码类
        $this->c('id_to_code');
        $this->c('error');
        //API接口域名
        $this->fanya_api_url = $this->conf['platform'][$this->platform_id]['url'];
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
    private $order_id;
    /**
     * 检测接口需求信息
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

    //通用递交接口
    public function api_query($api, $data){
        $url = $this->fanya_api_url.$api;//要抓取数据的页面地址
        $header = array(
            'Authorization: '.$this->fanya_Authorization,
        );

        $info = $this->za->curlPost($url, $data, 3, 5, '', $header);//请求接口数据
        $data = json_decode($info, true);
        return $data;
    }

    //开户接口
    public function reg($num = 1){
        if($num > 3){
            return $this->echo_cmd('reg_user_error');
        }
        $this->check_info();
        $api = "/api/user/register";//api接口
        $api_data = array(
            'UserName' => $this->game_user['username'],
            'password' => $this->game_user['password'],
        );
        $data = $this->api_query($api, $api_data);
        if(isset($data['success'])){
            if($data['success'] == 1){
                return array('status' => 1, 'msg' => '');
            }else if($data['info']['Error'] == 'EXISTSUSER'){
                //用户被注册表示用户已经开户好了，直接返回成功
                return array('status' => 1, 'msg' => '');
            }else{
                $num += 1;
                return $this->reg($num);
            }
        }else{
            $num += 1;
            return $this->reg($num);
        }
        return $data;
    }

    //登陆接口
    public function login($game_id = '', $num = 1){
        if($num > 3){
            return $this->echo_cmd('login_user_error');
        }
        $this->check_info();
        $api = "/api/user/login";//api接口
        $api_data = array(
            'UserName' => $this->game_user['username'],
        );
        $data = $this->api_query($api, $api_data);
        if(isset($data['success'])){
            if($data['success'] == 1){
                return array('status' => 1, 'msg' => $data['info']['Url']);
            }else if($data['info']['Error'] == 'NOUSER'){
                //未开户，进行开户后再登录
                $reg = $this->reg();
                $num += 1;
                return $this->login($game_id, $num);
            }else{
                $num += 1;
                return $this->login($game_id, $num);
            }
        }else{
            $num += 1;
            return $this->login($game_id, $num);
        }
    }

    //退出接口，有则接入，无则直接返回成功
    public function outlogin($num = 1){
        if($num > 3){
            return $this->echo_cmd('user_outlogin_error');
        }
        $out_login = $this->login();
        if($out_login['status'] == 1){
            return array('status' => 1, 'msg' => '');
        }else{
            $num += 1;
            return $this->outlogin($num);
        }
    }

    //转入资金接口，部分接口不是同接口互转，所以独立一个函数方便整合，若接口支持同接口互转则不使用该函数，但是必须保留函数名称，防止出错
    //泛亚转入转出接口通用一个，所以该函数可以不使用
    public function in_money($money){
        return 1;
    }

    //转出资金接口，部分接口不是同接口互转，所以独立一个函数方便整合，若接口支持同接口互转则不使用该函数，但是必须保留函数名称，防止出错
    //泛亚转入转出接口通用一个，所以该函数可以不使用
    public function out_money($money){
        return 1;
    }

    /**不能有特殊字符 _
     * 生成订单id
     */
    private function set_order_id()
    {
        list($use,$sec) = explode(' ',microtime());
        $Current_ms = sprintf('%.0f',(floatval($use)+floatval($sec)) * 1000 );
        $this->order_id  =  substr($Current_ms.$this->game_user['username'],0,32);
    }

    /** 获取订单id
     * @return mixed
     */
    private function get_order_id()
    {
        return $this->order_id;
    }


    //转入转出资金接口
    public function in_out_money($money, $type, $num = 1){
        if($num > 3){
            return $this->echo_cmd('in_out_money_error');
        }
        if($money <= 0){
            return $this->echo_cmd('in_out_money_number_error');
        }
        if($type == 1){
            $in_out_type = 'IN';
        }else{
            $in_out_type = 'OUT';
        }
        $api = "/api/user/transfer";//api接口
        $order_id = $this->get_order_id();
        $api_data = array(
            'UserName' => $this->game_user['username'],
            'Money' => $money,
            'Type' => $in_out_type,
            'ID' => $order_id,
        );
        $data = $this->api_query($api, $api_data);
        $this->log('start',$data);
        $check_money = $this->check_transfer($order_id,$money);
        if($check_money['status'] == 1 ){
            return array('status' => 1, 'platform_order_id' => $order_id , 'data' => '' , 'money' => $check_money['money']);
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
        $api = "/api/user/transferinfo";//api接口
        $api_data = array(
            'ID' => $order_id,
        );
        $data = $this->api_query($api, $api_data);
        $this->log('end',$data);
        if(isset($data['info']['Status']) && $data['info']['Status'] == "Finish")
        {
            return array('status' => 1, 'msg' => '', 'data' =>'','money' => intval($data['info']['Money']));
        }else
        {
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
        $this->za->make_log($this->platform_id.'_'.$this->game_user['uid'],time(),$type,json_encode($data),"transfer");
    }

    //查询用户资金接口
    public function get_money($num = 1){
        if($num > 3){
            return $this->echo_cmd('get_user_money_out');
        }
        $this->check_info();
        $api = "/api/user/balance";//api接口
        $api_data = array(
            'UserName' => $this->game_user['username'],
        );
        $data = $this->api_query($api, $api_data);
        if(isset($data['success'])){
            if($data['success'] == 1){
                return array('status' => 1, 'balance' => intval($data['info']['Money']*100)/100);
            }else if($data['info']['Error'] == 'NOUSER'){
                return $this->echo_cmd('user_nothing');
            }else{
                $num += 1;
                return $this->get_money($num);
            }
        }else{
            $num += 1;
            return $this->get_money($num);
        }
    }


    //获取记录接口
    public function get_log($start_time,$end_time, $num = 1){

        if($num > 3){
            return array('status' => -1,
                'msg' => '采集数据超时',
                'error' => '99999999',
                'end_time' => $end_time,
            );
        }
        $api = "/api/log/get";//api接口
        $api_data = array(
            'Type' => 'UpdateAt',//请求的类型  CreateAt：下单时间；  UpdateAt：订单数据更新时间(建议使用此字段做日志采集）;   ResultAt：结果产生时间;    RewardAt：结算时间;   UserName：根据用户名查询
            'StartAt' => date('Y/m/d H:i:s',$start_time),//开始时间
            'EndAt' => date('Y/m/d H:i:s',$end_time),//结束时间
            'UserName' => '',//用户名，如果 Type=UserName 则为必须
            'PageIndex' => 1,//要查询的页码（默认为第一页）
        );
        $data = $this->api_query($api, $api_data);
        if(isset($data['success'])){
            if($data['success'] == 1){
                $return = array('status' => 1, 'msg' => '', 'end_time' => 0, 'end_id' => 0, 'end_page' => '', 'data' => array());
                if(!empty($data['info']['list'])){
                    foreach($data['info']['list'] as $k => $v){
                        $return['data'][] = $v;
                    }
                    $total_page = ceil($data['info']['RecordCount'] / $data['info']['PageSize']);
                    if($total_page > 1){
                        for($i = 2; $i <= $total_page; $i++){
                            $api_data['PageIndex'] = $i;
                            $data = $this->api_query($api, $api_data);
                            if(!empty($data['info'])){
                                foreach($data['info']['list'] as $k => $v){
                                    $return['data'][] = $v;
                                }
                            }else{
                                //防止接口请求失败丢失数据，只要抓取失败就停止循环
                                break;
                            }
                        }
                    }

                }
                $return['end_time'] =   $end_time ;
                return $return;
            }else{
                $num += 1;
                return $this->get_log($start_time,$end_time,$num);
            }
        }else{

            $num += 1;
            return $this->get_log($start_time,$end_time,$num);
        }
    }

    //获取游戏接口
    public function get_game($game_id = '', $num = 1){
        if($num > 3){
            return $this->echo_cmd('get_game_time_out');
        }
        //$this->check_info();  不需要传送参数
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