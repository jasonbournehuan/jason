<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
/**
 * 删除目录以及其下的文件
 * @param $directory
 * @return bool
 */
function removeDir($directory)
{
    if (false == is_dir($directory)) {
        return false;
    }

    $handle = opendir($directory);
    while (false !== ($file = readdir($handle))) {
        if ('.' != $file && '..' != $file) {
            is_dir("$directory/$file") ? removeDir("$directory/$file") : @unlink("$directory/$file");
        }
    }

    if (readdir($handle) == false) {
        closedir($handle);
        rmdir($directory);
    }

    return true;
}


function randCode($length = 18, $type = 0) {
    $arr = array(1 => "0123456789", 2 => "abcdefghijklmnopqrstuvwxyz", 3 => "ABCDEFGHIJKLMNOPQRSTUVWXYZ");
    if ($type == 0) {
        array_pop($arr);
        $string = implode("", $arr);
    } elseif ($type == "-1") {
        $string = implode("", $arr);
    } else {
        $string = $arr[$type];
    }
    $count = strlen($string) - 1;
    $code = '';
    for ($i = 0; $i < $length; $i++) {
        $code .= $string[rand(0, $count)];
    }
    return $code;
}
	
//生成临时用户ID
function temp_uid(){
	$start_int = 1554210000;
	$user_time = time() - $start_int;
	$uid = tid_encode($user_time, 8, 0);
	return $uid;
}

function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=false){
    if(function_exists("mb_substr")){
        if($suffix)
            return mb_substr($str, $start, $length, $charset)."...";
        else
            return mb_substr($str, $start, $length, $charset);
    }
    elseif(function_exists('iconv_substr')) {
        if($suffix)
            return iconv_substr($str,$start,$length,$charset)."...";
        else
            return iconv_substr($str,$start,$length,$charset);
    }
    $re['utf-8']   = "/[x01-x7f]|[xc2-xdf][x80-xbf]|[xe0-xef]
                  [x80-xbf]{2}|[xf0-xff][x80-xbf]{3}/";
    $re['gb2312'] = "/[x01-x7f]|[xb0-xf7][xa0-xfe]/";
    $re['gbk']    = "/[x01-x7f]|[x81-xfe][x40-xfe]/";
    $re['big5']   = "/[x01-x7f]|[x81-xfe]([x40-x7e]|xa1-xfe])/";
    preg_match_all($re[$charset], $str, $match);
    $slice = join("",array_slice($match[0], $start, $length));
    if($suffix) return $slice."…";
    return $slice;
}
	
function tidencode_list(){
	$myArray = Array();
	$myArray['Z'] = '0';
	$myArray['z'] = '1';
	$myArray['P'] = '2';
	$myArray['9'] = '3';
	$myArray['5'] = '4';
	$myArray['y'] = '5';
	$myArray['b'] = '6';
	$myArray['4'] = '7';
	$myArray['F'] = '8';
	$myArray['T'] = '9';
	$myArray['6'] = '10';
	$myArray['i'] = '11';
	$myArray['X'] = '12';
	$myArray['t'] = '13';
	$myArray['n'] = '14';
	$myArray['q'] = '15';
	$myArray['d'] = '16';
	$myArray['h'] = '17';
	$myArray['v'] = '18';
	$myArray['k'] = '19';
	$myArray['e'] = '20';
	$myArray['p'] = '21';
	$myArray['j'] = '22';
	$myArray['W'] = '23';
	$myArray['V'] = '24';
	$myArray['g'] = '25';
	$myArray['U'] = '26';
	$myArray['S'] = '27';
	$myArray['B'] = '28';
	$myArray['A'] = '29';
	$myArray['C'] = '30';
	$myArray['Y'] = '31';
	$myArray['o'] = '32';
	$myArray['L'] = '33';
	$myArray['E'] = '34';
	$myArray['O'] = '35';
	$myArray['J'] = '36';
	$myArray['2'] = '37';
	$myArray['8'] = '38';
	$myArray['K'] = '39';
	$myArray['r'] = '40';
	$myArray['Q'] = '41';
	$myArray['w'] = '42';
	$myArray['N'] = '43';
	$myArray['1'] = '44';
	$myArray['I'] = '45';
	$myArray['7'] = '46';
	$myArray['3'] = '47';
	$myArray['s'] = '48';
	$myArray['D'] = '49';
	$myArray['H'] = '50';
	$myArray['0'] = '-';
	$myArray['u'] = '-';
	$myArray['a'] = '-';
	$myArray['f'] = '-';
	$myArray['l'] = '-';
	$myArray['x'] = '-';
	$myArray['c'] = '-';
	$myArray['m'] = '-';
	$myArray['R'] = '-';
	$myArray['G'] = '-';
	$myArray['M'] = '-';
	return $myArray;
}

//解密参数，传入加密字符串，校验整体信息
function tid_decode($tid){
	$tid = trim($tid);
	if(strlen($tid) < 1){
		return 0;
	}
	$code_list = tidencode_list();
	$code_str = $de_str = $md5_str = '';
	$stuat = 0;
	for($i = 0; $i < strlen($tid); $i++){
		$code_str = $code_list[$tid{$i}];
		if($code_str == '-'){
			$stuat = 1;
		}
		if($stuat == 0){
			$de_str .= $code_str;
		}else{
			$md5_str .= $tid{$i};
		}
	}
	$gid = intval($de_str);
	if(msubstr(md5($gid), 0, strlen($md5_str) - 1) == msubstr($md5_str, 1, strlen($md5_str) - 1)){
		return $gid;
	}else{
		return 0;
	}
}
//加密参数，传入网站ID，不足长度自动补足
function tid_encode($gid, $len = 8, $bu = 1){
	$code_list = fan_code();
	$gi = $bu_len = 0;
	$ui = 0;
	$en_code_str = '';
	$en_gid = '';
	$en_uid = '';
	$gid_len = strlen($gid);
	for($i = 0; $i < $gid_len; $i++){
		if($gi < $gid_len){
			if($gi + 1 < $gid_len){
				$en_gid = intval(msubstr($gid, $gi, 2));
				//$en_gid = intval($gid{$gi}.$gid{$gi+1});
				if($en_gid <= 50){
					$en_code_str .= $code_list[$en_gid];
					$gi = $gi + 2;
				}else{
					$en_code_str .= $code_list[intval(msubstr($gid, $gi, 1))];
					$gi = $gi + 1;
				}
			}else{
				$en_code_str .= $code_list[intval(msubstr($gid, $gi, 1))];
				$gi = $gi + 1;
			}
		}
	}
	if($bu == 1 and $len > $gid_len){
		$arr = array('u','a','f','l','x','c','m','R','G','M');
		$en_code_str .= $arr[intval(msubstr($gid, 0, 1))];
		$bu_len = $len - $gid_len - 1;
		if($bu_len > 0){
			$md5_key = md5($gid);
			$bu_str = msubstr($md5_key, 0, $bu_len);
			$en_code_str .= $bu_str;
		}
	}
	return $en_code_str;
}

function fan_code(){
	$code_list = tidencode_list();
	$fan_codes = Array();
	foreach($code_list as $k => $v){
		$fan_codes[$v] = $k;
	}
	return $fan_codes;
}