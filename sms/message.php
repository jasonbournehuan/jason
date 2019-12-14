<?php
function config(){
   return array(
	   "host" => "127.0.0.1",
	   "port" => "6379",
	   "auth" => "a3bb8b0bebb9078d9222c0cf565d99e0",
   );
}
function check_sign($data){
	$sign_key = "L2rVNmFMYm34qg9tswRBYjVBewDpUqzk";
	ksort($data);
	$sign = http_build_query($data);
	return md5($sign."key=".$sign_key);
}
if(!empty($_POST)){
       $result = array(
           "action" => $_POST['action'],
           "phone" => $_POST['phone'],
           "timestamp" => $_POST['timestamp'],
           "result" => $_POST['result'],
           "key" => $_POST['key'],
           "secret" => $_POST['secret'],
           "sign" => $_POST['sign'],
       );
    check_params($result);
    include_once "common/common.class.php";
    $config = config();
    $attr = array(
        "timeout" => 30,
        "db_id" => 0,
    );
    $redis = Redis_client::getInstance($config,$attr);
    $key = md5($result['phone']."i8YoZL6d00vsNqPdLXorhcFEZBF7saPA");
    $check_time = $redis->get($key);
    if(!empty($check_time) ){
        $fail = array(
            "status" => 3,
            "message" => "30秒内只能请求一次",
        );
        over($fail);
    }
    if($redis->setex($key,30,time())){
        include_once "class/". $result['action'] .".class.php";
        $message = new $result['action']();
        $message->set_key($result['key']);
        $message->set_secret($result['secret']);
        $result  = $message->push($_POST['result']);
        if($result == 1){
            $data = array(
                "status" => 1 ,
                "message" => "success",
            );
            over($data);
        }
    }
    $data = array(
        "status" => 2 ,
        "message" => "fail",
    );
    over($data);
}else{
    $false = array(
        "status" => 3,
        "message" => "error",
    );
    over($false);
}
function over($data){
	echo json_encode($data);exit;
}

function check_params($result){
   foreach($result as $key => $value){
	   if(empty($value)){
		   $false =   array(
			   "status" => 2,
			   "message" => "required ". $key . " params",
		   );
		   over($false);
	   }
   }
   if(!is_file("class/".$result['action'].".class.php")){
	   $false =   array(
		   "status" => 2,
		   "message" => "Not Fount function",
	   );
	   over($false);
   }
   if(time() - $result['timestamp'] > 30){
	   $false =   array(
		   "status" => 2,
		   "message" => "Request time out",
	   );
	   over($false);
   }
   if(!preg_match('/^1[3456789]\d{9}$/',  $result['phone'])){
	   $false =   array(
		   "status" => 2,
		   "message" => "Phone error",
	   );
	   over($false);
   }
   $data = $result;
   unset($data['sign']);
   $sign = check_sign($data);
   if($sign !== $result['sign']){
	   $false =   array(
		   "status" => 2,
		   "message" => "sign error",
	   );
	   over($false);
   }
}