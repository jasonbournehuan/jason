<?php
//ID加密算法
class id_to_code{
	public function tidencode_list(){
		$myArray = Array(
            'g' => '0',
            'u' => '1',
            'k' => '2',
            'd' => '3',
            '5' => '4',
            'j' => '5',
            'v' => '6',
            'l' => '7',
            'a' => '8',
            'i' => '9',
            'p' => '10',
            'b' => '11',
            'm' => '12',
            'n' => '13',
            '0' => '14',
            'e' => '15',
            't' => '16',
            'f' => '17',
            '7' => '18',
            'r' => '19',
            '9' => '20',
            '4' => '21',
            'c' => '22',
            '6' => '23',
            'y' => '24',
            'z' => '25',
            '3' => '26',
            'x' => '27',
            '2' => '28',
            'q' => '29',
            '1' => '30',
            'w' => '00',
            'o' => '000',
            's' => '0000',
            'h' => '-',
            '8' => '', 
        );
		return $myArray;
	}

	//解密参数，传入加密字符串，校验整体信息
	public function tid_decode($tid, $end_old = 1){
		$tid = trim($tid);
		if(strlen($tid) < 1){
			return 0;
		}
		$code_list = $this->tidencode_list(); 
		$code_str = $de_str = $md5_str = '';
		$stuat = $fenge = 0;
		for($i = 0; $i < strlen($tid); $i++){
			$code_str = $code_list[$tid{$i}];
			if($stuat == 0){
				$de_str .= $code_str;
			}else{
				$de_str .= $tid{$i};
			}
			if($code_str == '-'){
				$fenge += 1;
				if($end_old == $fenge){
					$stuat = 1;
				}
			}
		}
		return $de_str;
	}
	//加密参数，传入ID，可选是否后面补充下划线
	public function tid_encode($gid, $bu = 1){
		$gid = (string)$gid;
		$code_list = $this->fan_code();
		$gi = $bu_len = 0;
		$ui = 0;
		$en_code_str = '';
		$en_gid = '';
		$en_uid = '';
		$gid_len = strlen($gid);
		for($i = 0; $i < $gid_len; $i++){
			if($gi < $gid_len){
				if($gi + 1 < $gid_len){
					$en_gid = $gid{$gi}.$gid{$gi+1};
					//$en_gid = intval($gid{$gi}.$gid{$gi+1});

					if($gid{$gi} == '0'){
						$en_gid = $this->get_code(substr($gid, $gi));
						$en_code_str .= $code_list[$en_gid];
						$gi = $gi + strlen($en_gid);
					}else if($gid{$gi} >= 1 and $en_gid <= 30){
						$en_code_str .= $code_list[$en_gid];
						$gi = $gi + 2;
					}else{
						$en_code_str .= $code_list[$gid{$gi}];
						$gi = $gi + 1;
					}
				}else{
					$en_code_str .= $code_list[$gid{$gi}];
					$gi = $gi + 1;
				}
			}
		}
		if($bu == 1){
			$en_code_str .= 'h';
		}
		return $en_code_str;
	}

	//计算可使用的最长ID组合
	public function get_code($code, $num = 0, $data = ''){
	    if($num > strlen($code)-1)
        {
            return $data;
        }
		if($code{$num} == '0' and strlen($data) < 4 ){
			$data .= $code{$num};
			$num += 1;
			return $this->get_code($code, $num, $data);
		}

		return $data;
	}

	public function fan_code(){
		$code_list = $this->tidencode_list();
		$fan_codes = Array();
		foreach($code_list as $k => $v){
			$fan_codes[$v] = $k;
		}
		return $fan_codes;
	}

	//账号加密，方便统一使用，为统一长度问题，使用UID作为用户名
	public function en_username($site_id, $uid, $min_len = 5, $max_len = 16){
	    if(preg_match("/\p{Han}+/u", $uid)){
	        echo   json_encode('uid不能含有汉字');exit;
        }
		$bu = '';
		$en_site_id = $this->tid_encode($site_id);
		$en_username = $en_site_id.$this->tid_encode($uid, 0);
		if(strlen($en_username) < $min_len){
			//小于最小长度的用户名进行前补操作，虽然不易出现，但是处理一下防止出错
			$lens = $min_len - strlen($en_username);
			for($i = 0; $i < $lens; $i++){
				$bu .= '8';
			}
			$en_username = $bu.$en_username;
		}
		return $en_username;
	}

	//账号解密，方便统一使用
	public function de_username($en_username){
		$de_username = $this->tid_decode($en_username, 0);
		$de_username = explode("-",$de_username);
		return $de_username;
	}

	//通用加密，循环数组加密每个数据使用-分割
	public function encode($array){
		$encode = '';
		if(!empty($array)){
			$end = count($array) - 1;
			$start = 0;
			foreach($array as $k => $v){
				if($start == $end){
					$buwei = 0;
				}else{
					$buwei = 1;
				}
				$encode .= $this->tid_encode($v, $buwei);
				$start += 1;
			}
		}
		return $encode;
	}

	//通用解密，输出数组
	public function decode($code){
		$code = $this->tid_decode($code, 100);
		$code_list = explode("-", $code);
		return $code_list;
	}
}
?>