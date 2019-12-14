<?php
class za extends base_model{
    // 获得访客IP
    public function get_ip($type = 1){
        if (!empty($_SERVER['HTTP_CLIENT_IP'])){
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        if($type == 2){
            //给予整型IP
            $ip = $this->iptoint($ip);
        }
        return $ip;
    }

    //IP转整型
    public function iptoint($ip){
        return bindec(decbin(ip2long($ip)));
    }

    //整型转IP
    public function inttoip($int){
        return long2ip($int);
    }

    //保留指定小数位数并去除金额小数点后无效0
    public function format_money($money, $num = 3){
        return rtrim(rtrim(sprintf("%.".$num."f", $money), '0'), '.');
    }

    public function parse_header1( $html = '', $strtolower = false ) {
        echo "22255";
        exit;
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

    // 进行词汇替换
    public function tihuan($neirong) {
        include BBS_PATH.'include/tihuan.php';
        foreach($tihuan as $k => $v) {
            $neirong = str_replace($k, $v, $neirong);
        }
        return $neirong;
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

    // 获得memcache里的某个数据
    public function memcache_get($key) {
        $mem = new cache_memcache($this->conf['cache']['memcache']);
        $data = $mem->get($key);
        return $data;
    }

    // 写入memcache里的某个数据，默认1天
    public function memcache_set($key, $val, $time = 86400) {
        $mem = new cache_memcache($this->conf['cache']['memcache']);
        $data = $mem->set($key, $val, $time);
        return $data;
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

    //替换中奖部分内容为星号，只显示首尾各1字符
    public function tw_xing($str){
        $len = strlen($str);
        $xing = substr($str, 1, $len - 2);
        return str_replace($xing,'****',$str);
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
    public function post($url, $postdata,$header='', $num = 1) {
        if($num > 3){
            return FALSE;
        }
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl,CURLOPT_HTTPHEADER,$header);
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.76 Mobile Safari/537.36"); // 模拟用户使用的浏览器
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
            $this->za->post($url, $postdata, $header , $num);//捕抓异常
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
        $info = mysqli_fetch_assoc($memails);
        return $info;
    }

    public function mysql_list( $sql ){
        $info = array();
        $memails = $this->db->query( $sql );
        while($data = mysqli_fetch_assoc($memails)) {
            $info[] = $data;
        }
        return $info;
    }

    public function login_log($uid,$site_id,$ip = '' ,$money , $orders_number, $result,$type,$platform_id,$game_id,$order_id)
    {
        $this->c('loginlog');
        $data =  array(
            'uid' => $uid,
            'site_id' => $site_id,
            'add_time' => time(),
            'ip' => $ip,
            'money' => !empty($money) ? $money : $result['money'] ,
            'orders_number' => !empty($orders_number) ? $orders_number : $result['orders_number'],
            'infos' => json_encode($result),
            'typeid' => $type,
            'platform_id' => $platform_id,
            'game_id' => $game_id,
            'order_id' => $order_id,
        );
        $id = $this->loginlog->add($data);
        return $id;
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

    public function getFileLines($filename, $startLine = 1, $endLine=50, $method='rb') {
        $content = array();
        $count = $endLine - $startLine;
        // 判断php版本（因为要用到SplFileObject，PHP>=5.1.0）
        if(version_compare(PHP_VERSION, '5.1.0', '>=')){
            $fp = new SplFileObject($filename, $method);
            $fp->seek($startLine-1);// 转到第N行, seek方法参数从0开始计数
            for($i = 0; $i <= $count; ++$i) {
                $content[]=$fp->current();// current()获取当前行内容
                $fp->next();// 下一行
            }
        }else{//PHP<5.1
            $fp = fopen($filename, $method);
            if(!$fp) return 'error:can not read file';
            for ($i=1;$i<$startLine;++$i) {// 跳过前$startLine行
                fgets($fp);
            }
            for($i;$i<=$endLine;++$i){
                $content[]=fgets($fp);// 读取文件行内容
            }
            fclose($fp);
        }
        return array_filter($content); // array_filter过滤：false,null,''
    }

    /**
     * curl POST
     *
     * @param   string  url
     * @param   array   数据
     * @param   int     请求超时时间
     * @param   bool    HTTPS时是否进行严格认证
     * @return  string
     */
    public function curlPost($url, $data = array(), $type = 3, $timeout = 600, $cookie = '', $header = array(), $lailu = '', $view_info = 0){
        set_time_limit(0);
        $cookie_file = BBS_PATH.'/cookie.txt';
        $cacert = getcwd() . '/cacert.pem'; //CA根证书
        $SSL = substr($url, 0, 8) == "https://" ? true : false;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout-2);
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
        //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // 信任任何证书
        //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); // 检查证书中是否设置域名
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.76 Mobile Safari/537.36" );
        if($type == 2){
            curl_setopt($ch, CURLOPT_COOKIEJAR,  $cookie_file); //存储cookies
        }else if($type == 1){
            curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file); //使用上面获取的cookies
        }
        if(!empty($cookie)){
            curl_setopt( $ch, CURLOPT_COOKIE, $cookie);
        }
        if(!empty($header)){
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }else{
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:')); //避免data数据过长问题
        }
        if(!empty($lailu)){
            curl_setopt($ch, CURLOPT_REFERER, $lailu);
        }else{
            //curl_setopt($ch, CURLOPT_REFERER, "http://pub.alimama.com/promo/item/channel/index.htm?q=u%E7%9B%98%2032g&channel=qqhd&_t=1506361083289");
        }
        if(!empty($data)){
            curl_setopt($ch, CURLOPT_POST, 1);
           curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        }
        //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data)); //data with URLEncode
       /* print_r($url);
        print_r($data);
        print_r($header);
        exit;*/

        $ret = curl_exec($ch);

        if($view_info == 1){
            $data = curl_getinfo($ch);
            $data['body'] = $ret;
            curl_close($ch);
            return $ret;
        }
        /*
        $httpcode   = curl_getinfo($ch);
        print_r($ret);
        print_r($httpcode);
        $data = array(
            'body' => $ret,
            'httpcode' => $httpcode,
        );
        */

        /*if(empty($ret))
        {
            print_r(curl_getinfo($ch,CURLINFO_HTTP_CODE));
            echo  '\r\n'.$url."\r\n";
            $error = curl_error($ch);
            print_r($error);
            echo "\r\n";
            curl_close($ch);
            return json_encode($error);
        }*/
        //var_dump(curl_error($ch));  //查看报错信息
        curl_close($ch);
        return $ret;
    }

    function arrToDate($array){
        $array_list = array();
        foreach($array as $k => $v){
            $array_list[] = $k.'='.$v;
        }
        $str = implode("&", $array_list);
        return $str;
    }

    /** 写入日志
     * @param $id
     * @param $time
     * @param $marker
     * @param string $data
     * @param string $file
     * @param string $dir
     * @return int
     */
    public function make_log($id, $time, $marker, $data = '', $file = '', $dir = 'file_log'){
        date_default_timezone_set('Asia/Shanghai');
        $old_id = $id;
        if(strlen($id) < 2){
            $id = str_pad($id, 2, "0", STR_PAD_LEFT);
        }
        $dir_files = substr($id, strlen($id) - 2, strlen($id));
        $dir_name = BBS_PATH.$dir.'/'.$dir_files;
        if(!is_dir($dir_name)){
            @mkdir($dir_name, 0777);
        }
        $dir_name .= '/'.$old_id;
        if(!is_dir($dir_name)){
            @mkdir($dir_name, 0777);
        }
        $date = date("Ymd", $time);
        $file_name = $dir_name.'/'.$file.$date.'.txt';
        file_put_contents($file_name, $marker.'|-|'.date('Y-m-d H:i:s', $time).'|-|'.$data.PHP_EOL, FILE_APPEND);
        return 1;
    }

    //获得网页状态
    public function  curl_stuat($url, $postdata = array(), $cookie = ''){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 200);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_NOBODY, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0 );
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0 );
        if(!empty($postdata)){
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postdata));
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE);
        $ret = curl_exec($ch);
        $httpCode = curl_getinfo($ch,CURLINFO_HTTP_CODE);
        return array('stuat' => $httpCode, 'info' => $ret);
    }

    //获得网页COOKIE与内容
    public function cookie_curlPost($url, $postdata = array(), $referer = '', $headers = array(), $timeout = 600){
        $ret = $header = $body = '';
        $cacert = getcwd() . '/cacert.pem'; //CA根证书
        $SSL = substr($url, 0, 8) == "https://" ? true : false;
        //$headers['CLIENT-IP'] = '202.103.229.40';
        //$headers['X-FORWARDED-FOR'] = '202.103.229.40';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout-2);
        if(empty($headers)){
            $headers['User-Agent'] = 'Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.56 Safari/537.17';
            $headerArr = array();
            foreach( $headers as $n => $v ){
                $headerArr[] = $n .':' . $v;
            }
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER , $headerArr );
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // 信任任何证书
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); // 检查证书中是否设置域名
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:')); //避免data数据过长问题
        if(!empty($postdata)){
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        }
        if(!empty($referer)){
            curl_setopt($ch, CURLOPT_REFERER, $referer);
        }
        curl_setopt($ch, CURLOPT_HEADER,1);
        $ret = curl_exec($ch);
        if(curl_getinfo($ch, CURLINFO_HTTP_CODE) == '200') {
            list($header, $body) = explode("\r\n\r\n", $ret, 2);
        }
        //print_r($ret);
        //print_r($header);
        //echo "-----------";
        //print_r($body);
        //exit;
        preg_match('/Set-Cookie:(.*);/iU',$header, $str); //正则匹配
        $cookies = '';
        if(!empty($str[1])){
            $cookies = trim($str[1]); //获得COOKIE（SESSIONID）
        }
        $infos = array('cookie' => $cookies, 'body' => $body);
        //var_dump(curl_error($ch));  //查看报错信息
        curl_close($ch);
        return $infos;
    }

    //获得跳转后的地址
    public function  curl_post_302($url, $postdata = array(), $cookie = '', $r_url = 0) {
        $url = str_replace('&amp;', '&', $url);
        //echo $url."-----------";
        $ch = curl_init();
        if($r_url == 1){
            curl_setopt($ch, CURLOPT_HEADER, 1);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0 );
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0 );
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // 302 redirect
        if(!empty($postdata)){
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch,  CURLOPT_POSTFIELDS, $postdata);
        }
        if(!empty($cookie)){
            curl_setopt( $ch, CURLOPT_COOKIE, $cookie);
        }
        //curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.76 Mobile Safari/537.36" );
        $data = curl_exec($ch);
        //$Headers =  curl_getinfo($ch);
        //print_r($data);exit;
        //print_r($Headers);exit;
        curl_close($ch);
        if($r_url == 1){
            preg_match('/Location: (.*)\r\n/iU', $data, $new_url);
            if(!empty($new_url[1])){
                return $new_url[1];
            }else{
                return $url;
            }
        }else{
            return $data;
        }
    }

    //输出XML格式
    public static function flexigridXML($flexigridXML){
        $page = $flexigridXML['now_page'];
        $total = $flexigridXML['total_num'];
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
        header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
        header("Cache-Control: no-cache, must-revalidate" );
        header("Pragma: no-cache" );
        header("Content-type: text/xml");
        $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
        $xml .= "<rows>";
        $xml .= "<page>$page</page>";
        $xml .= "<total>$total</total>";
        if(empty($flexigridXML['list'])){
            $xml .= "<row id=''>";
            $xml .= "<cell></cell>";
            $xml .= "</row>";
        }else{
            foreach ($flexigridXML['list'] as $k => $v){
                $xml .= "<row id='".$k."'>";
                foreach ($v as $kk => $vv){
                    $xml .= "<cell><![CDATA[".$v[$kk]."]]></cell>";
                }
                $xml .= "</row>";
            }
        }
        $xml .= "</rows>";
        echo $xml;
    }

    //解析URL格式参数，自动转换时间戳格式
    public function url_k_v($str){
        $data = array();
        $parameter = explode('&', $str);
        foreach($parameter as $val){
            $tmp = explode('=', $val);
            if(!empty($tmp[1])){
                $tmp[0] = urldecode($tmp[0]);
                $tmp[1] = urldecode($tmp[1]);
                $exp = explode("[", $tmp[0]);
                $patten = "/^\d{4}[\-](0?[1-9]|1[012])[\-](0?[1-9]|[12][0-9]|3[01])(\s+(0?[0-9]|1[0-9]|2[0-3])\:(0?[0-9]|[1-5][0-9])\:(0?[0-9]|[1-5][0-9]))?$/";
                if (preg_match($patten, $tmp[1])) {
                    $tmp[1] = strtotime($tmp[1]);
                }
                if(!empty($exp[1])){
                    preg_match("/(.*)\[(.*)\]/i", $tmp[0], $canshu);
                    $data[$canshu[1]][$canshu[2]] = $tmp[1];
                }else{
                    $data[$tmp[0]] = $tmp[1];
                }
            }
        }
        return $data;
    }

    //将 xml数据转换为数组格式。
    public function xml_to_array($xml){
        $reg = "/<(\w+)[^-->]*>([\\x00-\\xFF]*)<\\/\\1>/";
        if(preg_match_all($reg, $xml, $matches)){
            $count = count($matches[0]);
            for($i = 0; $i < $count; $i++){
                $subxml= $matches[2][$i];
                $key = $matches[1][$i];
                if(preg_match( $reg, $subxml )){
                    $arr[$key] = $this->xml_to_array( $subxml );
                }else{
                    $arr[$key] = $subxml;
                }
            }
        }
        return $arr;
    }

    /** 文本读取返回指定行到指定行的数据
     * @param string $filename 文件名
     * @param int $start 开始的行数
     * @param int $line 数据行数
     * @param string $method 读取方式
     * @return array
     */
    public function read_txt_line($filename, $start = 1, $line = 50, $method = 'rb') {
        $content = array();
        // PHP>=5.1.0使用SplFileObject，效率略高fopen
        if(class_exists('SplFileObject')){
            $fp = new SplFileObject($filename, $method);
            //$fp->seek(filesize($filename));
            //echo $fp->key();
            $fp->seek($start - 1);// 转到第N行, seek方法参数从0开始计数
            for($i = 1; $i <= $line; ++$i){
                $content[] = trim($fp->current());// current()获取当前行内容
                $fp->next();// 下一行
            }
        }else{
            //PHP<5.1使用fopen
            $fp = fopen($filename, $method);
            if(!$fp) return '无法打开文件';
            for ($i = 1; $i < $start; ++$i) {// 跳过前$start行
                fgets($fp);
            }
            for($i = 1; $i <= $line; ++$i){
                $content[] = trim(fgets($fp));//读取文件行内容
            }
            fclose($fp);
        }
        return $content;
    }

    /**
     * 二维数组根据字段进行排序
     * @params array $array 需要排序的数组
     * @params string $field 排序的字段
     * @params string $sort 排序顺序标志 SORT_DESC 降序；SORT_ASC 升序
     */
    function arraySequence($array, $field, $sort = 'SORT_DESC'){
        $arrSort = array();
        foreach ($array as $uniqid => $row) {
            foreach ($row as $key => $value) {
                $arrSort[$key][$uniqid] = $value;
            }
        }
        array_multisort($arrSort[$field], constant($sort), $array);
        return $array;
    }

    //转数组为字符串，用于COOKIE类的操作
    function arraytostr($array){
        $array_list = array();
        foreach($array as $k => $v){
            $array_list[] = $k.'='.$v.';';
        }
        $str = implode(" ", $array_list);
        return $str;
    }

    //转字符串为数组，用于COOKIE类的操作
    function strtoarray($str){
        $array_list = array();
        $exp = explode(";", $str);
        if(!empty($exp)){
            foreach($exp as $k => $v){
                $k_v = explode("=", trim($v));
                $array_list[trim($k_v[0])] = trim($k_v[1]);
            }
        }
        return $array_list;
    }

    //复制数据表结构
    function copy_table($new_table, $old_table){
        $sql = 'CREATE TABLE '.$new_table.' LIKE '.$old_table;
        $memails = $this->db->query( $sql );
        return $memails;
    }

    //查询所有表名
    function select_table(){
        $info = array();
        $sql = 'SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = \''.$this->conf['db'][$this->conf['db']['type']]['master']['name'].'\'';
        $memails = $this->db->query( $sql );
        while($data = mysqli_fetch_assoc($memails)) {
            $info[] = $data['TABLE_NAME'];
        }
        return $info;
    }
}
?>