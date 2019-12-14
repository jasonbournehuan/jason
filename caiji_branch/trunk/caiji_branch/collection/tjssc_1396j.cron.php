<?php
	$typeid = 10012;//彩种ID
	$cron_name = '天津时时彩';
	$url = 'https://m.1396j.com/tjssc/history';//要抓取数据的页面地址
    $result_datas = $this->cj1396j->cj($url,"rule3");
    if(!empty($result_datas['data']))
    {
        $key_array = array();
        $value_array = array();
        foreach($result_datas['data'] as  $key => $value)
        {
            $key_array[] = substr_replace($key,'0','-2','0');
            $value_array[] = $value;
        }
        $result_datas['data'] = array_combine($key_array,$value_array);
    }

    $data = $result_datas['data'];
    $yid = $result_datas['yid'];//采集源ID   3
?>