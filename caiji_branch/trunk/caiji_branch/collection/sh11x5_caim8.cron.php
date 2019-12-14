<?php
	$typeid = 10028;//彩种ID
	$cron_name = '上海11选5';
	// https://ig185.com/kjProgram/html/home.html	// 首页
	$url = "https://www.caim8.com/openApi/for_fresh";//抓取地址
    $result = $this->cjcaim8->cj($url,'10');
    if(!empty($result['data']))
	{
	    foreach($result['data'] as  $key => $value)
	    {
	        $new_haoma = explode(',',$value['haoma']);
	        foreach($new_haoma as $k => $v)
	        {
	            $new_haoma[$k] = intval($v);
	        }
	        $result['data'][$key]['haoma'] = implode(',',$new_haoma);
	    }
	}
    $data = $result['data'];//多一个0
    $yid = $result['yid'];//采集源ID 4
	//print_r($data);exit;//打印格式化后的数据

?>