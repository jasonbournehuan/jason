<?php
if(!defined('FRAMEWORK_PATH')) {
	exit('FRAMEWORK_PATH not defined.');
}

interface cache_interface {

	public function __construct($conf);
	
	public function set($key, $data, $life = 0);

	public function get($key);

	public function delete($key);
	
	// $val == 0，返回最大ID，也可以为 +1
	public function maxid($table, $val = 0);
	
	// $val == 0 返回总行数，也可以为 +1
	public function count($table, $val = 0);
	
	//public function flush();
}

/*
	用法：
	$conf = array (
		'enable'=>TRUE,
		'type'=>'memcache',
		'memcache'=>array (
			'host'=>'127.0.0.1',
			'port'=>'11211',
		)
	);
	$cache = new cache_memcache($conf);
	
	// 取一条记录
	$user = $cache->get("user-uid-$uid");
	
	// 增加一条记录:
	$uid = $cache->maxid('user');
	$cache->set("user-uid-$uid", array('username'=>'admin', 'email'=>'xxx@xxx.com'));
	$cache->maxid('user', '+1');
	
	// 存一条记录，覆盖写入
	$cache->set("user-uid-$uid", array('username'=>'admin', 'email'=>'xxx@xxx.com'));
	
	// 删除一条记录
	$cache->delete("user-uid-$uid");
	
	// 遍历
	$uid = $cache->maxid('user');  // 取最大的UID
	$uids = array();
	for($i=0; $i<$uid; $i++) $uids[] = $i;
	$userlist = $cache->get($uids);
	
	// 取记录总数
	$cache->count('user');

	// 清除所有记录
	$cache->flush();
*/

?>