<?php
/*
	[代码就是文档！]
	
	什么是 db.interface.php 呢，它是一个DB的接口规范的定义。 听起来很抽象，其实就是你不用关心 db_mysql.class.php db_pdo.class.php db_mongodb.class.php ... 的实现。
	只需要知道这个接口的参数怎么传，返回的结果是什么即可，那些类里面都会乖乖的实现这几个方法。
	
	比如我们要操作 mysql:
	
	// 配置数据库的相关信息，这里支持主从多台MySQL，为了做演示，我们只配置一台。
	$dbconf = array(
		'type'=>'mysql',
		'mysql' => array (
			// 主 MySQL Server
			'master' => array (
					'host' => '127.0.0.1',
					'user' => 'root',
					'password' => 'root',
					'name' => 'test',
					'charset' => 'utf8',
					'tablepre' => 'xn_',
					'engine'=>'MyISAM',
			),
			// 从 MySQL Server
			'slaves' => array (
			)
		)
	);
	
	// 实例化
	$db = new db_mysql($dbconf);
	
	// 开始操作DB
	
	// 取一条记录, uid 为主键名字，这里有个约定，第一列为表名，后面的为 字段名-字段值 这样成对出现
	$user = $db->get("user-uid-$uid");
	
	

*/
if(!defined('FRAMEWORK_PATH')) {
	exit('FRAMEWORK_PATH not defined.');
}

interface db_interface {

	public function __construct($conf);

	public function set($key, $data, $life = 0);

	public function get($key);

	public function delete($key);

	/**
	 * 
	 * maxid('user-uid') 返回 user 表最大 uid
	 * maxid('user-uid', '+1') maxid + 1, 占位，保证不会重复
	 * maxid('user-uid', 10000) 设置最大的 maxid 为 10000
	 *
	 */
	public function maxid($table, $val = 0);
	
	// $val == 0, 返回总行数， > 1 ，设置总行数
	public function count($table, $val = 0);
	
	// 原生的API，准确，但速度慢，仅仅在统计或者同步的时候调用。
	public function native_maxid($table, $col);
	
	// 原生的API，准确，但速度慢，仅仅在统计或者同步的时候调用。
	public function native_count($table);
	
	// 清空一个表
	public function truncate($table);
	
	// 获取版本
	public function version();
	
	// ---------------------> 以下三个方法为索引支持部分，不建议使用，强烈建议使用其他方案代替，比如 Service。
	/**
		这是一个比较复杂的方法，用来支持条件取id，支持翻页:
		实例：
			index_fetch('user', 'uid', array('uid' => array('>'=>123)), array(), '', 0, 10);
			等价于：SELECT * FROM user WHERE uid>123 LIMIT 0, 10
			
			index_fetch('user', 'uid', array('regdate' => array('>' => 123456789)), array('uid'=>-1), 0, 10);
			等价于：SELECT * FROM user WHERE regdate > 123456789 ORDER BY uid DESC LIMIT 0, 10
			
			index_fetch('user', 'uid', array('regdate'=> array('>'=>123456789), 'groupid' =>1), array('uid' => -1, 'groupid' => 1), 0, 10);
			等价于：SELECT * FROM user where regdate > 123456789 AND groupid = 1 ORDER BY uid DESC groupid ASC LIMIT 0, 10
			
			index_fetch('user', 'uid', array('username'=>array('LIKE'=>'admin')), array(), 0, 10);
			等价于：SELECT * FROM user WHERE username LIKE '%admin%';
	*/
	// 返回ID
	public function index_fetch($table, $keyname, $cond = array(), $orderby = array(), $start = 0, $limit = 0);
	
	// 返回结果集
	public function index_fetch_id($table, $keyname, $cond = array(), $orderby = array(), $start = 0, $limit = 0);
	
	/**
		index: 1 正序，-1 倒序
		保留：$index = array('unique'=>TRUE, 'dropDups'=>TRUE) // 针对 Mongodb 有效
		例如：
			index_create('user', array('uid'=>1, 'dateline'=>-1));
			index_create('user', array('uid'=>1, 'dateline'=>-1, 'unique'=>TRUE, 'dropDups'=>TRUE));
	*/
	public function index_create($table, $index);
	
	public function index_drop($table, $index);
	
	// 不提供批量删除，批量更新的接口。一条一条的更新和删除，有利于缓存。如果十分需要，直接调用API吧。
	
}

/*
	用法：
	
	$dbconf = array(
		'type'=>'mysql',
		'mysql' => array (
			// 主 MySQL Server
			'master' => array (
					'host' => '127.0.0.1',
					'user' => 'root',
					'password' => 'root',
					'name' => 'test',
					'charset' => 'utf8',
					'tablepre' => 'xn_',
					'engine'=>'MyISAM',
			),
			// 从 MySQL Server
			'slaves' => array (
			)
		)
	);
	
	$db = new db_mysql($dbconf);
	
	// 取一条记录, uid 为主键名字
	$user = $db->get("user-uid-$uid");
	
	// 增加一条记录， +1 避免重复
	$uid = $db->maxid('user-uid', '+1');
	$db->set("user-uid-$uid", array('username'=>'admin', 'email'=>'xxx@xxx.com'));
	
	// 存一条记录，覆盖写入
	$db->set("user-uid-$uid", array('username'=>'admin', 'email'=>'xxx@xxx.com'));
	
	// 删除一条记录
	$db->delete("user-uid-$uid");
	
	// 翻页取数据
	$userlist = $db->index_fetch('user', 'uid', array('groupid' => 1), array(), 0, 10);
	$userlist = $db->index_fetch('user', 'uid', array('uid' => array('>', 123)), array(), 0, 10);
	
	// 取记录总数
	$db->count('user');
	
	// 遍历
	$uid = $db->maxid('user-uid');  // 取最大的UID
	$uids = array();
	for($i=0; $i<$uid; $i++) $uids[] = $i;
	$userlist = $db->get($uids);
	
*/

?>