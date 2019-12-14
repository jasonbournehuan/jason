<?php
class cjcpapi extends base_model{
    function __construct()
    {
        parent::__construct();
    }
    private $token_url = "https://www.caipiaoapi.com/";
    private $redis_key = "caipiaoapi_token";
    private $lock_name = "lock_caipiaoapi_token";

    public function cj($url,$method = 'common')
    {
        $cache_token =   $this->token();
        if(!empty($cache_token['time']) && !empty($cache_token['passwd']))
        {
            $api_url = $url.'&time='.$cache_token['time'].'&passwd='.$cache_token['passwd'];
            $data = $datas = array();
            $cookie = '';

            $result = $this->za->curlPost($api_url,array(),3,5,$cookie,array(),'',1);

            $datas = json_decode($result,true);
            if(!empty($datas['result']['data']))
            {
                        $data = $this->$method($datas['result']['data']);
            }

            $return = array(
                "data" => array_slice($data,0,50,true),
                "yid" => 9
            );
            return $return;
        }else{
            echo '获取token错误';
        }
    }

    public function common($result)
    {
        $data = array();
        foreach($result as $key =>  $value)
        {
            $data[$value['preDrawIssue']] = array(
                
                'haoma' => $value['preDrawCode'],
                'time'  => strtotime($value['preDrawTime'])
            );
        }
        return $data;
    }

    public function lhc($result)
    {
        $data = array();
        foreach($result as $key =>  $value)
        {
            $data[$value['gid']] = array(
                'haoma' => $value['award'],
                'time'  => strtotime($value['time'])
            );
        }
        return $data;
    }

    public function xn28($result)
    {
        $data = array();
        foreach($result as $key =>  $value)
        {
            $data[$value['gid']] = array(
                'haoma' => $value['award'],
                'time'  => strtotime($value['time'])
            );
        }
        return $data;
    }

    public function gd11x5($result)
    {
        $data = array();
        foreach($result as $key => $value)
        {
            $data[substr($value['preDrawIssue'],0,8).substr($value['preDrawIssue'],9,strlen($value['preDrawIssue']))] = array(
                'haoma' => $value['preDrawCode'],
                'time'  => strtotime($value['preDrawTime'])
            );
        }
        return $data;
    }

    public function jx11x5($result)
    {
        $data = array();
        foreach($result as $key => $value)
        {
            $data[substr($value['preDrawIssue'],0,8).substr($value['preDrawIssue'],9,strlen($value['preDrawIssue']))] = array(
                'haoma' => $value['preDrawCode'],
                'time'  => strtotime($value['preDrawTime'])
            );
        }
        return $data;
    }

    public function sd11x5($result)
    {
        $data = array();
        foreach($result as $key => $value)
        {
            $data[substr($value['preDrawIssue'],0,8).substr($value['preDrawIssue'],9,strlen($value['preDrawIssue']))] = array(
                'haoma' => $value['preDrawCode'],
                'time'  => strtotime($value['preDrawTime'])
            );
        }
        return $data;
    }

    public function sh11x5($result)
    {
        $data = array();
        foreach($result as $key => $value)
        {
            $data[substr($value['preDrawIssue'],0,8).substr($value['preDrawIssue'],9,strlen($value['preDrawIssue']))] = array(
                'haoma' => $value['preDrawCode'],
                'time'  => strtotime($value['preDrawTime'])
            );
        }
        return $data;
    }



    public function token()
    {
        $token  = json_decode($this->cache_redis->kGet($this->redis_key),true);
        if(!empty($token) && ($_SERVER['time'] - $token['time']) < 900 )
        {
            return $token;
        }else{
            $lock = $this->cache_redis->setnx($this->lock_name,$_SERVER['time']);
            if($lock == 1)
            {

                $cookie = '';
                $data = $result_data  = array();
                $curl_data  = $this->za->curlPost($this->token_url, array(), 3, 5, $cookie, array(), '', 1);
                $time = '/<input type="hidden" id="ajax_time" value[\s]*?=[\s]*?\"(.*?)\"/i';
                $passwd = '/<input type="hidden" id="ajax_passwd" value[\s]*?=[\s]*?\"(.*?)\"/i';
                preg_match_all($time,$curl_data,$data_list);
                preg_match_all($passwd,$curl_data,$data_pwd);
                if(!empty($data_list[1][0]) && !empty($data_pwd[1][0]) )
                {
                    $new_time = $data_list[1][0];
                    $new_passwd = $data_pwd[1][0];
                    $redis_data  = array(
                        "time" => $new_time,
                        "passwd" => $new_passwd
                    );
                  $cache_result =   $this->cache_redis->kSet($this->redis_key,json_encode($redis_data));
                }
                if(!empty($cache_result) )
                {
                    $this->cache_redis->del($this->lock_name);
                    return  $redis_data;
                } else {

                    $this->cache_redis->del($this->lock_name);
                    return $this->token();
                }
            }elseif(($_SERVER['time'] - $this->cache_redis->kGet($this->lock_name)) > 5 ){

                $this->cache_redis->del($this->lock_name);
            //    sleep(2);
                return  $this->token();
            }

            sleep(2);
            return  $this->token();
        }



    }





}

?>