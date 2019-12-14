<?php
class za extends base_model{
	
	public function parse_header1( $html = '', $strtolower = false ) {
		if ( !$html ) {
			return array();
		}
		$html = str_replace( "\r\n", "\n", $html );
		$html = explode( "\n\n", $html, 2 );
		$header = explode( "\n", $html[0] );
		$r = array();
		foreach ( $header as $k => $v ) {
			if ( $v ) {
				$v = explode( ':', $v, 2 );
				if( isset( $v[1] ) ) {
					if ( $strtolower ) {
						$v[0] = strtolower( $v[0] );
					}
					
					if ( substr( $v[1],0 , 1 ) == ' ' ) {
						$v[1] = substr( $v[1], 1 );
					}
					$r[trim($v[0])] = $v[1];
				} elseif ( empty( $r['status'] ) && preg_match( '/^(HTTP|GET|POST)/', $v[0] ) ) {
					$r['status'] = $v[0];
				} else {
					$r[] = $v[0];
				}
			}
		}
		if ( !empty( $html[1] ) ) {
			$r['html'] = $html[1] ;
		}
		return $r;
	}
	// 计算时间前后
	public function timeqian($times) {
		$timey = $_SERVER['time'] - $times;
		if ($timey >= 86400) {
			$timess = round($timey / 86400, 0);
			$timess = $timess . "天前";
		} else if ($timey >= 3600) {
			$timess = round($timey / 3600, 0);
			$timess = $timess . "小時前";
		} else if ($timey >= 60) {
			$timess = round($timey / 60, 0);
			$timess = $timess . "分鐘前";
		} else if ($timey >= 1) {
			$timess = $timey . "秒前";
		} 
		return $timess;
	}

	// 去除HTML代码
	public function quhtml($code) {
		$code = strip_tags($code);
		return $code;
	} 

	// 计算密码得分
	public function passwordcheck($password) {
		$score = 0;
        if(preg_match("/[0-9]+/",$password)){
           $score ++; 
        }
        if(preg_match("/[0-9]{3,}/",$password)){
           $score ++; 
        }
        if(preg_match("/[a-z]+/",$password)){
           $score ++; 
        }
        if(preg_match("/[a-z]{3,}/",$password)){
           $score ++; 
        }
        if(preg_match("/[A-Z]+/",$password)){
           $score ++; 
        }
        if(preg_match("/[A-Z]{3,}/",$password)){
           $score ++; 
        }
        if(preg_match("/[_|\-|+|=|*|!|@|#|$|%|^|&|(|)]+/",$password)){
           $score += 2; 
        }
        if(preg_match("/[_|\-|+|=|*|!|@|#|$|%|^|&|(|)]{3,}/",$password)){
           $score ++ ; 
        }
        if(strlen($password) >= 10){
           $score ++; 
        }
		$score = $score * 3;
		return $score;
	} 

	 
	// UTF8截取指定长度字符
	public function utfSubstr($str, $position, $length, $type = 1) {
		$startPos = strlen($str);
		$startByte = 0;
		$endPos = strlen($str);
		$count = 0;
		for($i = 0; $i < strlen($str); $i++) {
			if ($count >= $position && $startPos > $i) {
				$startPos = $i;
				$startByte = $count;
			} 
			if (($count - $startByte) >= $length) {
				$endPos = $i;
				break;
			} 
			$value = ord($str[$i]);
			if ($value > 127) {
				$count++;
				if ($value >= 192 && $value <= 223) $i++;
				elseif ($value >= 224 && $value <= 239) $i = $i + 2;
				elseif ($value >= 240 && $value <= 247) $i = $i + 3;
				else return self :: raiseError("\"$str\" Not a UTF-8 compatible string", 0, __CLASS__, __METHOD__, __FILE__, __LINE__);
			} 
			$count++;
		} 
		if ($type == 1 && ($endPos-6) > $length) {
			return substr($str, $startPos, $endPos - $startPos) . "...";
		} else {
			return substr($str, $startPos, $endPos - $startPos);
		} 
	} 

	/**
	+----------------------------------------------------------
	* 将一个字符串部分字符用*替代隐藏
	+----------------------------------------------------------
	* @param string    $string   待转换的字符串
	* @param int       $bengin   起始位置，从0开始计数，当$type=4时，表示左侧保留长度
	* @param int       $len      需要转换成*的字符个数，当$type=4时，表示右侧保留长度
	* @param int       $type     转换类型：0，从左向右隐藏；1，从右向左隐藏；2，从指定字符位置分割前由右向左隐藏；3，从指定字符位置分割后由左向右隐藏；4，保留首末指定字符串
	* @param string    $glue     分割符
	+----------------------------------------------------------
	* @return string   处理后的字符串
	+----------------------------------------------------------
	*/
	public function hideStr($string, $bengin=0, $len = 4, $type = 0, $glue = "@") {
		if (empty($string))
			return false;
		$array = array();
		if ($type == 0 || $type == 1 || $type == 4) {
			$strlen = $length = mb_strlen($string);
			while ($strlen) {
				$array[] = mb_substr($string, 0, 1, "utf8");
				$string = mb_substr($string, 1, $strlen, "utf8");
				$strlen = mb_strlen($string);
			}
		}
		if ($type == 0) {
			for ($i = $bengin; $i < ($bengin + $len); $i++) {
				if (isset($array[$i]))
					$array[$i] = "*";
			}
			$string = implode("", $array);
		}else if ($type == 1) {
			$array = array_reverse($array);
			for ($i = $bengin; $i < ($bengin + $len); $i++) {
				if (isset($array[$i]))
					$array[$i] = "*";
			}
			$string = implode("", array_reverse($array));
		}else if ($type == 2) {
			$array = explode($glue, $string);
			$array[0] = hideStr($array[0], $bengin, $len, 1);
			$string = implode($glue, $array);
		} else if ($type == 3) {
			$array = explode($glue, $string);
			$array[1] = hideStr($array[1], $bengin, $len, 0);
			$string = implode($glue, $array);
		} else if ($type == 4) {
			$left = $bengin;
			$right = $len;
			$tem = array();
			for ($i = 0; $i < ($length - $right); $i++) {
				if (isset($array[$i]))
					$tem[] = $i >= $left ? "*" : $array[$i];
			}
			$array = array_chunk(array_reverse($array), $right);
			$array = array_reverse($array[0]);
			for ($i = 0; $i < $right; $i++) {
				$tem[] = $array[$i];
			}
			$string = implode("", $tem);
		}
		return $string;
	}

	// 下载量显示限制
	public function downxz($num){
		require BBS_PATH."include/downnum.php";
		foreach($downnum as $k => $v) {
			if ($num >= $k) {
				if ($v == 'eqweqwe432fewfds') {
					$name = intval($num);
				} else {
					$name = $v;
				}
			} 
		}
		return $name;
	}

	// 进行词汇替换
	public function tihuan($neirong) {
		include BBS_PATH.'include/tihuan.php';
		foreach($tihuan as $k => $v) {
			$neirong = str_replace($k, $v, $neirong);
		} 
		return $neirong;
	} 

	// 价格格式化
	public function jiage($money) {
		require_once BBS_PATH."include/config.php";
		require BBS_PATH."include/lang.php";
		if ($money != '0' and $money != '' and $money != $lang['mianfei']) {
			$money = $money;
		} else {
			$money = $lang['mianfei'];
		} 
		return $money;
	}

	// 应用安全状态显示结果
	public function anquanstuats($level) {
		require BBS_PATH."include/lang.php";
		if($level==0){
			$anquanstuats='<font class="green">'.$lang['anquan'].'</font>';
		}else if($level==1){
			$anquanstuats='<font class="orange">'.$lang['zhuyi'].'</font>';
		}else if($level==2){
			$anquanstuats='<font class="red">'.$lang['weixian'].'</font>';
		}
		return $anquanstuats;
	}

	// 过滤HTML标签
	public function zhuojie_guolv($neirong) {
		require BBS_PATH."include/tgconfig.php";
		$guolv = str_replace("|", " ", $guolv);
		$neirong = strip_tags($neirong, $guolv);
		return $neirong;
	}

	// 计算下载次数
	public function downnum($num) {
		require BBS_PATH."conf/lang.php";
		if ($num == 0) {
			return('0');
		} else if ($num < 10000) {
			return($num);
		} else {
			return round($num / 10000, 1) . $lang['wan'];
		} 
	}

	// 获取图片高度与宽度
	public function picwh($picfile) {
		$picfile = str_replace($this->conf['app_url'] . "/", '', $picfile);
		if(file_exists($picfile)){
			$arr = getimagesize($picfile);
		}else{
			$arr = array(0=>480, 1=>800,);
		}
		$data['width'] = intval($arr[0]);
		$data['height'] = intval($arr[1]);
		return $data;
	} 

	// 生成二维码
	public function erweima($url, $widhtHeight = '150', $EC_level = 'L', $margin = '0') {
		$url = urlencode($url);
		$eym = 'http://chart.apis.google.com/chart?chs=' . $widhtHeight . 'x' . $widhtHeight . '&cht=qr&chld=' . $EC_level . '|' . $margin . '&chl=' . $url;
		return $eym;
	} 

	// 生成隨機码
	public function make_varchar($len = 16) {
		// 密码字符集，可任意添加你需要的字符
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$password = '';
		for ( $i = 0; $i < $len; $i++ ) 
		{
			// 这里提供两种字符获取方式
			// 第一种是使用 substr 截取$chars中的任意一位字符；
			// 第二种是取字符数组 $chars 的任意元素
			// $password .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
			$password .= $chars[ mt_rand(0, strlen($chars) - 1) ];
		}
		return $password;
	} 

	// 下载判断，如果来路非对应应用页，则跳入对应应用页
	public function appdowncheck($appid) {
		if(empty($_SERVER["HTTP_REFERER"]) or $_SERVER["HTTP_REFERER"] == ''){$_SERVER["HTTP_REFERER"]='';}
		if(substr($_SERVER["HTTP_REFERER"],0,strlen($this->conf['app_url'])+5) != $this->conf['app_url']."down/" and substr($_SERVER["HTTP_REFERER"],0,strlen($this->conf['app_url'])+6) != $this->conf['app_url']."mdown/"){
			header ("Location: ".$this->conf['app_url']."app/".$appid);
			exit;
		}else if(intval(substr($_SERVER["HTTP_REFERER"],strlen($this->conf['app_url'])+6,strlen($_SERVER["HTTP_REFERER"])-strlen($this->conf['app_url'])-6)) != $appid){
			header ("Location: ".$this->conf['app_url']."app/".$appid);
			exit;
		}
	}

	// 判断MEMCACHE下载记录是否需要入库
	public function memcachedownlogdb($info) {
		$time=$_SERVER['time']-7200;
		if($info['time'] > $time or empty($info['time'])){
			return false;
		}
		$mem = new cache_memcache($this->conf['cache']['memcache']);
		$downlogcaches=$mem->get('downlogs');
		foreach($downlogcaches['db'] as $k=>$v){
			$v['appname']=urlencode($v['appname']);
			$infos[]=$v;
		}
		$info['time']=$_SERVER['time'];
		$mem->set('downlogs', $info, 864000);
		$downlogcache=json_encode($infos);
		$setdb['info']=$downlogcache;
		$setdb['times']=$_SERVER['time'];
		$setdb['id']=1;
		$this->downlogcache->update(1, $setdb);
	}

	// 写MEMCACHE下载记录
	public function memcachedownlog($app) {
		$downlogcaches=array();
		$mem = new cache_memcache($this->conf['cache']['memcache']);
		$downlogcachess=$mem->get('downlog');
		$downlogcaches=$mem->get('downlogs');
		if($_SERVER['time'] - $downlogcachess['time'] > 60){
			$mem->set('downlog', $downlogcaches, 864000);
		}
		$downlogcache=$downlogcaches['db'];
		if(intval($downlogcaches['time']) < 1){
			$infodbs = $this->downlogcache->read(1);
			$downlogcaches['time'] = $infodbs['times'];
			$infodbs = json_decode($infodbs['info'] , TRUE);
			foreach($infodbs as $k=>$v){
				$v['appname']=urldecode($v['appname']);
				$downlogcache[$v['id']]=$v;
			}
		}
		unset($downlogcache[$app['id']]);
		$downlogcache[$app['id']]['id']=$app['id'];
		$downlogcache[$app['id']]['appname']=$app['appname'];
		$downlogcache[$app['id']]['enappname']=$app['enappname'];
		$downlogcache[$app['id']]['icon']=$app['icon'];
		$downlogcache[$app['id']]['time']=$_SERVER['time'];
		$downlogcaches['db']=$downlogcache;
		//$downlogcaches['time']=time();
		$mem->set('downlogs', $downlogcaches, 864000);
		$this->za->memcachedownlogdb($downlogcaches);
	}

	//排序多维数组，作为读MEMCACHE下载记录的时候用的
	public function _multi_array_sort($multi_array, $sort_key, $sort = SORT_DESC) {
		if (is_array($multi_array)) {
			foreach ($multi_array as $row_array) {
				if (is_array($row_array)) {
					$key_array[] = $row_array[$sort_key];
				} else {
					return FALSE;
				}
			}
		} else {
			return FALSE;
		}
		array_multisort($key_array, $sort, $multi_array);
		return $multi_array;
	}

	// 读MEMCACHE下载记录
	public function downlogmemcache($num, $start=0) {
		$pushdb = array();
		if($start >= 50){
			$start=$start%50;
		}
		$mem = new cache_memcache($this->conf['cache']['memcache']);
		$downlogcaches=$mem->get('downlog');
		$downlogcache=$downlogcaches['db'];
		if(intval($downlogcaches['time']) < 1){
			$infodbs = $this->downlogcache->get(1);
			$downlogcaches['time'] = $infodbs['times'];
			$infodbs = json_decode($infodbs['info'] , TRUE);
			foreach($infodbs as $k=>$v){
				$v['appname']=urldecode($v['appname']);
				$downlogcache[$v['id']]=$v;
			}
		}
		$i=0;
		//uasort($downlogcache, "cmp");
		$downlogcache = $this->za->_multi_array_sort($downlogcache , 'time');
		foreach($downlogcache as $k=>$v){
			$i=$i+1;
			if($i<=50){
			$memcachedownlog[$v['id']]=$v;
			}
		}
		$downlogcaches['db']=$memcachedownlog;
		$mem->set('downlog', $downlogcaches, 864000);
		$mem->set('downlogs', $downlogcaches, 864000);
		$end=$start+$num;
		$ss=0;
		foreach($memcachedownlog as $k=>$v){
			if($ss >= $start and $ss < $end){
			$pushdb[]=$v;
			}
			$ss=$ss+1;
		}
		$this->za->memcachedownlogdb($downlogcaches);
		return $pushdb;
	}

	//分析URL参数
	public function filterParam($url, $paramArg) { 
	    $parts = parse_url($url); 
		if(!isset($parts['query'])) {
			return false;
		} 
		parse_str($parts['query'], $output);     
		return array_intersect_key($output,$paramArg); 
	}

	// 获取客户端IP
	public function getip() {
		if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
			$ip = getenv("HTTP_CLIENT_IP");
		else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
			$ip = getenv("HTTP_X_FORWARDED_FOR");
		else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
			$ip = getenv("REMOTE_ADDR");
		else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
			$ip = $_SERVER['REMOTE_ADDR'];
		else
			$ip = "unknown";
		return($ip);
	} 

	// 过滤引号
	public function guolvyinhao($neirong) {
		$neirong = str_replace("'", "", $neirong);
		$neirong = str_replace('"', "", $neirong);
		return $neirong;
	} 

	// 计算文件大小
	public function filessize($size) {
		if ($size == 0) {
			return("0 KB");
		} 
		$sizename = array(" B", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
		return round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . $sizename[$i];
	} 
	// 反算计算文件大小
	public function fanfilessize($size) {
		$sizename = array("KB" => '1024', "MB" => "1048567", "GB" => "1073741824", "TB" => "1099511627776");
		$daxiao = explode(' ', $size);
		$wenjiandaxiao = $daxiao['0'] * $sizename[$daxiao['1']];
		return $wenjiandaxiao;
	} 

	// 欢迎语
	public function huanyanyu() {
		include BBS_PATH."conf/lang.php";
		$hour = date("H", $_SERVER['time']);
		if($hour > 6 && $hour < 9){
			$huanyanyu = $lang['zaoshanghao'];
		}else if($hour > 9 && $hour < 12){
			$huanyanyu = $lang['shangwuhao'];
		}else if($hour > 12 && $hour < 14){
			$huanyanyu = $lang['zhongwuhao'];
		}else if($hour > 14 && $hour < 17){
			$huanyanyu = $lang['xiawuhao'];
		}else if($hour > 17 && $hour < 19){
			$huanyanyu = $lang['bangwanhao'];
		}else if($hour > 19 && $hour <22){
			$huanyanyu = $lang['bangwanhao'];
		}else{
			$huanyanyu = $lang['wuyehao'];
		}
		return $huanyanyu;
	} 

	// 当前位置输出
	public function dangqianurl($typeid = 1) {
		include BBS_PATH."conf/lang.php";
		if ($typeid == 'webgame') {
			$info = $lang['dangqianweizhi'] . '： <A href="' . $this->conf['app_url'] . '">' . $this->conf['app_name'] . '</A> &gt; <A href="' . $this->conf['app_url'] . 'webgame/">' . $lang['wangyeyouxi'] . '</A>';
		} else if ($typeid == 'mobilegame') {
			$info = $lang['dangqianweizhi'] . '： <A href="' . $this->conf['app_url'] . '">' . $this->conf['app_name'] . '</A> &gt; <A href="' . $this->conf['app_url'] . 'mobilegame/">' .  $lang['shoujiyouxi'] . '</A>';
		} else if ($typeid == 'user') {
			$info = $lang['dangqianweizhi'] . '： <A href="' . $this->conf['app_url'] . '">' . $this->conf['app_name'] . '</A> &gt; <A href="' . $this->conf['app_url'] . 'user/">' . $lang['huiyuanzhongxin'] . '</A>';
		} else if ($typeid == 'search') {
			$info = $lang['dangqianweizhi'] . '： <A href="' . $this->conf['app_url'] . '">' . $this->conf['app_name'] . '</A>';
		} else if ($typeid == 'chuzhi') {
			$info = $lang['dangqianweizhi'] . '： <A href="' . $this->conf['app_url'] . '">' . $this->conf['app_name'] . '</A> &gt; <A href="' . $this->conf['app_url'] . 'gamepoint/">' . $lang['chuzhizhongxin'] . '</A>';
		} else {
		$types = $this->types->types_list();
		if($typeid <> 1 and $typeid <> 2){
			$info = $lang['dangqianweizhi'] . '： <A href="' . $this->conf['app_url'] . '">' . $this->conf['app_name'] . '</A> &gt; <A href="' . $this->conf['app_url'] . 'list/'.$types[$types[$typeid]['upid']]['id'] . '">'. $types[$types[$typeid]['upid']]['name'] . '</A> &gt; <A href="' . $this->conf['app_url'] . 'list/' . $types[$typeid]['id'] . '">'.$types[$typeid]['name'] . '</a>';
		}else{
			$info = $lang['dangqianweizhi'] . '： <A href="' . $this->conf['app_url'] . '">' . $this->conf['app_name'] . '</A> &gt; <A href="' . $this->conf['app_url'] . 'list/' . $types[$typeid]['id'] . '">'.$types[$typeid]['name'] . '</a>';
		}
		} 
	return $info;
	}

	//替换部分内容为星号
	public function half_replace($str){
		$len = strlen($str)/2;
		return substr_replace($str,str_repeat('*',$len),ceil(($len)/2),$len);
	}

	//計算UTF-8長度，字母、數字、中文都計算為1個字符
	public function utf8strlen($str){
		$len = mb_strlen($str,'UTF8');
		return $len;
	}

	//取指定位置內容
	public function cut_str($string, $sublen, $start = 0, $code = 'UTF-8'){ 
		if($code == 'UTF-8') { 
			$pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/"; 
			preg_match_all($pa, $string, $t_string); 
			if(count($t_string[0]) - $start > $sublen) return join('', array_slice($t_string[0], $start, $sublen)); 
			return join('', array_slice($t_string[0], $start, $sublen)); 
		}else { 
			$start = $start*2; 
			$sublen = $sublen*2; 
			$strlen = strlen($string); 
			$tmpstr = ''; 
			for($i=0; $i< $strlen; $i++) { 
				if($i>=$start && $i< ($start+$sublen)){ 
					if(ord(substr($string, $i, 1))>129){ 
						$tmpstr.= substr($string, $i, 2); 
					}else{ 
						$tmpstr.= substr($string, $i, 1); 
					} 
				} 
				if(ord(substr($string, $i, 1))>129) $i++; 
			}
			return $tmpstr; 
		} 
	} 
	
	//解析XML
    public function xml2array($xmlobject) {
        if ($xmlobject) {
            foreach ((array)$xmlobject as $k=>$v) {
                $data[$k] = !is_string($v) ? $this->za->xml2array($v) : $v;
            }
            return $data;
        }
    }
	
	//解析XML2
    public function xmltoarray($xmlobject) {
        if ($xmlobject) {
			$datas = simplexml_load_string($xmlobject);
            foreach ((array)$datas as $k=>$v) {
                $data[$k] = !is_string($v) ? $this->za->xmltoarray($v) : $v;
            }
            return $data;
        }
    }
	
	//解析地址的域名与域名后缀
    public function urltodomain($S) {
        $S = parse_url($S);
		$S = strtolower($S['host']) ; //取域名部分
		$domains = array('com','co','info','tw','org','net','me','mobi','us','biz','tv','ca','com.au','net.au','org.au','mx','ws','ag','com.ag','net.ag','org.ag','am','asia','at','be','com.br','net.br','bz','com.bz','net.bz','cc','com.co','net.co','nom.co','de','es','com.es','nom.es','org.es','eu','fm','fr','gs','in','co.in','firm.in','gen.in','ind.in','net.in','org.in','it','jobs','jp','ms','com.mx','nl','co.nz','net.nz','org.nz','se','tk','com.tw','idv.tw','org.tw','co.uk','me.uk','org.uk','xxx','cz','la','so','com.so','org.so','net.so','com.cn','net.cn','cn','net.tw','game.tw','org.cn','my','com.my'); //域名后缀 有新的就扩展这吧
		$SS = $S;
		$dd = implode('|',$domains);
		$SS = preg_replace('/(\.('.$dd.'))*\.('.$dd.')$/iU','',$SS); //把后面的域名后缀部分去掉
		$SSa = explode('.',$SS);
		$SSa = array_pop($SSa);//取最后的主域名
		$SSa = substr($S,strrpos($S,$SSa));  //加上后缀拼成完成的主域名
		$host = str_replace($SS.".", "",$S);
		$hostid = intval(array_search($host,$domains));
		if($domains[$hostid] == $host){//判断是否是真实存在这个后缀名
			$hostid = $hostid +1;
		}
		$domain = array(
			'url' => $S,//当前域名
			'domain' => $SSa,//主域名
			'domainid' => $hostid,//域名后缀ID
		);
		return $domain;
    }

	//生成指定长度特殊码
	public function make_code($length = 8) { 
		// 密码字符集，可任意添加你需要的字符 
		$chars = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 
		'i', 'j', 'k', 'l','m', 'n', 'o', 'p', 'q', 'r', 's', 
		't', 'u', 'v', 'w', 'x', 'y','z', 'A', 'B', 'C', 'D', 
		'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L','M', 'N', 'O', 
		'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y','Z', 
		'0', '1', '2', '3', '4', '5', '6', '7', '8', '9'); 

		// 在 $chars 中随机取 $length 个数组元素键名 
		$keys = array_rand($chars, $length); 
		$password = '';
		for($i = 0; $i < $length; $i++) { 
			// 将 $length 个数组元素连接成字符串 
			$password .= $chars[$keys[$i]]; 
		} 
		return $password; 
	} 

	//基于DISCUZ的手机判断
	public function checkmobile() {
		$mobile = array();
		$touchbrowser_list =array('iphone', 'android', 'phone', 'mobile', 'wap', 'netfront', 'java', 'opera mobi', 'opera mini',
					'ucweb', 'windows ce', 'symbian', 'series', 'webos', 'sony', 'blackberry', 'dopod', 'nokia', 'samsung',
					'palmsource', 'xda', 'pieplus', 'meizu', 'midp', 'cldc', 'motorola', 'foma', 'docomo', 'up.browser',
					'up.link', 'blazer', 'helio', 'hosin', 'huawei', 'novarra', 'coolpad', 'webos', 'techfaith', 'palmsource',
					'alcatel', 'amoi', 'ktouch', 'nexian', 'ericsson', 'philips', 'sagem', 'wellcom', 'bunjalloo', 'maui', 'smartphone',
					'iemobile', 'spice', 'bird', 'zte-', 'longcos', 'pantech', 'gionee', 'portalmmm', 'jig browser', 'hiptop',
					'benq', 'haier', '^lct', '320x320', '240x320', '176x220');
		$mobilebrowser_list =array('windows phone');
		$wmlbrowser_list = array('cect', 'compal', 'ctl', 'lg', 'nec', 'tcl', 'alcatel', 'ericsson', 'bird', 'daxian', 'dbtel', 'eastcom',
				'pantech', 'dopod', 'philips', 'haier', 'konka', 'kejian', 'lenovo', 'benq', 'mot', 'soutec', 'nokia', 'sagem', 'sgh',
				'sed', 'capitel', 'panasonic', 'sonyericsson', 'sharp', 'amoi', 'panda', 'zte');

		$pad_list = array('pad', 'gt-p1000');

		$useragent = strtolower($_SERVER['HTTP_USER_AGENT']);

		if($this->dstrpos($useragent, $pad_list)) {
			return false;//不是手机
		}
		if(($v = $this->dstrpos($useragent, $mobilebrowser_list, true))){
			//$_G['mobile'] = $v;
			return '1';//标准手机版
		}
		if(($v = $this->dstrpos($useragent, $touchbrowser_list, true))){
			//$_G['mobile'] = $v;
			return '1';//触屏版
		}
		if(($v = $this->dstrpos($useragent, $wmlbrowser_list))) {
			//$_G['mobile'] = $v;
			return '1'; //wml版
		}
		$brower = array('mozilla', 'chrome', 'safari', 'opera', 'm3gate', 'winwap', 'openwave', 'myop');
		if($this->dstrpos($useragent, $brower)) return false;
		/*
		$_G['mobile'] = 'unknown';
		if(isset($_G['mobiletpl'][$_GET['mobile']])) {
			return true;
		} else {
			return false;
		}
		*/
	}

	//判断是否存在数组中
	public function dstrpos($string, $arr, $returnvalue = false) {
		if(empty($string)) return false;
		foreach((array)$arr as $v) {
			if(strpos($string, $v) !== false) {
				$return = $returnvalue ? $v : true;
				return $return;
			}
		}
		return false;
	}

	/** 
		* curl 多线程 
		*  
		* @param array $array 并行网址 
		* @param int $timeout 超时时间
		* @return array 
	*/ 
	public function Curl_http($array,$timeout){
		$res = array();
		$mh = curl_multi_init();//创建多个curl语柄
		$startime = $this->getmicrotime();
		foreach($array as $k=>$url){
		$conn[$k]=curl_init($url);
			curl_setopt($conn[$k], CURLOPT_TIMEOUT, $timeout);//设置超时时间
			curl_setopt($conn[$k], CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
			curl_setopt($conn[$k], CURLOPT_MAXREDIRS, 7);//HTTp定向级别
			curl_setopt($conn[$k], CURLOPT_HEADER, 0);//这里不要header，加块效率
			curl_setopt($conn[$k], CURLOPT_FOLLOWLOCATION, 1); // 302 redirect
			curl_setopt($conn[$k],CURLOPT_RETURNTRANSFER,1);
			curl_multi_add_handle ($mh,$conn[$k]);
		}
		//防止死循环耗死cpu 这段是根据网上的写法
		do {
			$mrc = curl_multi_exec($mh,$active);//当无数据，active=true
		} while ($mrc == CURLM_CALL_MULTI_PERFORM);//当正在接受数据时
		while ($active and $mrc == CURLM_OK) {//当无数据时或请求暂停时，active=true
			if (curl_multi_select($mh) != -1) {
				do {
					$mrc = curl_multi_exec($mh, $active);
				} while ($mrc == CURLM_CALL_MULTI_PERFORM);
			}
		}
 	
		foreach ($array as $k => $url) {
			curl_error($conn[$k]);
			$res[$k]=curl_multi_getcontent($conn[$k]);//获得返回信息
			$header[$k]=curl_getinfo($conn[$k]);//返回头信息
			curl_close($conn[$k]);//关闭语柄
			curl_multi_remove_handle($mh  , $conn[$k]);   //释放资源  
		}
		
		curl_multi_close($mh);
		$endtime = $this->getmicrotime();
		$diff_time = $endtime - $startime;
		
		return array('diff_time'=>$diff_time,
						'return'=>$res,
						'header'=>$header		
		);
 	
	}

	//计算当前时间
	public function getmicrotime() {
		list($usec, $sec) = explode(" ",microtime());
		return ((float)$usec + (float)$sec);
	}

	/**
		* PHP Crul库 模拟Post提交至支付宝网关
		* 如果使用Crul 你需要改一改你的php.ini文件的设置，找到php_curl.dll去掉前面的";"就行了
		* 返回 $data
	*/
	public function post($url, $postdata, $num = 1) {
		if($num > 3){
			return FALSE;
		}
		if(empty($_SERVER['HTTP_USER_AGENT'])){
			$_SERVER['HTTP_USER_AGENT'] = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36';
		}
		$curl = curl_init(); // 启动一个CURL会话
		curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); // 从证书中检查SSL加密算法是否存在
		curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
		curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
		curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
		curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata); // Post提交的数据包
		curl_setopt($curl, CURLOPT_TIMEOUT, 15); // 设置超时限制防止死循环
		curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
		$tmpInfo = curl_exec($curl); // 执行操作
		if(curl_errno($curl)){
			$num += 1;
			$this->za->post($url, $postdata, $num);//捕抓异常
			exit;
		}
		curl_close($curl); // 关闭CURL会话
		return $tmpInfo; // 返回数据
	}
        
        //获取URL中的参数
	public function url_uri(){
		$uri = array();
		$urlc = parse_url($_SERVER['REQUEST_URI']);
		if(!empty($urlc['query'])){
			$urlquery = $this->za->urlquery($urlc['query']);
			foreach($urlquery as $k => $v){
				$uri[$k] = $v;
			}
		}
		return $uri;
	}
        
        //解析URL中的参数
	public function urlquery($url){
		$queryParts = explode('&', $url); 
		$params = array(); 
		foreach ($queryParts as $param) { 
			$item = explode('=', $param); 
			if(empty($item[1])){
		$item[1] = '';
			}
			$params[$item[0]] = $item[1]; 
		} 
		return $params;
	}
        
        public function mysql( $sql ){
		$info = array();
		$memails = $this->db->query( $sql );
		$info = mysql_fetch_assoc($memails);
		return $info;
	}
        
        public function mysql_list( $sql ){
		$info = array();
		$memails = $this->db->query( $sql );
		while($data = mysql_fetch_assoc($memails)) {
			$info[] = $data;
		}
		return $info;
	}
        
        public function get_avatar($uid,$size='middle',$type=''){
                $size = in_array($size, array('big', 'middle', 'small')) ? $size : 'middle';
                $uid = abs(intval($uid));
                $uid = sprintf("%09d", $uid);
                $dir1 = substr($uid, 0, 3);
                $dir2 = substr($uid, 3, 2);
                $dir3 = substr($uid, 5, 2);
                $typeadd = $type == 'real' ? '_real' : '';
                $img = $this->conf['uc_url'].'data/avatar/'.$dir1.'/'.$dir2.'/'.$dir3.'/'.substr($uid, -2).$typeadd."_avatar_$size.jpg";
                if($this->check_remote_file_exists($img) ) {
                    return $img;
                }else{
                    return $this->conf['uc_url'].'images/noavatar_middle.gif';
                }
        }
        
        function check_remote_file_exists($url) {
            $curl = curl_init($url);
            //不取回数据
            curl_setopt($curl, CURLOPT_NOBODY, true);
            //发送请求
            $result = curl_exec($curl);
            $found = false;
            if ($result !== false) {
                //检查http响应码是否为200
                $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);  
                if ($statusCode == 200) {
                    $found = true;   
                }
            }
            curl_close($curl);
            return $found;
        }
        
        /**
         * 密码强度
         * @param type $uid 用戶id 
         * @param type $pw1 登錄密碼
         * @param type $paypw1 支付密碼
         * @param type $score3 密保問題 1：有設置 -1：沒有設置
         * @param type $score4 身份證驗證 1: 有填寫，已審核 2：有填寫，未審核 3：無填寫
         * @param type $scroe5 郵箱驗證 1:已驗證 -1：未驗證
         * @return boolean
         */
        public function checkstrength($uid, $pw1='',$paypw1='',$score3='',$score4='',$score5='') {
            $user = $this->user->read($uid);
            $arr_tmp = explode('|', $user['password_strength']);
            if( count($arr_tmp) >= 5 ) {
                if( $pw1 ) {
                    $score1 = $this->za->passwordcheck($pw1);
                    $score1 = $score1/10;
                    $arr_tmp[0] = $score1;
                }
                if( $paypw1 ) {
                    $score2 = $this->za->passwordcheck($paypw1);
                    $score2 = $score2/10;
                    $arr_tmp[1] = $score2;
                }
                if( $score3 ){
                    $arr_tmp[2] = $score3==1?1:0;
                }
                if( $score4 ){
                    switch($score4){
                        case 1:
                            $arr_tmp[3] = 3;
                            break;
                        case 2:
                            $arr_tmp[3] = 1;
                            break;
                        case 3:
                            $arr_tmp[3] = 0;
                            break;
                    }
                }
                if( $score5 ){
                    $arr_tmp[4] = $score5==1?3:0;
                }
                $user['password_strength'] = implode('|', $arr_tmp);
                $this->user->update($user['uid'], $user);
                return true;
            }
            return false;
        }

	//直接执行SQL语句
	public function mysqlquery( $sql ){
		$info = array();
		$memails = $this->db->query( $sql );
		return $info;
	}

	//解析escape
	public function js_unescape($str){        
		$ret = '';        
		$len = strlen($str);        
		for ($i = 0; $i < $len; $i++){                
			if ($str[$i] == '%' && $str[$i+1] == 'u'){                        
			$val = hexdec(substr($str, $i+2, 4));                        
			if ($val < 0x7f) $ret .= chr($val);                        
			else if($val < 0x800) $ret .= chr(0xc0|($val>>6)).chr(0x80|($val&0x3f));                        else $ret .= chr(0xe0|($val>>12)).chr(0x80|(($val>>6)&0x3f)).chr(0x80|($val&0x3f));                       
			$i += 5;                
			}                
			else if ($str[$i] == '%')                
			{                        
			$ret .= urldecode(substr($str, $i, 3));                        
			$i += 2;                
			}                
			else $ret .= $str[$i];        
		}        
		return $ret;
	}

	//格式化字节
	public function convert($size){ 
		$unit=array('b','kb','mb','gb','tb','pb'); 
		return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i]; 
	} 

	//获得服务器内存
	public function get_neicun(){
		if (!function_exists('memory_get_usage')) { 
			$pid = getmypid();
			if (IS_WIN) {
				exec('tasklist /FI "PID eq ' . $pid . '" /FO LIST', $output);
				return $this->convert(preg_replace('/[^0-9]/', '', $output[5]) * 1024);
			}else{
				exec("ps -eo%mem,rss,pid | grep $pid", $output);
				$output = explode(" ", $output[0]);
				return $this->convert($output[1] * 1024);
			}
		}else{
			return $this->convert(memory_get_usage());
		}
	}

	//增加攻击禁止访问IP
	public function add_noip($ip, $time = 0){
		$put = 0;
		$ipfile = BBS_PATH.'conf/attackip.php';
		$iplist = include $ipfile;
		//循环，判断是否有过去的IP删除
		foreach($iplist as $k => $v){
			if($v >= 1 and $v <= $_SERVER['time']){
				$put = 1;
				unset($iplist[$k]);
			}
		}
		if(!empty($iplist[$ip])){
			return 1;
		}else{
			$put = 1;
			$iplist[$ip] = $time;
			$iplist = var_export($iplist, true);
			$s = "<?php\r\nreturn $iplist; \r\n?>";
			file_put_contents($ipfile, $s);
		}
		return 1;
	}

	//删除攻击禁止访问IP
	public function del_noip($ip){
		$put = 0;
		$ipfile = BBS_PATH.'conf/attackip.php';
		$iplist = include $ipfile;
		if(!empty($iplist[$ip])){
			$put = 1;
			unset($iplist[$ip]);
		}
		//循环，判断是否有过去的IP删除
		foreach($iplist as $k => $v){
			if($v >= 1 and $v <= $_SERVER['time']){
				$put = 1;
				unset($iplist[$k]);
			}
		}
		if($put == 1){
			$iplist = var_export($iplist, true);
			$s = "<?php\r\nreturn $iplist; \r\n?>";
			file_put_contents($ipfile, $s);
		}
		return 1;
	}

	//解压GZIP
	public function gzip_decode($info){
		if(!function_exists('gzdecode')){
			$info = gzinflate(substr($info,10,-8));
		}else{
			$info = gzdecode($info);
		}
		return $info;
	}


	//不加密中文的JSON方法
	public function my_json_encode($arr){
		$str = str_replace ( "\\/", "/", json_encode ( $arr ) );
		$search = "#\\\u([0-9a-f]+)#ie";
		if(strpos ( strtoupper(PHP_OS), 'WIN' ) === false) {
			$replace = "iconv('UCS-2BE', 'UTF-8', pack('H4', '\\1'))";//LINUX
		}else{
			$replace = "iconv('UCS-2', 'UTF-8', pack('H4', '\\1'))";//WINDOWS
		}
		return preg_replace( $search, $replace, $str );
	}

	//读取memcache信息
	public function get_memcache($name){
		$mem = new cache_memcache($this->conf['cache']['memcache']);
		$caches = $mem->get($name);
		if(empty($caches)){
			$caches = array();
		}
		return $caches;
	}

	//写入更新memcache信息
	public function add_memcache($name, $data){
		$mem = new cache_memcache($this->conf['cache']['memcache']);
		$mem->set($name, $data, 864000);
		return 1;
	}

	//删除memcache信息
	public function del_memcache($name){
		$mem = new cache_memcache($this->conf['cache']['memcache']);
		$mem->delete($name);
		return 1;
	}

	//解压zip压缩包实现更新，为了防止意外操作，只解压到根目录
	public function unzip($file){
		$zip = new ZipArchive();
		$flag = $zip->open($file);
		if($flag!==true){
		   echo "open error code: {$flag}\n";
		   exit();
		}
		$zip->extractTo('./');
		$flag = $zip->close();
		return $flag?1:2;
	}

	//处理DIY输入框信息
	public function format_post_input(){
		$infos = array();
		if(!empty($_POST['field_enname'])){
			foreach($_POST['field_enname'] as $k => $v){
				if($_POST['field_type'][$k] == 6){
					$_POST['field_info'][$k] = $_POST['field_info'.$_POST['field_enname'][$k]];
				}
				$infos[$_POST['field_enname'][$k]] = array(
					'field_name' => $_POST['field_name'][$k],
					'field_enname' => $_POST['field_enname'][$k],
					'field_beizhu' => $_POST['field_beizhu'][$k],
					'field_type' => $_POST['field_type'][$k],
					'field_info' => $_POST['field_info'][$k],
				);
			}
		}
		return $infos;
	}
	
	/** 
	 * 抓取网页内容
	 * url: 要抓取的网页地址
	 * data: POST方式的递交数据，若为GET方式，则递交空数组
	 * type: COOKIE的操作类型，1为使用保存的COOKIE文件，2为保存网页获取到的COOKIE，3为不保存也不使用COOKIE文件
	 * timeout: 请求超时时间
	 * cookie: 使用字符串类型的COOKIE数据
	 * header: 报头信息
	 * lailu: 来路地址
	 * gzip: GZIP解压，若网页有GZIP压缩，则递交1表示内容GZIP解压
	 */  
	public function curlPost($url, $data = array(), $type = 3, $timeout = 600, $cookie = '', $header = array(), $lailu = '', $gzip = 0){
		$cookie_file = 'cookie.txt';
		$cacert = getcwd() . '/cacert.pem'; //CA根证书  
		$SSL = substr($url, 0, 8) == "https://" ? true : false;  
		//开启curl
		$ch = curl_init();
		//设置url
		curl_setopt($ch, CURLOPT_URL, $url);
		//设置cURL允许执行的最长秒数
		curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
		//在发起连接前等待的时间
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout-2);
		//是否验证证书
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
        //设置为 1 是检查服务器SSL证书中是否存在一个公用名(common name)。译者注：公用名(Common Name)一般来讲就是填写你将要申请SSL证书的域名 (domain)或子域名(sub domain)。 设置成 2，会检查公用名是否存在，并且是否与提供的主机名匹配。 0 为不检查名称。 在生产环境中，这个值应该是 2（默认值）。
		curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
		//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // 信任任何证书  
		//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); // 检查证书中是否设置域名  
		if($gzip == 1){
		    //HTTP请求头中"Accept-Encoding: "的值。支持的编码有"identity"，"deflate"和"gzip"。如果为空字符串""，请求头会发送所有支持的编码类型。    在cURL 7.10中被加入。
			curl_setopt($ch, CURLOPT_ENCODING, "gzip");
		}
		//希望返回的数据不直接输出 作为变量储存
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		//curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //启用时会将服务器服务器返回的"Location: "放在header中递归的返回给服务器，使用CURLOPT_MAXREDIRS可以限定递归返回的数量。
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		//在HTTP请求中包含一个"User-Agent: "头的字符串  模拟浏览器
		curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.76 Mobile Safari/537.36");
		if($type == 2){
		    //连接结束后保存cookie信息的文件
			curl_setopt($ch, CURLOPT_COOKIEJAR,  $cookie_file); //存储cookies
		}else if($type == 1){
		    //包含cookie数据的文件名，cookie文件的格式可以是Netscape格式，或者只是纯HTTP头部信息存入文件。
			curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file); //使用上面获取的cookies
		}
		if(!empty($cookie)){
			//echo $cookie;
            //设定HTTP请求中"Cookie: "部分的内容。多个cookie用分号分隔，分号后带一个空格(例如， "fruit=apple; colour=red")。
			curl_setopt( $ch, CURLOPT_COOKIE, $cookie);
		}
		if(!empty($header)){
		    //一个用来设置HTTP头字段的数组。使用如下的形式的数组进行设置： array('Content-type: text/plain', 'Content-length: 100')
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		}else{
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:')); //避免data数据过长问题
		} 
		if(!empty($lailu)){
		    //在HTTP请求头中"Referer: "的内容
			curl_setopt($ch, CURLOPT_REFERER, $lailu); 
		}else{
			//curl_setopt($ch, CURLOPT_REFERER, "http://pub.alimama.com/promo/item/channel/index.htm?q=u%E7%9B%98%2032g&channel=qqhd&_t=1506361083289");
		}
		if(!empty($data)){
		    //启用时会发送一个常规的POST请求，类型为：application/x-www-form-urlencoded，就像表单提交的一样
			curl_setopt($ch, CURLOPT_POST, 1);
			if(is_array($data)){
				$post_data = array();
				foreach($data as $k => $v){
					$post_data[] = $k.'='.$v;
				}
				//curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
				//部数据使用HTTP协议中的"POST"操作来发送。要发送文件，在文件名前面加上@前缀并使用完整路径。这个参数可以通过urlencoded后的字符串类似'para1=val1&para2=val2&...'或使用一个以字段名为键值，字段数据为值的数组。如果value是一个数组，Content-Type头将会被设置成multipart/form-data
                curl_setopt($ch, CURLOPT_POSTFIELDS, implode("&", $post_data));
			}else{
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			}
		}
		//curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data)); //data with URLEncode  
		$ret = curl_exec($ch);

//        print_r(curl_getinfo($ch));
		//$Headers =  curl_getinfo($ch);
		//print_r($Headers);
        echo $url." \r\n";
        if(empty($ret) ){
            $Headers =  curl_getinfo($ch);
            print_r(curl_error($ch));
            echo "\r\n";
            print_r($Headers);
        }
	//	var_dump(curl_error($ch));  //查看报错信息
		curl_close($ch);  
		return $ret;    
	}

}
?>