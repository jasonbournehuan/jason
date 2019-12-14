<?php
!defined('FRAMEWORK_PATH') && exit('FRAMEWORK_PATH not defined.');

include BBS_PATH.'control/common_control.class.php';

class lhc_control extends common_control {
	
	function __construct() {
		parent::__construct();
		$this->typeid = 28;//游戏ID
		$this->game_name = '香港六合彩';
		$shi = date("H", $_SERVER['time']);
		$fen = date("i", $_SERVER['time']);
		if($shi >= 23 and $shi < 21){
			$this->on_echo(" ".$this->game_name."23-21点不采集\r\n");
			exit;
		}
	}

	//采集数据
	public function on_lhcdata(){
		//采集源ID = 1
		$yid = 1;
		$intdate = date("Ymd", $_SERVER['time']);
		$date = date("m-d H:i:s", $_SERVER['time']);
		$this->on_echo(" ".$date."进行".$this->game_name."采集\r\n");
		//$urldate = date("Y-m-d", $_SERVER['time']);
		$cache = $this->mcache->read('caiji');
		if(!empty($cache[$this->typeid])){
			$qidate = substr($cache[$this->typeid], 0, 8);
			$num = substr($cache[$this->typeid], 8, 3);
			$qidate_info = strtotime(substr($cache[$this->typeid], 0, 4).'-'.substr($cache[$this->typeid], 4, 2).'-'.substr($cache[$this->typeid], 6, 2));
			if($qidate < $intdate){
				if($num == 120){
					$data_time = $qidate_info + 86400;
					$urldate = date("Y-m-d", $data_time);
				}else{
					$urldate = date("Y-m-d", $qidate_info);
				}
			}else{
				$urldate = date("Y-m-d", $qidate);
			}
		}else{
			$cache[$this->typeid] = 0;
			$urldate = date("Y-m-d", $_SERVER['time']);
		}
		$url = "https://m.600w5.com/ssc/ajaxGetDataHistory.json?timestamp=".$_SERVER['time'].rand(100, 999);
		$post = array(
			'pageIndex' => 1,
			'pageSize' => '20',
			'openDate' => '',//开奖时间
			'number' => '',
			'playGroupId' => 6,
			'startTime' => '',
			'endTime' => '',
		);
		//print_r($post);
		$info = $this->za->post($url, $post);
		//print_r($info);exit;
		$data = json_decode($info, true);
		//print_r($data);exit;
		if(!empty($data['result'])){
			$new = '';
			$data_list = $post_data = array();
			$end_qihao = $cache[$this->typeid];
			asort($data['sscHistoryList']);
			foreach($data['sscHistoryList'] as $k => $v){
				if($v['number'] > $end_qihao){
					$end_qihao = $v['number'];
					$data_list[] = array(
						'typeid' => $this->typeid,
						'qi' => $v['number'],
						'code' => $v['openCode'],
						'add_time' => $_SERVER['time'],
						'post_stuat' => 0,
						'kj_time' => $v['openTime']/1000,
						'yid' => $yid,
					);
					$post_data[] = array(
						'qi' => $v['number'],
						'code' => $v['openCode'],
						'kj_time' => $v['openTime']/1000,
					);
					$new .= " ".$v['number'].":".$v['openCode']."\r\n";
				}
			}
			//print_r($data_list);exit;
			if(!empty($data_list)){
				//有数据需要递交的时候查询数据库是否有未递交成功的数据，让数据一次性递交
				$datas = $this->kj->index_fetch(array('post_stuat' => 0, 'typeid' => $this->typeid), array('id' => 1), 0, 100);
				if(!empty($datas)){
					foreach($datas as $k => $v){
						$post_data[] = array(
							'qi' => $v['qi'],
							'code' => $v['code'],
							'kj_time' => $v['kj_time'],
						);
					}
				}
				$post_stuat = $this->post_data($post_data, $this->typeid);
				if($post_stuat == 'OK'){
					$new .= " ".$this->game_name."发送数据成功\r\n";
					foreach($data_list as $k => $v){
						$data_list[$k]['post_stuat'] = 1;
					}
					if(!empty($datas)){
						foreach($datas as $k => $v){
							$v['post_stuat'] = 1;
							$this->kj->update($v['id'], $v);
						}
					}
				}else{
					$new .= " ".$this->game_name."发送数据失败\r\n";
				}
				$this->add_data($data_list);
			}else{
				$new = " ".$date.$this->game_name."无新增数据\r\n";
			}
			$new .= " ".$this->game_name."最后一期期号：".$end_qihao;
			//print_r($data_list);exit;
			$this->on_echo($new);
		}else{
			$this->on_echo(" ".$date."无法采集".$this->game_name."数据");
		}
	}
}
?>