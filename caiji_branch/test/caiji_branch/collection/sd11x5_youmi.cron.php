<?php
$typeid = 10029;//彩种ID
$cron_name = '山东11选5';
// https://ig185.com/kjProgram/html/home.html	// 首页
$url = "http://dm2212.com:90/Result/GetLotteryResultList?gameID=32&pageSize=30";//抓取地址
$datas = $this->cjyoumi->cj($url,'hold');
$data = $datas['data'];

$yid = $datas['yid'];//采集源ID  8
//print_r($data);exit;//打印格式化后的数据
?>