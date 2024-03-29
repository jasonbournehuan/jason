<?php
if(!defined('FRAMEWORK_PATH')) {
	exit('FRAMEWORK_PATH not defined.');
}

class db_mysqli implements db_interface {

	private $conf;
	//private $wlink;	// 读写分离
	//private $rlink;	// 读写分离
	public $tablepre;	// 方便外部读取
	
	public function __construct($conf) {
		$this->conf = $conf;
		$config = include BBS_PATH."conf/conf.php";
		$this->config = $config;
		$this->tablepre = $this->conf['master']['tablepre'];
	}
	
	// update 指定字段，除非是必要的更新，否则不使用这个函数
	public function update1($key, $data, $life = 0) {
		list($table, $keyarr, $sqladd) = $this->parse_key($key);
		$tablename = $this->tablepre.$table;
		if(is_array($data)) {
			$s = '';
			foreach($data as $k=>$v) {
				if(is_array($v)){
					foreach($v as $dk => $dv){
						//只处理加减操作
						if($dk == '+' || $dk == '-'){
							$dv = addslashes($dv);
							$s .= "$k=$k$dk'$dv',";
						}
					}
				}else{
					$v = addslashes($v);
					$s .= "$k='$v',";
				}
			}
			$s = substr($s, 0, -1);
			$this->del_cache($key);
			return $this->query("UPDATE $tablename SET $s WHERE $sqladd", $this->wlink);
		} else {
			return FALSE;
		}
	}

	public function check_cache($key) {
		if($this->config['cache_colse'] == 1){
			$mem = new cache_memcache($this->config['cache']['memcache']);
			$cache = $mem->get($key);
			if(!empty($cache)){
				return $cache;
			}
		}
	}

	public function send_cache($key, $data, $time = 60) {
		if($this->config['cache_colse'] == 1){
			$mem = new cache_memcache($this->config['cache']['memcache']);
			$mem->set($key, $data, 0, $time);
		}
	}

	public function del_cache($key) {
		if($this->config['cache_colse'] == 1){
			$mem = new cache_memcache($this->config['cache']['memcache']);
			$mem->delete($key);
		}
	}
		
	public function __get($var) {
		$conf = $this->conf;
		if($var == 'rlink') {
			// 如果没有指定从数据库，则使用 master
			if(empty($this->conf['slaves'])) {
				$this->rlink = $this->wlink;
				return $this->rlink;
			}
			$n = rand(0, count($this->conf['slaves']) - 1);
			$conf = $this->conf['slaves'][$n];
			empty($conf['engine']) && $conf['engine'] = '';
			$this->rlink = $this->connect($conf['host'], $conf['user'], $conf['password'], $conf['name'], $conf['charset'], $conf['engine']);
			return $this->rlink;
		} elseif($var == 'wlink') {
			$conf = $this->conf['master'];
			empty($conf['engine']) && $conf['engine'] = '';
			$this->wlink = $this->connect($conf['host'], $conf['user'], $conf['password'], $conf['name'], $conf['charset'], $conf['engine']);
			return $this->wlink;
		}
		
		// innodb_flush_log_at_trx_commit
	}
	
	// insert多条
	public function add_list($key, $data, $life = 0) {
		$sql_num = 1000;//一次性最大入库的数据量
		//list($table, $keyarr, $sqladd) = $this->parse_key($key);
		$tablename = $this->tablepre.$key;
		if(is_array($data)) {
			// 覆盖主键的值
			//$data += $keyarr;
			$s = array();
			foreach($data as $k=>$v) {
				if(is_array($v)){
					$fi = array();
					$list = 1;
					foreach($v as $ak => $av){
						$fi[] = "`".trim($ak)."`";
						$data[$k][$ak] = "'".addslashes(trim($av))."'";
					}
					$s[] = "(".implode(",", $data[$k]).")";
				}else{
					$fi[] = "`".trim($k)."`";
					$list = 0;
					$v = addslashes(trim($v));
					$s[] = "'".$v."'";
				}
			}
			$fi = "(".implode(",", $fi).")";
			if($list == 1){
				if(count($s) > $sql_num){
					$s_num = 0;
					$list_s = array();
					foreach($s as $sk => $sv){
						$s_num += 1;
						$list_s[] = $sv;
						if($s_num == $sql_num){
							$s_num = 0;
							$s_sql = implode(",", $list_s);
							$list_s = array();
							$this->query("INSERT DELAYED INTO $tablename $fi VALUES $s_sql;", $this->wlink);
						}
					}
					if(!empty($list_s)){
						$s_sql = implode(",", $list_s);
						return $this->query("INSERT DELAYED INTO $tablename $fi VALUES $s_sql;", $this->wlink);
					}else{
						return 1;
					}
				}else{
					$s = implode(",", $s);
				}
			}else{
				$s = "(".implode(",", $s).")";
			}
			//echo "REPLACE INTO $tablename SET $s", $this->wlink;
			//$this->del_cache($key);
			//echo "INSERT INTO $tablename $fi VALUE $s;";
			//exit;
			return $this->query("INSERT DELAYED INTO $tablename $fi VALUES $s;", $this->wlink);
		} else {
			return FALSE;
		}
		
	}

	//分组列表详细
	public function group($table, $where = array(), $field = "", $fields = array()){
		$tablename = $this->tablepre.$table;
		$fields = implode(",", $fields);
		$s = "SELECT ".$fields." FROM ".$tablename." WHERE ";
		foreach($where as $k=>$v) {
			if(!is_array($v)) {
				$v = addslashes($v);
				$s .= "$k = '$v' AND ";
			} else {
				foreach($v as $k1=>$v1) {
					$v1 = addslashes($v1);
					$s .= "$k $k1 '$v1' AND ";
				}
			}
		} 
		if( !$where ){
			$s .= " 0 ";
		}
		$s = substr($s, 0, -4);
		$s .= "GROUP BY ".$field;
		//echo $s;
		//exit;
		$return = array();
		$result = $this->query($s, $this->rlink);
		while($data = mysqli_fetch_assoc($result)) {
			$return[] = $data;
		}
		return $return;
	}
	
	// insert单行数据
	public function add($key, $data, $life = 0) {
		list($table, $keyarr, $sqladd) = $this->parse_key($key);
		if(!empty($keyarr)){
			$array_key_one = array_keys($keyarr);
			if(!empty($data[$array_key_one[0]])){
				unset($data[$array_key_one[0]]);
			}
		}
		$tablename = $this->tablepre.$table;
		if(is_array($data)) {
			// 覆盖主键的值
			//$data += $keyarr;
			$s = $ks = array();
			foreach($data as $k=>$v) {
				$v = addslashes($v);
				$ks[] = $k;
				$s[] = "'".$v."'";
			}
			$k_value = implode(", ", $ks);
			$s_value = implode(", ", $s);
			//echo "INSERT INTO $tablename($k_value) value ($s_value)";exit;
			$add_info = $this->query("INSERT INTO $tablename($k_value) value ($s_value)", $this->wlink);
			return mysqli_insert_id($this->wlink);
		} else {
			return FALSE;
		}
	}
	
	// insert & update 整行更新
	public function set($key, $data, $life = 0) {
		//print_r($key);exit;
		list($table, $keyarr, $sqladd) = $this->parse_key($key);
		$tablename = $this->tablepre.$table;
		if(is_array($data)) {
			// 覆盖主键的值
			$data += $keyarr;
			$s = '';
			foreach($data as $k=>$v) {
				$v = addslashes($v);
				$s .= "$k='$v',";
			}
			$s = substr($s, 0, -1);
			//echo "REPLACE INTO $tablename SET $s", $this->wlink;
			//echo "REPLACE INTO $tablename SET $s||";
			$this->del_cache($key);
			return $this->query("REPLACE INTO $tablename SET $s", $this->wlink);
		} else {
			return FALSE;
		}
		
	}
	
	/**
		get('user-uid-123');
		get('user-fid-123-uid-123');
		get(array(
			'user-fid-123-uid-111',
			'user-fid-123-uid-222',
			'user-fid-123-uid-333'
		));
	
	*/

	public function get($key) {
		if(!is_array($key)) {
			list($table, $keyarr, $sqladd) = $this->parse_key($key);
			$tablename = $this->tablepre.$table;
			$cache = $this->check_cache($key);
			if(!empty($cache)){
				return $cache;
			}
			$result = $this->query("SELECT * FROM $tablename WHERE $sqladd", $this->rlink);
			$data = mysqli_fetch_assoc($result);
			$this->send_cache($key, $data, 1800);
			return $data;
		} else {
			// 此处可以递归调用，但是为了效率，单独处理
			$sqladd = $_sqladd = $table =  $tablename = '';
			$data = $return = $keyarr = array();
			$keys = $key;
			foreach($keys as $key) {
				$return[$key] = array();	// 定序，避免后面的 OR 条件取出时顺序混乱
				list($table, $keyarr, $_sqladd) = $this->parse_key($key);
				$cache = $this->check_cache($key);
				if(!empty($cache)){
					$return[$key] = $cache;
				}else{
					$tablename = $this->tablepre.$table;
					$sqladd .= "$_sqladd OR ";
				}
			}
			$sqladd = substr($sqladd, 0, -4);
			if($sqladd) {
				// todo: 需要判断分库。分库以后，这里会统一在一台DB上取
				$result = $this->query("SELECT * FROM $tablename WHERE $sqladd", $this->rlink);
				while($data = mysqli_fetch_assoc($result)) {
					$keyname = $table;
					foreach($keyarr as $k=>$v) {
						$keyname .= "-$k-".$data[$k];
					}
					$this->send_cache($keyname, $data, 1800);
					$return[$keyname] = $data;
				}
			}
			return $return;
		}
	}

	public function delete($key) {
		list($table, $keyarr, $sqladd) = $this->parse_key($key);
		$tablename = $this->tablepre.$table;
		$this->del_cache($key);
		return $this->query("DELETE FROM $tablename WHERE $sqladd", $this->wlink);
	}
	
	/**
	 * 
	 * maxid('user-uid') 返回 user 表最大 uid
	 * maxid('user-uid', '+1') maxid + 1, 占位，保证不会重复
	 * maxid('user-uid', 10000) 设置最大的 maxid 为 10000
	 *
	 */
	public function maxid($key, $val = FALSE) {
		list($table, $col) = explode('-', $key);
		$maxid = $this->table_maxid($key);
		if($val === FALSE) {
			return $maxid;
		} elseif(is_string($val) && $val{0} == '+') {
			$val = intval($val);
			$this->query("UPDATE {$this->tablepre}framework_maxid SET maxid=maxid+'$val' WHERE name='$table'", $this->wlink);
			return $maxid += $val;
		} else {
			$this->query("UPDATE {$this->tablepre}framework_maxid SET maxid='$val' WHERE name='$table'", $this->wlink);
			// ALTER TABLE Auto_increment 这个不需要改，REPLACE INTO 直接覆盖
			return $val;
		}
	}
	
	// 原生的 count
	public function native_maxid($table, $col) {
		$tablename = $this->tablepre.$table;
		$arr = $this->fetch_first("SELECT MAX($col) AS num FROM $tablename");
		return isset($arr['num']) ? intval($arr['num']) : 0;
	}
	
	/* 返回表的总行数
	* count('forum')
	* count('forum-fid-1')
	* count('forum-fid-2')
	*/
	public function count($key, $val = FALSE) {
		$count = $this->table_count($key);
		if($val === FALSE) {
			return $count;
		} elseif(is_string($val)) {
			$count = $this->table_count($key);
			if($val{0} == '+') {
				$val = $count + abs(intval($val));
				$this->query("UPDATE {$this->tablepre}framework_count SET count = '$val' WHERE name='$key'", $this->wlink);
				return $val;
			} else {
				$val = max(0, $count - abs(intval($val)));
				$this->query("UPDATE {$this->tablepre}framework_count SET count = '$val' WHERE name='$key'", $this->wlink);
				return $val;
			}
		} else {
			$this->query("UPDATE {$this->tablepre}framework_count SET count='$val' WHERE name='$key'", $this->wlink);
			return $val;
		}
	}
	
	// 原生的 count
	public function native_count($table) {
		$tablename = $this->tablepre.$table;
		$arr = $this->fetch_first("SELECT COUNT(*) AS num FROM $tablename");
		return isset($arr['num']) ? intval($arr['num']) : 0;
	}
	
	public function truncate($table) {
		$table = $this->tablepre.$table;
		try {
			$this->query("TRUNCATE $table");// 不存在，会报错，但无关紧要
			return TRUE;
		} catch(Exception $e) {
			return FALSE;
		}
	}

	/*
		用法：
			同 index_fetch_id()
		返回：
			array(
				'user-uid-1'=>array('uid'=>1, 'username'=>'zhangsan'),
				'user-uid-2'=>array('uid'=>2, 'username'=>'lisi'),
				'user-uid-3'=>array('uid'=>3, 'username'=>'wangwu'),
			)
	*/
	public function index_fetch($table, $keyname, $cond = array(), $orderby = array(), $start = 0, $limit = 0) {
		$keynames = $this->index_fetch_id($table, $keyname, $cond, $orderby, $start, $limit);
		//print_r($keynames);exit;
		if(!empty($keynames)) {
			return $this->get($keynames);			
		} else {
			return array();
		}
	}
	
	/**
	 	用法：
			index_fetch_id('user', 'uid', array('uid'=> 100), array('uid'=>1), 0, 10);
			index_fetch_id('user', 'uid', array('uid'=> array('>'=>'100', '<'=>'200')), array('uid'=>1), 0, 10);
			index_fetch_id('user', 'uid', array('username'=> array('LIKE'=>'abc'), array('uid'=>1), 0, 10);
		返回：
			array (
				'user-uid-1',
				'user-uid-2',
				'user-uid-3',
			)
	*/
	public function index_fetch_id($table, $keyname, $cond = array(), $orderby = array(), $start = 0, $limit = 0) {
		$tablename = $this->tablepre.$table;
		$keyname = (array)$keyname;

		$sqladd = implode(',', $keyname);
		$s = "SELECT $sqladd FROM $tablename";

		if(!empty($cond)) {
			$s .= ' WHERE ';
			foreach($cond as $k=>$v) {
				if(!is_array($v)) {
					$v = addslashes($v);
					$s .= "$k = '$v' AND ";
				} else {
					foreach($v as $k1=>$v1) {
						$v1 = addslashes($v1);
						$k1 == 'LIKE' && $v1 = "%$v1%";
						$s .= "$k $k1 '$v1' AND ";
					}
				}
			}
			$s = substr($s, 0, -4);
		}
		if(!empty($orderby)) {
			$s .= ' ORDER BY ';
			$comma = '';
			foreach($orderby as $k=>$v) {
				$s .= $comma."$k ".($v == 1 ? ' ASC ' : ' DESC ');
				$comma = ',';
			}
		}
		$s .= ($limit ? " LIMIT $start, $limit" : '');
//		echo $s;
//		exit;
		$return = array();
		$result = $this->query($s, $this->rlink);
		while($data = mysqli_fetch_assoc($result)) {
			$keyadd = '';
			foreach($keyname as $k) {
				$keyadd .= "-$k-".$data[$k];
			}
			$return[] = $table.$keyadd;
		}
		return $return;
	}
	
        
        //统计指定字段总和
	public function sum($table, $where = array(), $field = array()){
		$tablename = $this->tablepre.$table;
		foreach($field as $k => $v){
			$field[$k] = " sum(".$v.") as ".$v."s ";
		}
		$fields = implode(',', $field);
		$s = "SELECT ".$fields." FROM ".$tablename." WHERE ";
		foreach($where as $k=>$v) {
			if(!is_array($v)) {
		$v = addslashes($v);
		$s .= "$k = '$v' AND ";
			} else {
		foreach($v as $k1=>$v1) {
			$v1 = addslashes($v1);
			if($k1 == 'EXP'){
				$s .= "$v1 AND ";
			}else if($k1 == 'in' or $k1 == 'not in'){
				$s .= "$k $k1($v1) AND ";
			}else if($k1 == 'between'){
				$s .= "$k $k1 $v1 AND ";
			}else{
				$k1 == 'LIKE' && $v1 = "%$v1%";
				$s .= "$k $k1 '$v1' AND ";
			}
		}
			}
		} 
		if( !$where ){
			$s .= "0";
		}
		$s = substr($s, 0, -4);
		//echo "||".$s."||";
		$sum = mysqli_fetch_assoc($this->query($s));
		/*$mem = new cache_memcache($this->conf['cache']['memcache']);
		$cache=$mem->get('db');
		$hashvalue = hash('sha256',$s);
		if( !empty($cache[$table][$hashvalue]['uptime']) and $cache[$table][$hashvalue]['uptime'] >= $_SERVER['time'] - 3600){
			$count = mysql_fetch_assoc($this->db->query($s));
			$cache[$table][$hashvalue] = array();
			$cache[$table][$hashvalue]['total'] = $count;
			$cache[$table][$hashvalue]['uptime'] = $_SERVER['time'];
			$mem->set('db', $cache, 0, 86400);
		}else{
			$count = $cache[$table][$hashvalue]['total'];
		}*/
		foreach($sum as $k => $v){
			if(empty($sum[$k])){
				$sum[$k] = 0;
			}
		}
		return $sum;
	}

	//统计列表总数
	public function total($table, $where = array()){
		$tablename = $this->tablepre.$table;
		$s = "SELECT count(*) as num FROM ".$tablename." WHERE ";
		foreach($where as $k=>$v) {
			if(!is_array($v)) {
				$v = addslashes($v);
				$s .= "$k = '$v' AND ";
			} else {
				foreach($v as $k1=>$v1) {
					$v1 = addslashes($v1);
					$s .= "$k $k1 '$v1' AND ";
				}
			}
		} 
		if( !$where ){
			$s .= "0";
		}
		$s = substr($s, 0, -4);
		$count = mysqli_fetch_assoc($this->query($s));
		/*$mem = new cache_memcache($this->conf['cache']['memcache']);
		$cache=$mem->get('db');
		$hashvalue = hash('sha256',$s);
		if( !empty($cache[$table][$hashvalue]['uptime']) and $cache[$table][$hashvalue]['uptime'] >= $_SERVER['time'] - 3600){
			$count = mysql_fetch_assoc($this->db->query($s));
			$cache[$table][$hashvalue] = array();
			$cache[$table][$hashvalue]['total'] = $count;
			$cache[$table][$hashvalue]['uptime'] = $_SERVER['time'];
			$mem->set('db', $cache, 0, 86400);
		}else{
			$count = $cache[$table][$hashvalue]['total'];
		}*/
		return isset($count['num'])?$count['num']:0;
	}
	
	// --------------> mysql 特定接口，仅供升级使用
	public function fetch_first($sql) {
		$result = $this->query($sql, $this->rlink);
		return mysqli_fetch_assoc($result);
	}
	/*
	public function fetch_all($sql) {
		$return = $data = array();
		$result = $this->query($sql, $this->rlink);
		while($data = mysql_fetch_assoc($result)) {
			$return[] = $data;
		}
		return $return;
	}
	*/
	
	// -------------> 特定接口
	
	// $index = array('uid'=>1, 'dateline'=>-1)
	// $index = array('uid'=>1, 'dateline'=>-1, 'unique'=>TRUE, 'dropDups'=>TRUE)
	// 创建索引
	public function index_create($table, $index) {
		$table = $this->tablepre.$table;
		$keys = implode(', ', array_keys($index));
		$keyname = implode('', array_keys($index));
		return $this->query("ALTER TABLE $table ADD INDEX $keyname($keys)");
	}
	
	// 删除索引
	public function index_drop($table, $index) {
		$table = $this->tablepre.$table;
		$keys = implode(', ', array_keys($index));
		$keyname = implode('', array_keys($index));
		return $this->query("ALTER TABLE $table DROP INDEX $keyname");
	}

	// -------------> 公共方法，非公开接口
	public function query($sql, $link = NULL) {
		empty($link) && $link = $this->wlink;
		defined('DEBUG') && DEBUG && isset($_SERVER['sqls']) && count($_SERVER['sqls']) < 1000 && $_SERVER['sqls'][] = htmlspecialchars(stripslashes($sql));// fixed: 此处导致的轻微溢出后果很严重，已经修正。
		$result = mysqli_query($link, $sql);
		if(!$result) {
			throw new Exception(self::br('MySQL Query Error:'.$sql.'. '.mysqli_error($link)));
		}
		return $result;
	}
	
	// -------------> 私有方法
	private function connect($host, $user, $password, $name, $charset, $engine = '') {
		$link = mysqli_connect($host, $user, $password, $name);
		if(!$link) {
			throw new Exception(self::br(mysqli_error()));
		}
		/*
		$bool = mysql_select_db($name, $link);
		if(!$bool) {
			throw new Exception(self::br(mysqli_error()));
		}
		*/
		if(!empty($engine) && $engine == 'InnoDB') {
			$this->query("SET innodb_flush_log_at_trx_commit=no", $link);
		}
		// 保证客户端一直是 utf-8
		if($charset) {
			// character_set_connection: sql 语句的编码，写入中文字符的时候必须设置正确
			// character_set_results: mysqld 返回的数据编码
			// character_set_client: 客户端编码, binary 不转换 mysqld 会将 character_set_client -> character_set_connection.
			$this->query("SET character_set_connection=utf8, character_set_results=utf8, character_set_client=binary, sql_mode=''", $link);
			//$this->query("SET names $charset /* $host $user */", $link);
			//$this->query("SET sql_mode=''", $link);
		}
		// sql-mode=""
		return $link;
	}

	private function result($query, $row, $first_name = '0') {
		//return mysqli_num_rows($query) ? intval(mysqli_result($query, $row)) : 0;
		$rows = mysqli_num_rows($query);
		if(intval($rows) >= 1){
			$data = mysqli_fetch_assoc($query);
			if(!empty($data[$first_name])){
				return intval($data[$first_name]);
			}else{
				return 0;
			}
		}else{
			return 0;
		}
	}
	
	/*
		例子：
		table_count('forum');
		table_count('forum-fid-1');
		table_count('forum-fid-2');
		table_count('forum-stats-12');
		table_count('forum-stats-1234');
		返回：总数值
	*/
	private function table_count($key) {
		$key = addslashes($key);
		$count = 0;
		$query = mysqli_query($this->rlink, "SELECT count FROM {$this->tablepre}framework_count WHERE name='$key'");
		if($query) {
			$count = $this->result($query, 0, 'count');
		} elseif(mysqli_errno($this->rlink) == 1146) {
			$this->query("CREATE TABLE {$this->tablepre}framework_count (
				`name` char(32) NOT NULL default '',
				`count` int(11) unsigned NOT NULL default '0',
				PRIMARY KEY (`name`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");
		} else {
			throw new Exception('framework_cout 错误, mysql_error:'.mysqli_error());
		}
		if(empty($count)) {
			$this->query("REPLACE INTO {$this->tablepre}framework_count SET name='$key', count='0'", $this->wlink);
		}
		return $count;
	}
	
	/*
		例子：只能为表名
		table_maxid('forum-fid');
		table_maxid('thread-tid');
	*/
	private function table_maxid($key) {
		$key = addslashes($key);
		list($table, $col) = explode('-', $key);
		$maxid = 0;
		$query = mysqli_query($this->rlink, "SELECT maxid FROM {$this->tablepre}framework_maxid WHERE name='$table'");
		if($query) {
			$maxid = $this->result($query, 0, 'maxid');
		} elseif(mysqli_errno($this->rlink) == 1146) {
			$this->query("CREATE TABLE `{$this->tablepre}framework_maxid` (
				`name` char(32) NOT NULL default '',
				`maxid` int(11) unsigned NOT NULL default '0',
				PRIMARY KEY (`name`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");
		} else {
			throw new Exception("{$this->tablepre}framework_maxid 错误, mysql_errno:".mysqli_errno().', mysql_error:'.mysqli_error());
		}
		if(empty($maxid)) {
			$query = $this->query("SELECT MAX($col) FROM {$this->tablepre}$table", $this->rlink);
			$maxid = $this->result($query, 0, 'maxid');
			$this->query("REPLACE INTO {$this->tablepre}framework_maxid SET name='$table', maxid='$maxid'", $this->wlink);
		}
		return $maxid;
	}
	
	public static function br($s) {
		if(!core::is_cmd()) {
			return nl2br($s);
		} else {
			return $s;
		}
	}
	
	/*
		in: 'forum-fid-1-uid-2'
		out: array('forum', 'fid=1 AND uid=2', array('fid'=>1, 'uid'=>2))
	*/
	private function parse_key($key) {
		$sqladd = '';
		$arr = explode('-', $key);
		$len = count($arr);
		$keyarr = array();
		for($i = 1; $i < $len; $i = $i + 2) {
			if(isset($arr[$i + 1])) {
				$sqladd .= ($sqladd ? ' AND ' : '').$arr[$i]."='".addslashes($arr[$i + 1])."'";
				$t = $arr[$i + 1];// mongodb 识别数字和字符串
				$keyarr[$arr[$i]] = is_numeric($t) ? intval($t) : $t;
			} else {
				$keyarr[$arr[$i]] = NULL;
			}
		}
		$table = $arr[0];
		if(empty($table)) {
			throw  new Exception("parse_key($key) failed, table is empty.");
		}
		if(empty($sqladd)) {
			throw  new Exception("parse_key($key) failed, sqladd is empty.");
		}
		return array($table, $keyarr, $sqladd);
	}
	
	public function __destruct() {
		if(!empty($this->wlink)) {
			mysqli_close($this->wlink);
		}
		if(!empty($this->rlink) && !empty($this->wlink) && $this->rlink != $this->wlink) {
			mysqli_close($this->rlink);
		}
	}
	
	public function version() {
		return mysqli_get_server_info($this->rlink);
	}
	
	public function shiwu_start() {
		echo "2223";exit;
	}

}
?>