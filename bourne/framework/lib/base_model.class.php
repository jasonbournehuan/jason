<?php
/**

	架构统一了 各种 cache db 对外的接口。
	在开启 cache 的情况下：
		读取走 cache
		写入两份： cache & db
		
	// db
		$this->db_get();
		$this->db_set();
		$this->db_delete();
		$this->db->maxid();
		$this->db->count();
		
	// cache
		$this->cache_get();
		$this->cache_set();
		$this->cache_delete();
		$this->cache->maxid();
		$this->cache->count();
		
	// db + cache
		$this->db_cache_get();
		$this->db_cache_set();
		$this->db_cache_delete();
		$this->db_cache_maxid();
		$this->db_cache_count();
		$this->db_cache_index_fetch();
	
	// db + cache + modelname (需要设置 $this->table 表示哪个 model)， 在这一层，可以直接读取 db, cache ，但是不推荐。可以在此层连接索引服务
		$this->get();
		$this->set();
		$this->delete();
		$this->maxid();
		$this->count();
		$this->index_fetch();
	
	// db + cache + table + 业务逻辑 (最终提供给 control 层的方法) class xxx_model extends base_model {}
		$this->create();
		$this->update();
		$this->read();
		$this->_delete();
		$this->index_fetch();
		
*/
class base_model {

	// 当前应用的配置
	public $conf = array();			// 配置文件，包含各种选项，实际是全局的 $conf

	// 如果需要自动加载model，必须指定这三项！
	public $table;				// 用来标示 table
	public $primarykey = array();		// 主键中包含的字段，如 ('uid'), ('fid', 'uid')
	public $maxcol = '';			// 自增的列名字
	
	// 配置文件必须由配置文件指定
	
	static $dbinsts = array();		// 避免重复链接
	static $cacheinsts = array();		//
	
	private $unique;			// 唯一键数组，用来防止重复查询
	function __construct() {
		global $conf;
		$this->conf = &$conf;		// 此处不能引用，需要拷贝。因为多个model，可能每个model有自己的db, cache 服务器
		$this->shiwu = $this->shiwu_log = array();
	}

	function __get($var) {
		if($var == 'db') {
			$this->$var = $this->get_db_instance();
			return $this->$var;
		} elseif($var == 'cache') {
			$this->$var = $this->get_cache_instance();
			return $this->$var;
		} else {
			// 遍历全局的 conf，包含 model
			$this->$var = core::get_model($var, $this->conf);
			if(!$this->$var) {
				throw new Exception('未找到 model:'.$var);
			}
			return $this->$var;
		}
	}

	function __call($method, $parms) {
		throw new Exception("$method does not exists.");
	}
	
	// 多加一层 ----------------------> 用来按照条件分库分服务器
	
	// 重载此函数，用来分库，根据 key，分配到不同的 db server 上，实现任意分库，不过索引不好分，那样得做专门的索引服务器，跟存储分开。
	public function get_db_conf($key = '') {
		return $this->conf['db'];
	}
	
	// 这里都是一堆 hash 算法(php key 读取对应的是 C 的 hash 算法 )，对效率有那么一点点影响，不过 db 操作比较少，支持分布式以后这点损失微乎其微，所以可以忽略。
	public function get_db_instance($key = '') {
		$conf = $this->get_db_conf($key);
		$c = $conf[$conf['type']];
		$master = $c['master'];
		!isset($master['tablepre']) && $master['tablepre'] = '';
		!isset($master['name']) && $master['name'] = '';
		$conf['id'] = $master['host'].'-'.$master['user'].'-'.$master['password'].'-'.$master['name'].'-'.$master['tablepre'];
		if(isset(self::$dbinsts[$conf['id']])) {
			return self::$dbinsts[$conf['id']];
		} else {
			$type = $conf['type'];
			$dbname = 'db_'.$type;
			self::$dbinsts[$conf['id']] = new $dbname($conf[$type]);
			return self::$dbinsts[$conf['id']];
		}
	}
	
	public function db_set($key, $data) {
		return $this->get_db_instance($key)->set($key, $data);
	}
	
	public function db_add($key, $data) {
		return $this->get_db_instance('')->add($key, $data);
	}
	
	public function db_get($key) {
		return $this->get_db_instance($key)->get($key);
	}
	
	public function db_delete($key) {
		return $this->get_db_instance($key)->delete($key);
	}
	
	public function db_update($key, $data) {
		return $this->get_db_instance($key)->update($key, $data);
	}
	
	public function db_update1($key, $data) {
		return $this->get_db_instance($key)->update1($key, $data);
	}
	
	// 重载此函数，用来分布到不同的 cache server
	public function get_cache_conf($key = '') {
		return $this->conf['cache'];
	}
	
	public function get_cache_instance($key = '') {
		$conf = $this->get_cache_conf($key);
		$c = $conf[$conf['type']];
		$conf['id'] = $c['host'].'-'.$c['port'];
		if(isset(self::$cacheinsts[$conf['id']])) {
			return self::$cacheinsts[$conf['id']];
		} else {
			$type = $conf['type'];
			$cachename = 'cache_'.$type;
			self::$cacheinsts[$conf['id']] = new $cachename($conf[$type]);
			return self::$cacheinsts[$conf['id']];
		}
	}
	
	public function cache_set($key, $data) {
		return $this->get_cache_instance($key)->set($key, $data);
	}
	
	public function cache_add($key, $data) {
		return $this->get_cache_instance($key)->add($key, $data);
	}
	
	public function cache_get($key) {
		return $this->get_cache_instance($key)->get($key);
	}
	
	public function cache_delete($key) {
		return $this->get_cache_instance($key)->delete($key);
	}
	
	// -------------------------> 以下接口符合 db_interface & cache_interface 标准。在数据量小的情况下（数据表小于2G），直接开启可以起到很好的加速效果。
	
	public function db_cache_set($key, $data, $life = 0) {
		$this->conf['cache']['enable'] && $this->cache_set($key, $data, $life);	// 更新缓存
		return $this->db_set($key, $data);
	}

	public function db_cache_update1($key, $data, $life = 0) {
		$this->conf['cache']['enable'] && $this->cache_set($key, $data, $life);	// 更新缓存
		return $this->db_update1($key, $data);
	}

	public function db_cache_get($key) {
		if($this->conf['cache']['enable']) {
			$arr = $this->cache_get($key);
			if(!$arr) {
				$arrlist = $this->db_get($key);
				// 更新到 cache
				if(is_array($key)) {
					foreach((array)$arrlist as $k=>$v) {
						$this->cache_set($k, $v);
					}
				} else {
					$this->cache_set($key, $arrlist);
				}
				return $arrlist;
			} else {
				return $arr;
			}
		} else {
			return $this->db_get($key);
		}
	}

	public function db_cache_delete($key) {
		$this->conf['cache']['enable'] && $this->cache_delete($key);
		return $this->db_delete($key);
	}

	// $val == 0，返回最大ID，也可以为 +1
	public function db_cache_maxid($val = FALSE) {
		$key = $this->table.'-'.$this->maxcol;
		if($this->conf['cache']['enable']) {
			$this->cache->maxid($key, $val);	// 更新缓存
			return $this->db->maxid($key, $val);
		} else {
			return $this->db->maxid($key, $val);
		}
	}
	
	// 返回总行数，无法 +1
	public function db_cache_count($val = FALSE) {
		$key = $this->table;
		if($this->conf['cache']['enable']) {
			$this->cache->count($key, $val);
			return $this->db->count($key, $val);
		} else {
			return $this->db->count($key, $val);
		}
	}
	
	// todo: 如果数据分服务器，则索引存取可以考虑 map-reduce 模型，如何封装还未确定，还是业务逻辑自己处理？
	public function db_cache_index_fetch($table, $keyname, $cond = array(), $orderby = array(), $start = 0, $limit = 10) {
		// 判断类型，如果为 mongodb 则直接返回结果集，如果为 mysql ， 则先取ID，然后从memcached取
		if($this->conf['db']['type'] == 'mongodb') {
			return $this->db->index_fetch($table, $keyname, $cond, $orderby, $start, $limit);
		} else {
			if($this->conf['cache']['enable']) {
				$keynames = $this->db->index_fetch_id($table, $keyname, $cond, $orderby, $start, $limit);
				return $this->db_cache_get($keynames);
			} else {
				return $this->db->index_fetch($table, $keyname, $cond, $orderby, $start, $limit);
			}
		}
	}
	
	// -----------------------------> 提供更高层次的封装，所有符合标准的表结构都可以使用以下方法
	
	/*
		支持数组，注意格式，要分散到多个参数里，每个对应一个主键。
		get(123);
		get(1, 123);
		get(1, 2, 333);
		get(array(1, 2, 3));
		get(array(1, 10, 100), array(2, 20, 200), array(3, 30, 300));
	*/
	public function get($id1, $id2 = FALSE, $id3 = FALSE) {
		// 支持数组
		$keys= $this->get_key($id1, $id2, $id3);
		if(is_array($keys)) {
			// 这里顺序应该没有问题，按照key顺序预留了NULL值。
			$arrlist = array();
			foreach($keys as $k=>$key) {
				if(isset($this->unique[$key])) {
					$arrlist[$key] = $this->unique[$key];
					unset($keys[$k]);
				} else {
					$arrlist[$key] = NULL;
					$this->unique[$key] = $arrlist[$key];
				}
			}
			$arrlist2 = $this->db_cache_get($keys);
			$arrlist = array_merge($arrlist, $arrlist2);
			$this->shiwu_log += $arrlist;
			return $arrlist;
		} else {
			if(!isset($this->unique[$keys])) {
				$this->unique[$keys] = $this->db_cache_get($keys);
			}
			$this->shiwu_log[$keys] = $this->unique[$keys];
			return $this->unique[$keys];
		}
	}

	public function shiwu_start(){
		if(empty($this->conf['shiwu'])){
			throw new Exception('未开启事务模式！');
		}else if($this->conf['shiwu'] == 2){
			$this->db->shiwu_start();
		}else{
			$this->conf['shiwu'] = 1;
		}
	}

	public function shiwu_back(){
		if(empty($this->conf['shiwu'])){
			throw new Exception('未开启事务模式！');
		}else if($this->conf['shiwu'] == 2){
			$this->db->shiwu_back();
		}else{
			print_r($this->shiwu);
		}
	}
	
	/*
		// 类似于 c++ 重载，预留了三个主键的位置
		set(123, array('username'=>'zhangsan', 'email'=>'zhangsan@gmail.com'));
		set(1, 123, array('username'=>'zhangsan', 'email'=>'zhangsan@gmail.com'));
		set(1, 2, 123, array('username'=>'zhangsan', 'email'=>'zhangsan@gmail.com'));
	*/
	public function set($id1, $id2 = FALSE, $id3 = FALSE, $id4 = FALSE) {
		$arr = array();
		if($id4 !== FALSE) {
			$arr = $id4;
			$key = $this->get_key($id1, $id2, $id3);
		} elseif($id3 !== FALSE) {
			$arr = $id3;
			$key = $this->get_key($id1, $id2);
		} elseif($id2 !== FALSE) {
			$arr = $id2;
			$key = $this->get_key($id1);
		} else {
			return FALSE;
		}
		if(!empty($this->conf['shiwu'])){
			if(!empty($this->shiwu_log[$key])){
				$this->shiwu['update'][$key] = $this->shiwu_log[$key];
				$this->shiwu['log'][] = "update|".$key;
			}else{
				$this->shiwu['insert'][$key] = $arr;
				$this->shiwu['log'][] = "insert|".$key;
			}
		}
		$this->unique[$key] = $arr;
		return $this->db_cache_set($key, $arr);
	}

	public function update1($id1, $id2 = FALSE, $id3 = FALSE, $id4 = FALSE) {
		$arr = array();
		if($id4 !== FALSE) {
			$arr = $id4;
			$key = $this->get_key($id1, $id2, $id3);
		} elseif($id3 !== FALSE) {
			$arr = $id3;
			$key = $this->get_key($id1, $id2);
		} elseif($id2 !== FALSE) {
			$arr = $id2;
			$key = $this->get_key($id1);
		} else {
			return FALSE;
		}
		$this->unique[$key] = $arr;
		return $this->db_cache_update1($key, $arr);
	}

	public function update2($where, $data) {
		return $this->db->update2($this->table, $where, $data);
	}

	public function add($id1, $id2 = FALSE, $id3 = FALSE, $id4 = FALSE) {
		return $this->db_add($this->table.'-'.$this->maxcol.'-0', $id1);
	}
	
	public function shiwu() {
		print_r($this->shiwu_log);
		print_r($this->shiwu);
	}
	
	/*
		delete(1);
		delete(1, 2);
		delete(1, 2, 333);
	*/
	public function delete($id1, $id2 = FALSE, $id3 = FALSE) {
		$key = $this->get_key($id1, $id2, $id3);
		if(!empty($this->conf['shiwu'])){
			$arr = $this->get($key);
			$this->shiwu['delete'][$key] = $arr;
			$this->shiwu['log'][] = "delete|".$key;
		}
		unset($this->unique[$key]);
		return $this->db_cache_delete($key);
	}
	
	/*
	
		$this->user->maxid();
		$this->thread->maxid();
	*/
	public function maxid($val = FALSE) {
		return $this->db_cache_maxid($val);
	}
	
	// 自行计数的 count
	public function count($val = FALSE) {
		$key = $this->table;
		return $this->db_cache_count($val);
	}
	
	// 原生的 count
	public function native_count() {
		return $this->db->native_count($this->table);
	}
	
	public function native_maxid() {
		return $this->db->native_maxid($this->table, $this->maxcol);
	}
	
	public function all_update($key = '', $data = array()) {
		if(empty($key)){
			$key = $this->primarykey[0];
		}
		return $this->db->all_update($this->table, $key, $data);
	}
	
	public function total($where) {
		return $this->db->total($this->table, $where);
	}
	
	public function sum($where, $field) {
		return $this->db->sum($this->table, $where, $field);
	}
	
	public function group($where, $field, $fields, $start = 0, $limit = 0) {
		return $this->db->group($this->table, $where, $field, $fields, $start, $limit);
	}
	
	public function add_list($data) {
		return $this->db->add_list($this->table, $data);
	}
	
	public function index_fetch($cond = array(), $orderby = array(), $start = 0, $limit = 10) {
		return $this->db_cache_index_fetch($this->table, $this->primarykey, $cond, $orderby, $start, $limit);	
	}
	
	public function index_fetch_id($cond = array(), $orderby = array(), $start = 0, $limit = 10, $keyname = '') {
		if(!empty($keyname)){
			$keyname = (array)$keyname;
			$sqladd = implode(',', $keyname);
		}else{
			$sqladd = $this->primarykey;
		}
		return $this->db->index_fetch_id($this->table, $sqladd, $cond, $orderby, $start, $limit);	
	}
	
	public function index_fetch_sql($cond = array(), $orderby = array(), $start = 0, $limit = 10, $keyname = '') {
		if(!empty($keyname)){
			$keyname = (array)$keyname;
			$sqladd = implode(',', $keyname);
		}else{
			$sqladd = $this->primarykey;
		}
		return $this->db->index_fetch_sql($this->table, $sqladd, $cond, $orderby, $start, $limit);	
	}
	
	public function outfile($cond = array(), $orderby = array(), $start = 0, $limit = 10, $keyname = '', $file = '') {
		if(!empty($keyname)){
			$keyname = (array)$keyname;
			$sqladd = implode(',', $keyname);
		}else{
			$sqladd = '*';
		}
		return $this->db->outfile($this->table, $sqladd, $cond, $orderby, $start, $limit, $file);	
	}
	
	// 约定数据库中只能存 int 和 string，不能存FALSE类型的数据
	private function get_key($id1, $id2 = FALSE, $id3 = FALSE) {
		// 这里可能不太符合少数情况，姑且这么约定。第一行不为整形，则认为是自定义KEY
		if(is_array($id1)) {
			$keys = array();
			foreach($id1 as $k=>$v) {
				$keys[$k] = $this->get_key_real($id1[$k], ($id2 === FALSE ? FALSE : $id2[$k]), ($id3 === FALSE ? FALSE : $id3[$k]));
			}
			return $keys;
		} else {
			return $this->get_key_real($id1, $id2, $id3);
		}
	}
	
	private function get_key_real($id1, $id2 = FALSE, $id3 = FALSE) {
		if(strpos($id1, '-') !== FALSE) {
			return $id1;
		} else {
			$s = $this->table.'-'.$this->primarykey[0]."-$id1";
			$id2 !== FALSE && $s .= "-".$this->primarykey[1]."-$id2";
			$id3 !== FALSE && $s .= "-".$this->primarykey[2]."-$id3";
			return $s;
		}
	}
	
	public function c($class = '') {
		$this->$class = core::c($class);
		return $this->$class;
	}
	
	public function m($model = '') {
		$this->$model = core::m($model);
		return $this->$model;
	}
	
}
?>