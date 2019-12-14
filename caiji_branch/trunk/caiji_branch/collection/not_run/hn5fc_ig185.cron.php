<?php
$typeid = 9999;//彩种ID
$cron_name = '河内五分彩';
// https://ig185.com/kjProgram/html/home.html	// 首页
echo   '网站数据不对,暂不执行';exit;
$url = "https://ig185.com/kaijiangweb/getHistoryList.do?date=&lotCode=HANOI_300";//抓取地址
$datas = $this->cjig185->cj($url);
$data = $datas['data'];
$yid = $datas['yid'];//采集源ID  4
//print_r($data);exit;//打印格式化后的数据
?>