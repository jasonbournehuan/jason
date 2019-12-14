<?php
$typeid = 10009;//彩种ID
$cron_name = '双色球';
$url = "https://1395q.com/news/index.php/index/fcssq/getLotteryInfo?issue=&lotCode=10039";//抓取地址

$result = $this->cj1395q->cj($url,'');
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
$data = $result['data'];
$yid = $result['yid'];//采集源ID 4
//print_r($data);exit;//打印格式化后的数据
?>