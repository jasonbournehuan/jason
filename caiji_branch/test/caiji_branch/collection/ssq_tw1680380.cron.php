
<?php
	$typeid = 10009;//彩种ID
	$cron_name = '双色球';
	//每周二、四、日 21:20开奖
	$wayday = date("w", $_SERVER['time']);
	$int_time = intval(date("Hi", $_SERVER['time']));
	if(($wayday != 2 and $wayday != 4 and $wayday != 0) or $int_time < 2120){
		$this->on_echo($date." 不在时间 ".$cron_name." 无需采集！\r\n");
		exit;
	}
	// https://ig185.com/kjProgram/html/home.html	// 首页
	$url = "https://api.api861861.com/QuanGuoCai/getLotteryInfo.do?issue=&lotCode=10039";//抓取地址
    $result = $this->cjtw1680380->cj($url,'');
    if(!empty($result['data']))
	{
	    foreach($result['data'] as  $key => $value)
	    {
	        $new_haoma = explode(',',$value['haoma']);
	        foreach($new_haoma as $k => $v)
	        {
	            $new_haoma[$k] = intval($v);
	        }
	        $result['data'][$key]['haoma'] = implode(',',$new_haoma);
	    }
	}
    $data = $result['data'];
    
    $yid = $result['yid'];//采集源ID 4
	//print_r($data);exit;//打印格式化后的数据
?>