<?php
	$typeid = 10018;//彩种ID
	$cron_name = '北京快3';
	// https://ig185.com/kjProgram/html/home.html	// 首页
	$url = "https://api.api861861.com/lotteryJSFastThree/getBaseJSFastThree.do?issue=&lotCode=10033";//抓取地址
	        
    $datas = $this->cjtw1680380->cj($url,'');
    $data = $datas['data'];
    $yid = $datas['yid'];//采集源ID    4
  //   print_r($data);exit;//打印格式化后的数据
?>