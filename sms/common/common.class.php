<?php
class common{
	public function curlPost($url, $data = array(), $timeout = 600, $cookie = '', $header = array()){  
		$cacert = getcwd() . '/cacert.pem'; //CA根证书  
		$SSL = substr($url, 0, 8) == "https://" ? true : false;  
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);  
		curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);  
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout-2);
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
		curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.76 Mobile Safari/537.36" );
		if(!empty($header)){
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		}else{
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:')); //避免data数据过长问题
		} 
		if(!empty($data)){
			curl_setopt($ch, CURLOPT_POST, 1);  
			if(is_array($data)){
				curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data)); 
			}else{
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
			}
		}
		$ret = curl_exec($ch);
		curl_close($ch);  
		return $ret;    
	}
}
class redis_client
{
    private $redis;

    protected $redis_db = 0;

    protected $auth;

    static private $_instance = array();

    private $k;

    protected $attr = array(
        "timeout" => 30,
        "db_id" => 0,
    );

    protected $expireTime;

    protected $host;

    private $port;


    private function __construct($config,$attr)
    {
        $this->attr = array_merge($this->attr,$attr);
        $this->redis = new Redis();
        $this->port = isset($config['port']) ? $config['port']  : 6379 ;
        $this->host = $config['host'];
        $this->redis->connect($this->host, $this->port, $this->attr['timeout']);

        if($config['auth'])
        {
            $this->redis->auth($config['auth']);
            $this->auth = $config["auth"];
        }
        $this->expireTime = time() + $this->attr["timeout"];
    }

    public static function getInstance($config,$attr = array())
    {
        if(!is_array($attr))
        {
            $redis_db = $attr;
            $attr = array();
            $attr['db_id'] = $redis_db;
        }
        $attr['db_id'] = $attr['db_id'] ?  $attr['db_id'] : 0 ;

        $k = md5(implode('',$config).$attr['db_id']);

        if(empty(static::$_instance[$k]) || !(static::$_instance[$k] instanceof self))
        {
            static::$_instance[$k] = new self($config,$attr);
            static::$_instance[$k]->k = $k;
            static::$_instance[$k]->redis_db = $attr['db_id'];
            if($attr['db_id'] != 0){
                static::$_instance[$k]->select($attr['db_id']);
            }
        }elseif( time() > static::$_instance[$k]->expireTime)
        {
            static::$_instance[$k]->close();
            static::$_instance[$k]         =     new self($config,$attr);
            static::$_instance[$k]->k    =    $k;
            static::$_instance[$k]->redis_db=    $attr['db_id'];

            //如果不是0号库，选择一下数据库。
            if($attr['db_id']!=0){
                static::$_instance[$k]->select($attr['db_id']);
            }
        }
        return static::$_instance[$k];

    }

    private function __clone(){}


    public function select($redis_db)
    {
        $this->redis_db = $redis_db;
        return $this->redis->select($this->redis_db);
    }

    public function getDbId()
    {
        return $this->redis_db;
    }

    public function set($key,$value)
    {
        return $this->redis->set($key,$value);
    }

    public function get($key)
    {
        return $this->redis->get($key);
    }

    public function setex($key,$expire,$value)
    {
        return $this->redis->setex($key,$expire,$value);
    }

    public function setnx($key,$value)
    {
        return $this->redis->setnx($key,$value);
    }

    public function  del($key)
    {
        return $this->redis->del($key);
    }



}