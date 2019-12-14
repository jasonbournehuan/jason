<?php
$typeid = 10012;//彩种ID
$cron_name = '天津时时彩';
$url = "http://api.264274.com/CQShiCai/getBaseCQShiCai.do?issue=&lotCode=10003";//抓取地址
		
$result = $this->cj264274->cj($url);
$data = $result['data'];
 
$yid = $result['yid'];//采集源ID  9
//print_r($data);exit;//打印格式化后的数据
?>