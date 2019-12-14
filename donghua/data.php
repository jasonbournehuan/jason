<?php
include 'function.php';
$game_id = intval($_GET['game_id']);
if(empty($game_id)){
	$error = array(
		'status' => 2,
		'msg' => '请勿尝试非法操作',
	);
}else{
	$data = get_data($game_id);
	if(empty($data)){
		$error = array(
			'status' => 3,
			'msg' => '请勿尝试非法操作',
		);
	}else{
		$game_tmp_id = gid_to_tid($game_id);
		if($game_tmp_id >= 1){
			$error = format_data($game_tmp_id, $data, $game_id);
		}else{
			$error = array(
				'status' => 3,
				'msg' => '请勿尝试非法操作',
			);
		}
	}
}
echo json_encode($error);
exit;