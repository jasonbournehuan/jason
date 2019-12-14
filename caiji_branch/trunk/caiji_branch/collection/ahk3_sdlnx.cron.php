<?php
$typeid = 10019;//彩种ID
$cron_name = '安徽快3';
// https://ig185.com/kjProgram/html/home.html	// 首页
$url = "https://b.cnyl168.com/Result/GetLotteryResultList?gameID=80&pageSize=50";//抓取地址
$datas = $this->cjsdlnx->cj($url);
$data = $datas['data'];
$yid = $datas['yid'];//采集源ID  8
//print_r($data);exit;//打印格式化后的数据
?>