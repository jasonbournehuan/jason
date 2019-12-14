<?php
$typeid = 9999;//彩种ID
$cron_name = '河内五分彩';
// https://ig185.com/kjProgram/html/home.html	// 首页
$url = "http://dm2212.com:90/Result/GetLotteryResultList?gameID=313&pageSize=50";//抓取地址
$datas = $this->cjyoumi->cj($url,'hold');//hold表示不需要处理
$data = $datas['data'];
$yid = $datas['yid'];//采集源ID  8
//print_r($data);exit;//打印格式化后的数据
?>