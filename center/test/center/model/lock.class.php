<?php
class lock extends base_model{
	function __construct() {
		parent::__construct();
		$this->table = 'lock';
		$this->primarykey = array('id');
		$this->maxcol = 'id';
		if(!empty($this->conf['lock_type'])){
			$this->conf['lock_type'] = 2;//默认内存表锁
		}
	}
	
	public function create($arr) {
		empty($arr['id']) && $arr['id'] = $this->maxid('+1');
		if($this->set($arr['id'], $arr)) {
			$this->count('+1');
			return $arr['id'];
		} else {
			$this->maxid('-1');
			return 0;
		}
	}
	
	public function update($uid, $arr) {
		return $this->set($uid, $arr);
	}
	
	public function read($uid) {
		return $this->get($uid);
	}

	//循环查询锁状态，直到数据解锁为止
	public function waiting_lock($tablename, $id){
		$lock_stuat = $this->get_lock($tablename, $id);
		if($lock_stuat >= 1){
			usleep(400000);
			return $this->waiting_lock($tablename, $id);
		}else{
			return 1;
		}
	}

	//获得锁的同时处理事务数，不包括等待中的事务请求
	public function get_lock($tablename, $id){
		if($this->conf['lock_type'] == 1){
			//暂时不考虑使用memcache锁
		}else if($this->conf['lock_type'] == 2){
			//MYSQL内存表锁
			$lock_list = $this->lock->index_fetch(array('did' => $id, 'tablename' => $tablename), array('id' => 1), 0, 1);
			if(!empty($lock_list)){
				list($k, $v) = each($lock_list);
				return $v['id'];
			}else{
				return 0;
			}
		}else{
			//文件锁
			$file = $this->conf['lock_path'].$tablename.'-'.$id.'.txt';
			if(file_exists($file)){
				return filesize($file);
			}else{
				return 0;
			}
		}
	}

	//解锁
	public function unlock($tablename, $id){
		set_time_limit(0);
		if($this->conf['lock_type'] == 1){
			//暂时不考虑使用memcache锁
		}else if($this->conf['lock_type'] == 2){
			//MYSQL内存表锁
			$lock_list = $this->lock->index_fetch(array('did' => $id, 'tablename' => $tablename), array('id' => 1), 0, 1000);
			if(count($lock_list) >= 1){
				foreach($lock_list as $k => $v){
					$this->lock->_delete($v['id']);
				}
			}
			return 1;
		}else{
			//文件锁
			$file = $this->conf['lock_path'].$tablename.'-'.$uid.'.txt';
			if(file_exists($file)){
				//删除锁文件
				unlink($file);
				return 1;
			}else{
				//没有锁存在
				return 2;
			}
		}
	}
	
	//锁，防止多次读取修改导致数据错误使用，不一定保证绝对唯一，但是防止一部分情况的重复，要害更新最好使用update检测，$handle_type = 1;//重复请求的三种处理方式，1=只处理第一条其他抛弃，2=全部处理，3=全部抛弃
	public function lock($tablename, $id, $handle_type = 1) {
		//防止意外死锁，执行时间只给30秒，超时前也够用了
		set_time_limit(30);
		if($this->conf['lock_type'] == 1){
			//暂时不考虑使用memcache锁
		}else if($this->conf['lock_type'] == 2){
			//MYSQL内存表锁
			$lock_stuat = $this->lock->total(array('did' => $id, 'tablename' => $tablename));
			if($lock_stuat == 0 or $handle_type == 2){
				$lock_data = array(
					'did' => $id,
					'tablename' => $tablename,
					'add_time' => time(),
				);
				$lock_id = $this->lock->create($lock_data);
				if($lock_id >= 1){
					//延迟0.3秒防止入库中的数据没有被查询到
					usleep(300000);
					$lock_top_id = $this->get_lock($tablename, $id);
					//echo $lock_id."|||".$lock_top_id."|||";
					if($handle_type == 1){
						if($lock_top_id == $lock_id){
							//echo $lock_top_id."||";
							return 1;
						}else{
							//$this->lock->_delete($lock_id);
							return 2;//不需处理数据，抛弃
						}
					}else if($handle_type == 2){
						return 1;
					}else{
						$this->lock->_delete($lock_id);
						return 2;//全部不处理数据，抛弃
					}
				}else{
					usleep(rand(300000, 1000000));
					return $this->lock->lock($tablename, $id);
				}
			}else if($handle_type == 1){
				//只处理第一条，其他抛弃
				return -1;//抛弃处理
			}else if($handle_type == 3){
				return -1;//全部抛弃
			}else{
				sleep(rand(300000, 1000000));
				return $this->lock->lock($tablename, $id);
			}
		}else{
			$file = $this->conf['lock_path'].$tablename.'-'.$id.'.txt';
			if(file_exists($file)){
				//使用随机间隔防止冲突
				sleep(rand(500000, 2000000));
				return $this->lock->lock($uid);
			}else{
				//使用追加方式追加，这样判断文件大小也可以知道同时的请求有多少
				file_put_contents($file, "1", FILE_APPEND);
				return $this->lock->get_lock($tablename, $id);
			}
		}
	}

	public function _delete($uid) {
		$return = $this->delete($uid);
		if($return) {
			$this->count('-1');
		}
		return $return;
	}
}
?>