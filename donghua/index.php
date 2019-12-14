<?php
include 'function.php';
$game_id = intval($_GET['game_id']);
if(empty($game_id)){
	header("HTTP/1.1 404 Not Found");  
	header("Status: 404 Not Found");  
	exit;
}else{
	$game_tmp_id = gid_to_tid($game_id);
	if(empty($game_tmp_id)){
		header("HTTP/1.1 404 Not Found");  
		header("Status: 404 Not Found");  
		exit;
	}else{
		include $game_tmp_id.'.html';
	}
}