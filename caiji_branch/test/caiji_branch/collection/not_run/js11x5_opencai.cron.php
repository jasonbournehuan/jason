<?php
//收费接口　暂时　不运行
	$typeid = 10026;//彩种ID
	$cron_name = '江苏11选5';
	echo  '收费接口，暂时不运行';exit;
	$url = "http://t.apiplus.net/js11x5-20.json?_=".$_SERVER['time'].rand(100, 999);//要抓取数据的页面地址
    $datas = $this->cjopnecai->cj($url);
    $data = $datas['data'];
    $yid = $datas['yid'];//采集源ID 5
	//print_r($data);exit;//测试是否抓取到页面数据
?>