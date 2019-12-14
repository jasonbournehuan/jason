<?php
$typeid = 10026;//彩种ID
$cron_name = '江苏11选5';
// https://ig185.com/kjProgram/html/home.html	// 首页
$url = "http://dm2212.com:90/Result/GetLotteryResultList?gameID=62&pageSize=30";//抓取地址
$datas = $this->cjyoumi->cj($url,'change');
$data = $datas['data'];
$yid = $datas['yid'];//采集源ID  8
//print_r($data);exit;//打印格式化后的数据
?>