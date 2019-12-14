<?php
!defined('FRAMEWORK_PATH') && exit('FRAMEWORK_PATH not defined.');
include BBS_PATH.'control/common_control.class.php';
//从文件获取游戏数据并入库到数据库中
class indatafromfile_control extends common_control {
	
	function __construct() {
		parent::__construct();
	}
	
	//FG游戏数据文档处理
	function on_game_data(){
		$start_id = 1;//开始ID，避免之前入库过的数据重复入库
		$platform_id = 1;//平台ID
		$game_info_list = array();
		$file = BBS_PATH.'gamedata/1.csv';
		$this->c('games');
		$game_list = file($file);
		foreach($game_list as $k => $v){
			$game_info = explode(",", $v);
			if($game_info[0] >= $start_id){
				switch($game_info[3]){
					case 'Slot':
						$type_id = 1;
						break;
					case 'Hunter':
						$type_id = 3;
						break;
					case 'Chess':
						$type_id = 2;
						break;
					case 'Arcade':
						$type_id = 4;
						break;
					default:
						$type_id = 0;
				}
				if(trim($game_info[1]) == '热门'){
					$hot = 1;
				}else{
					$hot = 0;
				}
				$game_info_list[] = array(
					'platform_id' => $platform_id,
					'game_code' => $game_info[9],
					'game_name_cn' => $game_info[7],
					'game_name_en' => $game_info[14],
					'game_name_tw' => $game_info[8],
					'pic' => '',
					'module_id' => $game_info[10],
					'type_id' => $type_id,
					'line_type' => trim(str_replace(array(' Reel Slot', '-'), '', $game_info[5])),
					'line' => trim(str_replace(array(' paylines', '-'), '', $game_info[6])),
					'min_money' => $game_info[11],
					'max_money' => $game_info[12],
					'rtp' => trim(str_replace("%", "", $game_info[13])),
					'status' => 1,
					'hot' => $hot,
					'add_time' => intval(str_replace("Q", "", $game_info[2])),
					'query_info' => '',
				);
			}
		}
		if(!empty($game_info_list)){
			$add = $this->games->add_list($game_info_list);
		}
		print_r($game_info_list);exit;
	}
}
?>