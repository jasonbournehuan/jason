<?php
	$typeid = 10009;//彩种ID
	$cron_name = '双色球';
	/*
	$wayday = date("w", $_SERVER['time']);
	$int_time = intval(date("Hi", $_SERVER['time']));
	if(($wayday != 2 and $wayday != 4 and $wayday != 0) or $int_time < 2120){
		$this->on_echo($date." 不在时间 ".$cron_name." 无需采集！\r\n");
		exit;
	}
	*/
	// https://ig185.com/kjProgram/html/home.html	// 首页
	$url = "http://m.cp.360.cn/kaijiang/qkjlist?lotId=220051&page=1&r=1550777196392";//抓取地址
    $datas = $this->cj360->cj($url);
    //中奖号码过滤成整数
     foreach($datas['data'] as  $key => $value)
     {
              $new_str = explode(',',$value['haoma']);
              $new_haoma = '';
              foreach ($new_str as $k => $v)
              {
                  $new_haoma .= intval($v).',';
              }
             $datas['data'][$key]['haoma'] = substr($new_haoma,0,strlen($new_haoma)-1);
     }

    $data = $datas['data'];
    $yid = $datas['yid'];//采集源ID  1
	//print_r($data);exit;//打印格式化后的数据
?>