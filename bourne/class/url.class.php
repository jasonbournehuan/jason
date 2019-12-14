<?php
class url extends base_model{
	function __construct() {
		parent::__construct();
		$this->c('cache_redis');
		$this->cache_redis->select($this->conf['redis_db']);
	}

    public function add_url($form,$num = 1 )
    {
        if($num > 3)
        {
            return array(
                'status' => 2,
                'message' => 'redis服务异常，请稍后再试!'
            );
        }
        if(empty($form))
        {
            return array(
                'status' => 2,
                'message' => '内容不能为空，请稍后再试!',
            );
        }
        $key = md5($form);
        $cache_key = 'ag_'.$key;
        $this->c('cache_redis');
        $this->cache_redis->select($this->conf['redis_db']);
        $add_cache = $this->cache_redis->setex($cache_key,60 , $form);
        if(!empty($add_cache))
        {
            return array(
                'status' => 1 ,
                'message' => '' ,
                'url' =>  $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/center_url.php?token='.$key,
            );
        }else{
            $num ++;
            return $this->add_url($form,$num);
        }

    }


	public function get_url($key){
		$cache_key = 'ag_'.$key;
		$infos = $this->cache_redis->kGet($cache_key);
		if(!empty($infos)){
			echo $infos;exit;
		}else{
			header('HTTP/1.1 404 Not Found');
			exit();
		}
	}
}
?>