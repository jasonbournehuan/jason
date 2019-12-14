<?php
define('cache_file', 'cache.txt');
function gid_to_tid($game_id){
	$arr = array(
		//时时彩
		133 => 1,//五分彩
		234 => 1,//腾讯分分彩
		142 => 1,//二分时时彩
		231 => 1,//一分彩
		233 => 1,//五分时时彩
		131 => 1,//一分时时彩
		132 => 1,//三分时时彩
		101 => 1,//重庆时时彩
		103 => 1,//新疆时时彩
		201 => 1,//老腾讯彩
		202 => 1,//老QQ彩
		208 => 1,//河内分分彩
		232 => 1,//三分彩
		235 => 1,//QQ分分彩
		//PK10
		333 => 2,//五分PK10
		301 => 2,//北京PK拾
		331 => 2,//极速PK10
		332 => 2,//三分PK10
		//快3
		631 => 3,//极速快3
		633 => 3,//五分快3
		602 => 3,//广西快3
		603 => 3,//江苏快3
		604 => 3,//安徽快3
		605 => 3,//北京快3
		607 => 3,//甘肃快3
		608 => 3,//河北快3
		609 => 3,//湖北快3
		610 => 3,//吉林快3
		632 => 3,//三分快3
		634 => 3,//十分快3
		//11选5
		501 => 4,//广东11选5
		502 => 4,//黑龙江11选5
		503 => 4,//江西11选5
		504 => 4,//山东11选5
		//飞艇，未完成
		302 => 5,//幸运飞艇
		//快乐10
		711 => 7,//广东快十
		//没有动画
		/*
		801 => 1,//香港六合彩
		401 => 1,//幸运28
		701 => 1,//北京快乐8
		802 => 1,//福彩3D
		831 => 1,//极速六合彩
		431 => 1,//极速蛋蛋
		432 => 1,//三分蛋蛋
		433 => 1,//五分蛋蛋
		803 => 1,//排列三
		804 => 1,//排列5
		832 => 1,//三分六合彩
		833 => 1,//五分六合彩
		834 => 1,//极速福彩3D
		835 => 1,//极速排列三
		836 => 1,//极速排列5
		931 => 1,//扑克分分彩
		932 => 1,//快乐扑克
		933 => 1,//扑克龙虎斗
		934 => 1,//百家乐
		935 => 1,//炸金花
		936 => 1,//欢乐牛牛
		937 => 1,//骰子分分彩
		938 => 1,//麻将分分彩
		939 => 1,//生肖分分彩
		940 => 1,//星座分分彩
		941 => 1,//石头剪刀布
		942 => 1,//欢乐骰宝
		*/
	);
	if(!empty($arr[$game_id])){
		return $arr[$game_id];
	}else{
		return 0;
	}
}
//给与下期时间与下期期号
function get_game_down_time($game_id, $qi){
	$time = get_system_time();
	$down_time = $down_qi = 0;
	switch ($game_id) {
		case 133://五分彩
			$down_time = make_300_time();
			$qi_date = date('Ymd', $time);
			$qi_h_date = date('H', $time);
			$qi_i_date = date('i', $time);
			$now_qi = ($qi_h_date * 12) + intval($qi_i_date/5);
			$down_qi = $qi_date.sprintf('%04s', $now_qi) + 1;
			break;
		case 234://腾讯分分彩
			$down_time = make_60_time();
			$qi_date = date('Ymd', $time);
			$qi_h_date = date('H', $time);
			$qi_i_date = date('i', $time);
			$now_qi = ($qi_h_date * 60) + intval($qi_i_date);
			$down_qi = $qi_date.sprintf('%04s', $now_qi) + 1;
			break;
		case 142://二分时时彩
			$down_time = make_120_time();
			$qi_date = date('Ymd', $time);
			$qi_h_date = date('H', $time);
			$qi_i_date = date('i', $time);
			$now_qi = ($qi_h_date * 30) + intval($qi_i_date/2);
			$down_qi = $qi_date.sprintf('%04s', $now_qi) + 1;
			break;
		case 231://一分彩
			$down_time = make_60_time();
			$qi_date = date('Ymd', $time);
			$qi_h_date = date('H', $time);
			$qi_i_date = date('i', $time);
			$now_qi = ($qi_h_date * 60) + intval($qi_i_date);
			$down_qi = $qi_date.sprintf('%04s', $now_qi) + 1;
			break;
		case 233://五分时时彩
			$down_time = make_300_time();
			$qi_date = date('Ymd', $time);
			$qi_h_date = date('H', $time);
			$qi_i_date = date('i', $time);
			$now_qi = ($qi_h_date * 12) + intval($qi_i_date/5);
			$down_qi = $qi_date.sprintf('%04s', $now_qi) + 1;
			break;
		case 131://一分时时彩
			$down_time = make_60_time();
			$qi_date = date('Ymd', $time);
			$qi_h_date = date('H', $time);
			$qi_i_date = date('i', $time);
			$now_qi = ($qi_h_date * 60) + intval($qi_i_date);
			$down_qi = $qi_date.sprintf('%04s', $now_qi) + 1;
			break;
		case 132://三分时时彩
			$down_time = make_180_time();
			$qi_date = date('Ymd', $time);
			$qi_h_date = date('H', $time);
			$qi_i_date = date('i', $time);
			$now_qi = ($qi_h_date * 20) + intval($qi_i_date/3);
			$down_qi = $qi_date.sprintf('%04s', $now_qi) + 1;
			break;
		case 201://老腾讯彩
			$down_time = make_60_time();
			$qi_date = date('Ymd', $time);
			$qi_h_date = date('H', $time);
			$qi_i_date = date('i', $time);
			$now_qi = ($qi_h_date * 60) + intval($qi_i_date);
			$down_qi = $qi_date.sprintf('%04s', $now_qi) + 1;
			break;
		case 202://老QQ彩
			$down_time = make_60_time();
			$qi_date = date('Ymd', $time);
			$qi_h_date = date('H', $time);
			$qi_i_date = date('i', $time);
			$now_qi = ($qi_h_date * 60) + intval($qi_i_date);
			$down_qi = $qi_date.sprintf('%04s', $now_qi) + 1;
			break;
		case 208://河内分分彩
			$down_time = make_60_time();
			$qi_date = date('Ymd', $time);
			$qi_h_date = date('H', $time);
			$qi_i_date = date('i', $time);
			$now_qi = ($qi_h_date * 60) + intval($qi_i_date);
			$down_qi = $qi_date.sprintf('%04s', $now_qi) + 1;
			break;
		case 232://三分彩
			$down_time = make_180_time();
			$qi_date = date('Ymd', $time);
			$qi_h_date = date('H', $time);
			$qi_i_date = date('i', $time);
			$now_qi = ($qi_h_date * 20) + intval($qi_i_date/3);
			$down_qi = $qi_date.sprintf('%04s', $now_qi) + 1;
			break;
		case 235://QQ分分彩
			$down_time = make_60_time();
			$qi_date = date('Ymd', $time);
			$qi_h_date = date('H', $time);
			$qi_i_date = date('i', $time);
			$now_qi = ($qi_h_date * 60) + intval($qi_i_date);
			$down_qi = $qi_date.sprintf('%04s', $now_qi) + 1;
			break;
		case 333://五分PK10
			$down_time = make_300_time();
			$qi_date = date('Ymd', $time);
			$qi_h_date = date('H', $time);
			$qi_i_date = date('i', $time);
			$now_qi = ($qi_h_date * 12) + intval($qi_i_date/5);
			$down_qi = $qi_date.sprintf('%04s', $now_qi) + 1;
			break;
		case 632://三分快3
			$down_time = make_180_time();
			$qi_date = date('Ymd', $time);
			$qi_h_date = date('H', $time);
			$qi_i_date = date('i', $time);
			$now_qi = ($qi_h_date * 20) + intval($qi_i_date/3);
			$down_qi = $qi_date.sprintf('%04s', $now_qi) + 1;
			break;
		case 634://十分快3
			$down_time = make_600_time();
			$qi_date = date('Ymd', $time);
			$qi_h_date = date('H', $time);
			$qi_i_date = date('i', $time);
			$now_qi = ($qi_h_date * 6) + intval($qi_i_date/10);
			$down_qi = $qi_date.sprintf('%04s', $now_qi) + 1;
			break;
		case 331://极速PK10
			$down_time = make_60_time();
			$qi_date = date('Ymd', $time);
			$qi_h_date = date('H', $time);
			$qi_i_date = date('i', $time);
			$now_qi = ($qi_h_date * 60) + intval($qi_i_date);
			$down_qi = $qi_date.sprintf('%04s', $now_qi) + 1;
			break;
		case 332://三分PK10
			$down_time = make_180_time();
			$qi_date = date('Ymd', $time);
			$qi_h_date = date('H', $time);
			$qi_i_date = date('i', $time);
			$now_qi = ($qi_h_date * 20) + intval($qi_i_date/3);
			$down_qi = $qi_date.sprintf('%04s', $now_qi) + 1;
			break;
		case 631://极速快3
			$down_time = make_60_time();
			$qi_date = date('Ymd', $time);
			$qi_h_date = date('H', $time);
			$qi_i_date = date('i', $time);
			$now_qi = ($qi_h_date * 60) + intval($qi_i_date);
			$down_qi = $qi_date.sprintf('%04s', $now_qi) + 1;
			break;
		case 633://五分快3
			$down_time = make_300_time();
			$qi_h_date = date('H', $time);
			$qi_i_date = date('i', $time);
			$now_qi = ($qi_h_date * 12) + intval($qi_i_date/5);
			$qi_date = date('Ymd', $time);
			$down_qi = $qi_date.sprintf('%04s', $now_qi) + 1;
			break;
		case 602://广西快3
			$down_data = make_k3_time(602);
			$down_time = $down_data['down_time'];
			$down_qi = $down_data['down_qi'];
			break;
		case 603://江苏快3
			$down_data = make_k3_time(603);
			$down_time = $down_data['down_time'];
			$down_qi = $down_data['down_qi'];
			break;
		case 604://安徽快3
			$down_data = make_k3_time(604);
			$down_time = $down_data['down_time'];
			$down_qi = $down_data['down_qi'];
			break;
		case 605://北京快3
			$down_data = make_k3_time(605);
			$down_time = $down_data['down_time'];
			$down_qi = $down_data['down_qi'];
			break;
		case 607://甘肃快3
			$down_data = make_k3_time(607);
			$down_time = $down_data['down_time'];
			$down_qi = $down_data['down_qi'];
			break;
		case 608://河北快3
			$down_data = make_k3_time(608);
			$down_time = $down_data['down_time'];
			$down_qi = $down_data['down_qi'];
			break;
		case 609://湖北快3
			$down_data = make_k3_time(609);
			$down_time = $down_data['down_time'];
			$down_qi = $down_data['down_qi'];
			break;
		case 610://吉林快3
			$down_data = make_k3_time(610);
			$down_time = $down_data['down_time'];
			$down_qi = $down_data['down_qi'];
			break;
		case 501://广东11选5
			$down_data = make_11x5_time(501);
			$down_time = $down_data['down_time'];
			$down_qi = $down_data['down_qi'];
			break;
		case 502://黑龙江11选5
			$down_data = make_11x5_time(502);
			$down_time = $down_data['down_time'];
			$down_qi = $down_data['down_qi'];
			break;
		case 503://江西11选5
			$down_data = make_11x5_time(503);
			$down_time = $down_data['down_time'];
			$down_qi = $down_data['down_qi'];
			break;
		case 504://山东11选5
			$down_data = make_11x5_time(504);
			$down_time = $down_data['down_time'];
			$down_qi = $down_data['down_qi'];
			break;
		case 301://北京PK拾，算法和11选5一致
			$down_data = make_11x5_time(301);
			$down_time = $down_data['down_time'];
			$down_qi = $qi + 1;
			break;
		case 711://广东快十
			$down_data = make_11x5_time(711, 3);
			$down_time = $down_data['down_time'];
			$down_qi = $down_data['down_qi'];
			break;
		case 103://新疆时时彩
			$down_data = make_xjssc_time(103);
			$down_time = $down_data['down_time'];
			$down_qi = $down_data['down_qi'];
			break;
		case 101://重庆时时彩
			$down_data = make_cqssc_time(101);
			$down_time = $down_data['down_time'];
			$down_qi = $down_data['down_qi'];
			break;
		case 302://幸运飞艇
			$down_data = make_ft_time();
			$down_time = $down_data['down_time'];
			$down_qi = $down_data['down_qi'];
			break;
	}
	return array('down_time' => $down_time, 'down_qi' => $down_qi);
}
//生成系统时间，防止出错
function get_system_time(){
	return time() + 28800;
}
//生成分分彩下期时间
function make_60_time(){
	$time = get_system_time();
	$now_s_time = intval(date('s', $time));
	$now_c_time = 55- $now_s_time;
	$i_time = $time + $now_c_time;
	return $i_time;
}
//生成二分彩下期时间
function make_120_time(){
	$time = get_system_time();
	$now_i_time = intval(date('i', $time));
	$now_s_time = intval(date('s', $time));
	$c_time = $now_i_time%2;
	$jian_time = 0;
	if($c_time >= 1){
		$jian_time = $c_time * 60;
	}
	$now_c_time = 115- $jian_time - 2 - $now_s_time;
	$i_time = $time + $now_c_time;
	return $i_time;
}
//生成三分彩下期时间
function make_180_time(){
	$time = get_system_time();
	$now_i_time = intval(date('i', $time));
	$now_s_time = intval(date('s', $time));
	$c_time = $now_i_time%3;
	$jian_time = 0;
	if($c_time >= 1){
		$jian_time = $c_time * 60;
	}
	$now_c_time = 175- $jian_time - $now_s_time;
	$i_time = $time + $now_c_time;
	return $i_time;
}
//生成五分彩下期时间
function make_300_time(){
	$time = get_system_time();
	$now_i_time = intval(date('i', $time));
	$now_s_time = intval(date('s', $time));
	$c_time = $now_i_time%5;
	$jian_time = 0;
	if($c_time >= 1){
		$jian_time = $c_time * 60;
	}
	$now_c_time = 295- $jian_time - $now_s_time;
	$i_time = $time + $now_c_time;
	return $i_time;
}
//生成幸运飞艇下期时间
function make_ft_time(){
	$time = get_system_time();
	$start = 46860;//01:06开始计算
	$end = 14700;//04:05结束计算
	$total_qi = 180;//总共180期
	$qi_date = $qi_date1 = date('Ymd', $time);
	$qi_int_time = strtotime($qi_date);
	$qi_time = $time - $qi_int_time;
	if($qi_time < $end){
		//昨日数据
		$qi_date = $qi_date1 = date('Ymd', $time - 86400);
		$qi_int_time = strtotime($qi_date);
	}
	for($i = 1; $i <= $total_qi; $i++){
		$new_qi_time = $qi_int_time + $start + $i * 300 - 150;
		if($new_qi_time >= $time){
			//echo date("Y-m-d H:i:s", $new_qi_time).'||'.date("Y-m-d H:i:s", $time);exit;
			$qi_time = $new_qi_time;
			$qi = $qi_date.sprintf('%03s', $i);
			return array('down_qi' => $qi, 'down_time' => $qi_time);
		}
	}
}
//生成十分彩下期时间
function make_600_time(){
	$time = get_system_time();
	$now_i_time = intval(date('i', $time));
	$now_s_time = intval(date('s', $time));
	$c_time = $now_i_time%10;
	$jian_time = 0;
	if($c_time >= 1){
		$jian_time = $c_time * 60;
	}
	$now_c_time = 595- $jian_time - $now_s_time;
	$i_time = $time + $now_c_time;
	return $i_time;
}
//生成快3下期时间与期号
function make_k3_time($game_id){
	$arr = array(
		602 => array(//广西快3
			'start' => 34200,
			'end' => 81000,
			'num' => 40,
			'time' => '09:30',
		),
		603 => array(//江苏快3
			'start' => 31800,
			'end' => 79800,
			'num' => 41,
			'time' => '08:50',
		),
		604 => array(//安徽快3
			'start' => 32400,
			'end' => 79200,
			'num' => 40,
			'time' => '09:00',
		),
		605 => array(//北京快3
			'start' => 33600,
			'end' => 85200,
			'num' => 44,
			'time' => '09:20',
		),
		607 => array(//甘肃快3
			'start' => 37200,
			'end' => 79200,
			'num' => 36,
			'time' => '10:20',
		),
		608 => array(//河北快3
			'start' => 31800,
			'end' => 79800,
			'num' => 41,
			'time' => '08:50',
		),
		609 => array(//湖北快3
			'start' => 33600,
			'end' => 79200,
			'num' => 39,
			'time' => '09:20',
		),
		610 => array(//吉林快3
			'start' => 31200,
			'end' => 78000,
			'num' => 40,
			'time' => '08:40',
		),
	);
	$time = get_system_time();
	$game_start_time = $arr[$game_id];
	$qi_date = date('Ymd', $time);
	$qi_int_time = strtotime($qi_date);
	$qi_time = $time - $qi_int_time;
	if($qi_time < $game_start_time['start']){
		//当日第一期
		$qi = $qi_date.'001';
		$qi_time1 = date('Y-m-d '.$game_start_time['time'].':00', $time);
		$qi_time = strtotime($qi_time1);
	}else if($qi_time > $game_start_time['end']){
		//次日第一期
		$qi_date = date('Ymd', $time + 86400);
		$qi = $qi_date.'001';
		$qi_time1 = date('Y-m-d '.$game_start_time['time'].':00', $time + 86400);
		$qi_time = strtotime($qi_time1);
	}else{
		$down_qi = ceil(($qi_time - $game_start_time['start'] + 30)/ 1200) + 1;
		$qi = $qi_date.sprintf('%03s', $down_qi);
		$qi_time = ($qi_int_time + $game_start_time['start']) + 1200 * ($down_qi - 1) - 30;
	}
	return array('down_qi' => $qi, 'down_time' => $qi_time);
}
//生成11选5下期时间与期号
function make_11x5_time($game_id, $length = 2){
	$arr = array(
		501 => array(//广东11选5
			'start' => 34200,
			'end' => 83400,
			'num' => 42,
			'time' => '09:30',
		),
		502 => array(//黑龙江11选5
			'start' => 30000,
			'end' => 81600,
			'num' => 44,
			'time' => '08:20',
		),
		503 => array(//江西11选5
			'start' => 34200,
			'end' => 83400,
			'num' => 42,
			'time' => '09:30',
		),
		504 => array(//山东11选5
			'start' => 32400,
			'end' => 84600,
			'num' => 43,
			'time' => '09:00',
		),
		301 => array(//PK10
			'start' => 33000,
			'end' => 85800,
			'num' => 44,
			'time' => '09:10',
		),
		711 => array(//广东快十
			'start' => 33600,
			'end' => 83400,
			'num' => 42,
			'time' => '09:20',
		),
	);
	$time = get_system_time();
	$game_start_time = $arr[$game_id];
	$qi_date = date('Ymd', $time);
	$qi_int_time = strtotime($qi_date);
	$qi_time = $time - $qi_int_time; 
	//echo  strtotime('08:20:00');exit;
	if($qi_time < $game_start_time['start']){
		//当日第一期
		$qi = $qi_date.sprintf('%0'.($length - 1).'s', '1');
		$qi_time1 = date('Y-m-d '.$game_start_time['time'].':00', $time);
		$qi_time = strtotime($qi_time1);
	}else if($qi_time > $game_start_time['end']){
		//次日第一期
		$qi_date = date('Ymd', $time + 86400);
		$qi = $qi_date.sprintf('%0'.($length - 1).'s', '1');
		$qi_time1 = date('Y-m-d '.$game_start_time['time'].':00', $time + 86400);
		$qi_time = strtotime($qi_time1);
	}else{
		$down_qi = ceil(($qi_time - $game_start_time['start'] + 30)/ 1200) + 1;
		$qi = $qi_date.sprintf('%0'.$length.'s', $down_qi);
		//echo $qi_int_time ."||". $game_start_time['start'].'||'.$down_qi;exit;
		$qi_time = ($qi_int_time + $game_start_time['start']) + 1200 * ($down_qi - 1) - 30;
		//echo $qi.'<br>';echo date("Y-m-d H:i:s",$qi_time);exit;
	}
	return array('down_qi' => $qi, 'down_time' => $qi_time);
}
//生成重庆时时彩下期时间
function make_cqssc_time($game_id, $length = 3){
	$arr = array(
		101 => array(//重庆时时彩
			'start' => 1800,
			'start2' => 27000,
			'end' => 11400,
			'end2' => 85800,
			'num' => 59,
			'time' => '00:30',
			'time2' => '07:30',
		),
	);
	$time = get_system_time();
	$game_start_time = $arr[$game_id];
	$qi_date = date('Ymd', $time);
	$qi_int_time = strtotime($qi_date);
	$qi_time = $time - $qi_int_time; 
	if($qi_time > $game_start_time['end'] && $qi_time < $game_start_time['start2']){
		//在未开奖期间，返回今日第10期
		$down_qi = 10;
		$qi = $qi_date.sprintf('%0'.$length.'s', $down_qi);
		$qi_time = $qi_int_time + $game_start_time['start2'] - 30;
	}else if($qi_time >= $game_start_time['end2']){
		//次日第1期开始
		$qi_date = date('Ymd', $time + 86400);
		$down_qi = 1;
		$qi = $qi_date.sprintf('%0'.$length.'s', $down_qi);
		$qi_time1 = date('Y-m-d '.$game_start_time['time'].':00', $time + 86400);
		$qi_time = strtotime($qi_time1);
	}else if($qi_time >= $game_start_time['start2']){
		//当日第10期开始
		$down_qi = ceil(($qi_time - $game_start_time['start2'] + 30)/ 1200);
		$qi = $qi_date.sprintf('%0'.$length.'s', $down_qi + 10);
		$qi_time = ($qi_int_time + $game_start_time['start2']) + 1200 * ($down_qi) - 30;
	}else if($qi_time >= $game_start_time['start']){
		//当日第1期开始
		$down_qi = ceil(($qi_time - $game_start_time['start'] + 30)/ 1200) + 1;
		$qi = $qi_date.sprintf('%0'.$length.'s', $down_qi);
		$qi_time = ($qi_int_time + $game_start_time['start']) + 1200 * ($down_qi - 1) - 30;
	}
	return array('down_qi' => $qi, 'down_time' => $qi_time);
}
//生成新疆时时彩下期时间
function make_xjssc_time($game_id, $length = 3){
	$arr = array(
		103 => array(//新疆时时彩
			'start' => 37200,
			'end' => 7200,
			'num' => 48,
			'time' => '10:20',
		),
	);
	$time = get_system_time();
	$game_start_time = $arr[$game_id];
	$qi_date = date('Ymd', $time);
	$qi_int_time = strtotime($qi_date);
	$qi_time = $time - $qi_int_time; 
	if($qi_time > $game_start_time['end'] && $qi_time < $game_start_time['start']){
		//在未开奖期间，返回次日第一期
		$qi_date = date('Ymd', $time);
		$qi = $qi_date.sprintf('%0'.$length.'s', '1');
		$qi_time1 = date('Y-m-d '.$game_start_time['time'].':00', $time);
		$qi_time = strtotime($qi_time1);
	}else if($qi_time >= $game_start_time['start']){
		//当日第一期开始
		$down_qi = ceil(($qi_time - $game_start_time['start'] + 30)/ 1200) + 1;
		$qi = $qi_date.sprintf('%0'.$length.'s', $down_qi);
		$qi_time = ($qi_int_time + $game_start_time['start']) + 1200 * ($down_qi - 1) - 30;
	}else{
		//凌晨时间前日第42期开始
		$down_qi = ceil($qi_time/ 1200);
		$qi_date = date('Ymd', $time - 86400);
		$qi = $qi_date.sprintf('%0'.$length.'s', 42 + $down_qi);
		$qi_time = $qi_int_time + 1200 * ($down_qi) - 30;
		//echo date("Y-m-d H:i:s", $qi_time) ."||". $game_start_time['start'].'||'.$down_qi.'||'.$qi;exit;
	}
	return array('down_qi' => $qi, 'down_time' => $qi_time);
}
function format_data($tid, $data, $game_id){
	$time = get_system_time();
	$int_time = strtotime($data['lastOpenTime']);
	$int_i_time = date('Y-m-d H:i', $int_time);
	$down_data = get_game_down_time($game_id, $data['lastPeriod']);
	//print_r($down_data);exit;
	if($tid == 1 || $tid == 3 || $tid == 4 || $tid == 6 || $tid == 7){
		$code = explode(',', $data['lastElements']);
		$hezhi = 0;
		foreach($code as $k => $v){
			$code[$k] = intval($v);
			$hezhi += $v;
		}
		$qi_num = intval(substr($data['lastPeriod'], -3));
		$new_data = array(
			"dragonTiger" => 0,//龙虎，0龙，1虎，2和
			"drawCount" => $qi_num,//已开期数
			"drawIssue" => $down_data['down_qi'],//下期期号
			"drawTime" => date("Y-m-d H:i:s", $down_data['down_time']),//下期开奖时间
			"firstNum" => $code[0],//第一个号码
			"secondNum" => $code[1],//第二个号码
			"thirdNum" => $code[2],//第三个号码
			"lotCode" => $game_id,//
			"preDrawCode" => $data['lastElements'],//
			"preDrawDate" => "",//
			"preDrawIssue" => $data['lastPeriod'],//当期期号
			"preDrawTime" => "",//
			"serverTime" => date("Y-m-d H:i:s", $time),//服务器时间
			"sumBigSmall" => 0,//总和大小
			"sumNum" => $hezhi,//和值
			"sumSingleDouble" => 1,//总和单双
		);
		if(isset($code[3])){
			$new_data['fourthNum'] = $code[3];//第四个号码
		}
		if(isset($code[4])){
			$new_data['fifthNum'] = $code[4];//第五个号码
		}
		if($hezhi%2 == 0){
			$new_data['sumSingleDouble'] = 1;
		}
		if($hezhi < 23){
			$new_data['sumBigSmall'] = 1;
		}
		$end_number = count($code) -1;
		if($code[0] > $code[$end_number]){
			$new_data['dragonTiger'] = 0;
		}else if($code[0] < $code[$end_number]){
			$new_data['dragonTiger'] = 1;
		}else{
			$new_data['dragonTiger'] = 2;
		}
	}else if($tid == 2 || $tid == 5){
		$data['lastPeriod'] = intval(str_replace(date('Ymd', $time), '', $data['lastPeriod']));
		$code = explode(',', $data['lastElements']);
		foreach($code as $k => $v){
			$code[$k] = intval($v);
		}
		$new_data = array(
			"gameCode" => "",
			"issue" =>  $down_data['down_qi'],//下期期号
			"openDateTime" => $down_data['down_time'] - $time,//剩余秒数
			"openNum" => $code,//开奖号码
			"preIssue" => $data['lastPeriod'],//当期期号
		);
	}
	return $new_data;
}
//获取指定游戏数据，判断是否需要更新缓存
function get_data($game_id){
	$time = get_system_time();
	$cache_time = filemtime(cache_file);
	if($time - $cache_time >= 5){
		$cache_info = get_all_data();
	}
	if(empty($cache_info)){
		$cache_info = file_get_contents(cache_file);
	}
	$list = json_decode($cache_info, true);
	if(!empty($list[$game_id])){
		return $list[$game_id];
	}else{
		return '';
	}
}
//获取所有数据，保存缓存
function get_all_data(){
	$api = "https://api.world-motor.cn/cp/result/gameStats/list";
	$cookie = $cache_data = '';
	$data = array();
	$header = array(
		'Origin: https://www.1lc00.com',
		'R-Token: 1',
		'Referer: https://www.1lc00.com/cpResult/list',
		'User-Agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Mobile Safari/537.36',
		'X-Token: kL?17AQWkL817AQFeA7u:bdaca17c-632d-4816-859b-670896531551',
	);
	$response = postRequest( $api, $data, $cookie, $header);
	$response = trim($response);
	$json = json_decode($response, true);
	if(!empty($json['data']['list'])){
		foreach($json['data']['list'] as $k => $v){
			$new_data[$v['gameId']] = $v;
		}
		$cache_data = json_encode($new_data);
		file_put_contents(cache_file, $cache_data);
	}
	return $cache_data;
}

/**
* 发起一个post请求到指定接口
*
* @param string $api 请求的接口
* @param array $params post参数
* @param int $timeout 超时时间
* @return string 请求结果
*/
function postRequest( $api, array $params = array(), $cookie = '', $header = array(), $timeout = 10 ) {
    $ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//这个是重点。
    curl_setopt( $ch, CURLOPT_URL, $api );
    // 以返回的形式接收信息
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
	// 不验证https证书
	curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
	curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
	curl_setopt( $ch, CURLOPT_TIMEOUT, $timeout );
	curl_setopt( $ch, CURLOPT_POST, 1 );
	if(!empty($params)){
		// 设置为POST方式
		curl_setopt( $ch, CURLOPT_POST, 1 );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $params ) );
	}
	if(!empty($header)){
		curl_setopt( $ch, CURLOPT_HTTPHEADER, $header);
	}
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	//curl_setopt($ch, CURLOPT_HEADER, true);
	if(!empty($cookie)){
		curl_setopt($ch,CURLOPT_COOKIE, $cookie);
	}
    // 发送数据
    $response = curl_exec( $ch );
    // 不要忘记释放资源
    curl_close( $ch );
    return $response;
}