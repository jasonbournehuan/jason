<?php
if(!defined('FRAMEWORK_PATH')) {
	exit('FRAMEWORK_PATH not defined.');
}

class db_pdo implements db_interface {

	private $conf;
	//private $wlink;	// 读写分离
	//private $rlink;	// 读写分离
	public $tablepre;	// 方便外部读取
	
	public function __construct($conf) {
		$this->conf = $conf;
		$this->tablepre = $this->conf['master']['tablepre'];
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
			$this->rlink = $this->connect($conf['host'], $conf['user'], $conf['password'], $conf['name'], $conf['charset']);
			return $this->rlink;
		} elseif($var == 'wlink') {
			$conf = $this->conf['master'];
			$this->wlink = $this->connect($conf['host'], $conf['user'], $conf['password'], $conf['name'], $conf['charset'], $conf['engine']);
			return $this->wlink;
		}
	}
	
	
	private function connect($host, $user, $password, $name, $charset, $engine) {
		if(strpos($host, ':') !== FALSE) {
			list($host, $port) = explode(':', $host);
		} else {
			$port = 3306;
		}
		try {
			$link = new PDO("mysql:host=$host;port=$port;dbname=$name", $user, $password);
			//$link->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
		} catch (Exception $e) {    
	        	throw new Exception('连接数据库服务器失败:'.$e->getMessage());    
	        }
	        //$link->setFetchMode(PDO::FETCH_ASSOC);
		if($charset) {
			 $link->query('SET NAMES '.$charset);  
		}
		return $link;
	}
	
	// insert & update 整行更新
	public function set($key, $data, $life = 0) {
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
			return $this->query("REPLACE INTO $tablename SET $s");
		} else {
			return FALSE;
		}
	}
	
	public function get($key) {
		if(!is_array($key)) {
			list($table, $keyarr, $sqladd) = $this->parse_key($key);
			$tablename = $this->tablepre.$table;
       			return $this->fetch_first("SELECT * FROM $tablename WHERE $sqladd");
		} else {
			// 此处可以递归调用，但是为了效率，单独处理
			$sqladd = $_sqladd = $table =  $tablename = '';
			$data = $return = $keyarr = array();
			$keys = $key;
			foreach($keys as $key) {
				$return[$key] = array();	// 定序，避免后面的 OR 条件取出时顺序混乱
				list($table, $keyarr, $_sqladd) = $this->parse_key($key);
				$tablename = $this->tablepre.$table;
				$sqladd .= "$_sqladd OR ";
			}
			$sqladd = substr($sqladd, 0, -4);
			if($sqladd) {
				$sql = "SELECT * FROM $tablename WHERE $sqladd";
				defined('DEBUG') && DEBUG && isset($_SERVER['sqls']) && count($_SERVER['sqls']) < 1000 && $_SERVER['sqls'][] = htmlspecialchars(stripslashes($sql));// fixed: 此处导致的轻微溢出后果很严重，已经修正。
				$result = $this->rlink->query($sql);
				$result->setFetchMode(PDO::FETCH_ASSOC);
				$datalist = $result->fetchAll();
				foreach($datalist as $data) {
					$keyname = $table;
					foreach($keyarr as $k=>$v) {
						$keyname .= "-$k-".$data[$k];
					}
					$return[$keyname] = $data;
				}
			}
			return $return;
		}
	}
	
	public function delete($key) {
		list($table, $keyarr, $sqladd) = $this->parse_key($key);
		$tablename = $this->tablepre.$table;
		return $this->query("DELETE FROM $tablename WHERE $sqladd");
	}
	
	/**
	 * 
	 * maxid('user-uid') 返回 user 表最大 userid
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
	
	public function count($key, $val = FALSE) {
		$count = $this->table_count($key);
		if($val === FALSE) {
			return $count;
		} elseif(is_string($val)) {
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
		return $this->query("TRUNCATE $table");
	}

	public function index_fetch($table, $keyname, $cond = array(), $orderby = array(), $start = 0, $limit = 0) {
		$keynames = $this->index_fetch_id($table, $keyname, $cond, $orderby, $start, $limit);
		if(!empty($keynames)) {
			return $this->get($keynames);			
		} else {
			return array();
		}
	}
	
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
					$s .= "$k = '$v' AND";
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
			$s .= ' ORDER BY  ';
			$comma = '';
			foreach($orderby as $k=>$v) {
				$s .= $comma."$k ".($v == 1 ? ' ASC ' : ' DESC ');
				$comma = ',';
			}
		}
		$s .= ($limit ? " LIMIT $start, $limit" : '');
		$sql = $s;
		defined('DEBUG') && DEBUG && isset($_SERVER['sqls']) && count($_SERVER['sqls']) < 1000 && $_SERVER['sqls'][] = htmlspecialchars(stripslashes($sql));// fixed: 此处导致的轻微溢出后果很严重，已经修正。
		$result = $this->rlink->query($sql);
		if(!$result) {
			return array();
		}
		$result->setFetchMode(PDO::FETCH_ASSOC);
		$return = array();
		$datalist = $result->fetchAll();
		foreach($datalist as $data) {
			$keyadd = '';
			foreach($keyname as $k) {
				$keyadd .= "-$k-".$data[$k];
			}
			$return[] = $table.$keyadd;
		}
		return $return;
	}
	
	public function index_create($table, $index) {
		$table = $this->tablepre.$table;
		$keys = implode(', ', array_keys($index));
		$keyname = implode('', array_keys($index));
		return $this->query("ALTER TABLE $table ADD INDEX $keyname($keys)");
	}
	
	public function index_drop($table, $index) {
		$table = $this->tablepre.$table;
		$keys = implode(', ', array_keys($index));
		$keyname = implode('', array_keys($index));
		return $this->query("ALTER TABLE $table DROP INDEX $keyname");
	}
	
	public function query($sql) {
		$n = $this->wlink->query($sql);
		defined('DEBUG') && DEBUG && isset($_SERVER['sqls']) && count($_SERVER['sqls']) < 1000 && $_SERVER['sqls'][] = htmlspecialchars(stripslashes($sql));// fixed: 此处导致的轻微溢出后果很严重，已经修正。
		return $n;
		/*
		if(!$result) {
			$error = $this->rlink->errorInfo();
			throw new Exception("Errno: $error[0] <br /> ".(isset($error[2]) ? "Errstr: $error[2]" : '')." <br />SQL: $sql");
		}*/
	}
	
	public function fetch_first($sql) {
		defined('DEBUG') && DEBUG && isset($_SERVER['sqls']) && count($_SERVER['sqls']) < 1000 && $_SERVER['sqls'][] = htmlspecialchars(stripslashes($sql));// fixed: 此处导致的轻微溢出后果很严重，已经修正。
		$result = $this->rlink->query($sql);
		if($result) {
			$result->setFetchMode(PDO::FETCH_ASSOC);
			return $result->fetch();
		} else {
			$error = $this->rlink->errorInfo();
			throw new Exception("Errno: $error[0], Errstr: $error[2]");
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
		$count = 0;
		try {
			$arr = $this->fetch_first("SELECT count FROM {$this->tablepre}framework_count WHERE name='$key'");
			$count = intval($arr['count']);
		} catch (Exception $e) {
			$this->query("CREATE TABLE {$this->tablepre}framework_count (
				`name` char(32) NOT NULL default '',
				`count` int(11) unsigned NOT NULL default '0',
				PRIMARY KEY (`name`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");
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
		list($table, $col) = explode('-', $key);
		$maxid = 0;
		try {
			$arr = $this->fetch_first("SELECT maxid FROM {$this->tablepre}framework_maxid WHERE name='$table'");
			$maxid = $arr['maxid'];
		} catch (Exception $e) {
			
			$r = $this->query("CREATE TABLE `{$this->tablepre}framework_maxid` (
				`name` char(32) NOT NULL default '',
				`maxid` int(11) unsigned NOT NULL default '0',
				PRIMARY KEY (`name`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci", $this->wlink);
			$arr = $this->fetch_first("SELECT MAX($col) as maxid FROM {$this->tablepre}$table");
			$maxid = $arr['maxid'];
			$this->query("REPLACE INTO {$this->tablepre}framework_maxid SET name='$table', maxid='$maxid'", $this->wlink);
		}
		return $maxid;
	}
	
	private function error($link) {    
		if($link->errorCode() != '00000') {    
			$error = $link->errorInfo();    
			return $error[2];    
		}
		return 0;
	}
	
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
		if($this->wlink) {
			$this->wlink = NULL;
		}
		if($this->rlink && $this->rlink != $this->wlink) {
			$this->rlink = NULL;
		}
	}
	
	public function version() {
		return '';// select version()
	}
	
}
?>