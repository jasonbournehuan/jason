<?php
//泛亚接口
class apidemo extends base_model{
    function __construct() {
        parent::__construct();
        //API授权信息
        $this->authorization = '1e1ef04f598d4acf87994248308a8abc';
        //加载ID转CODE类和错误代码类
        $this->c('id_to_code');
        $this->c('error');
        //API接口域名
        $this->api_url = 'http://testapi.bw-gaming.com';
        //用户信息
        $this->game_user = array();
        //网站ID
        $this->platform_id = 3;
        $this->platform_name = '泛亚电竞';
        $this->site_id = 0;
        $this->en_site_id = '';
        $this->game_type = 'h5';//默认H5页面，支持H5和APP两个模式
        $this->user_ip = '';//用户IP
        $this->site_url = '';//客户端网站地址，返回使用
        //用户名最大最小长度限制
        $this->max_username_len = 16;
        $this->min_username_len = 5;
        $this->game_info = array();//20190625新增
    }

    //检测接口需求信息，转换用户用等数据
    public function check_info(){

    }

    //通用递交接口
    public function api_query($api, $data){

    }

    //开户接口
    public function reg($num = 1){

    }

    //登陆接口
    public function login($game_id = '', $num = 1){

    }

    //退出接口，有则接入，无则直接返回成功
    public function outlogin($num = 1){

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

    //转入转出资金接口(提供外部使用) 1：转入，2：转出
    public function in_out_money($money, $type, $num = 1){

    }

    //查询转账接口，暂时不使用
    public function check_transfer($order_id, $num = 1){

    }

    //查询用户资金接口
    public function get_money($num = 1){

    }

    //获取记录接口
    public function get_log($start_time,$end_time, $num = 1){

    }

    //获取游戏接口
    public function get_game($game_id = '', $num = 1){

    }

    //用户进入游戏一键转入金额接口，整合多接口使用同一函数，如未指定进入的游戏，则进入大厅
    public function user_in_game($money = 0, $game_id = '', $step = 1, $data = array(), $num = 1){

    }

    //用户退出游戏一键转出金额接口，整合多接口使用同一函数，生成新登陆地址可以退出已登陆用户
    public function user_out_game($user_money = 0, $step = 1, $num = 1){

    }

    //试玩接口，暂时不使用
    public function demo($game_id = '', $num = 1){

    }
}
?>