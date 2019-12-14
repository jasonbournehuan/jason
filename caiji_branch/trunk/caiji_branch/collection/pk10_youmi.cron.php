<?php
$typeid = 10001;//彩种ID
$cron_name = 'PK10';
// https://ig185.com/kjProgram/html/home.html	// 首页
$url = "http://dm2212.com:90/Result/GetLotteryResultList?gameID=29&pageSize=30";//抓取地址
$datas = $this->cjyoumi->cj($url,'hold');
$data = $datas['data'];
/*var_dump($data);die;*/
$yid = $datas['yid'];//采集源ID  8
//print_r($data);exit;//打印格式化后的数据
?>