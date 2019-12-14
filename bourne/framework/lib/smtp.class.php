<?php

class smtp{
	//smtp主机地址
	protected $host;
	//用户名
	protected $user;
	//密码
	protected $psw;
	//端口
	protected $smtpport=25;
	//发送人名称
	public $sender =false;
	//接受人名称
	public $receiver = false;
	//发送人地址
	public $from;
	//接受人地址
	public $to;
	//信件标题
	public $subject;
	//信件内容
	public $content;
	//邮件等级 h - high	n - normal	l - low
	public $priority='n';
	//HTML支持
	public $HTMLsupport=true;
	//字符集
	public $charset="gb2312";
	//附件,字符串
	protected $document=false;
	//错误号
	public $errno;
	//错误描述
	public $error;
	//错误步骤
	public $step;
	//SMTP链接
	protected $fp;

	//构造
	public function __construct($host,$user,$psw,$port=25){
		$this->host = $host;
		$this->port = $port;
		$this->user = $user;
		$this->psw = $psw;
		$this->connect();
		if($this->errno!=250){
			die($this->report());
		}
		//设置流资源的超时时间!0.5秒!避免fgets函数操作搁置,导致脚本超时!
		stream_set_timeout($this->fp,null,500000);
	}

	//析构
	public function __destruct(){
		@fclose($this->fp);
	}

	//发送
	public function send(){
		$error = '';
			//寄件地址设定
			if($this->errno==250){
				fwrite($this->fp, "mail from: <".$this->from.">\n");
				$this->smtpInfo();
			}else{
				return $this->onError("邮件发送!");
			}
			//收件地址设定
			if($this->errno==250){
				$tos = explode(";",$this->to);
				foreach($tos as $to){
					fwrite($this->fp, "rcpt to: <".$to.">\n");
					$this->smtpInfo();
					//只要有一个通过,就可以发信了,下面用的是$mailto_errno作为$this->errno验证;
					if($this->errno==250){
						$errno = $this->errno;
						$error .= "发送到 <b>".$to."</b> 的信件成功!<br />\n";
					}else{
						$error .= "发送到 <b>".$to."</b> 的信件地址存在问题!<br />\n";
					}
				}
			}else{
				return $this->onError("发件地址认证");
			}
			//写邮件指令
			if($this->errno==250){
				fwrite($this->fp, "data\n");
				$this->smtpInfo();
				if($this->errno==354)
					$this->errno=250;
			}else{
				return $this->onError("收件地址认证");
			}
			//写邮件过程
			if($this->errno==250){
				$this->writeMail();
			}else{
				return $this->onError("写邮件指令");
			}
			//结果
			if($this->errno==250){
				//$this->send_result = $error;
				return true;
			}else{
				return $this->onError("写邮件过程");
			}
			//@fclose($this->fp);
	}

	//连接
	protected function connect(){
		$this->fp = @fsockopen($this->host, $this->port, $this->errno, $this->error, 15);
		if (!$this->fp){
			return $this->onError("尝试打开到SMTP服务器:' ".$smtphost." '的连接");
		}else{
			//验证用户有效性
			$this->smtpInfo();
			fwrite($this->fp, "helo ".$this->user."\n");
			$this->smtpInfo();
			//输入登录指令
			if($this->errno==250){
				fwrite($this->fp, "auth login\n");
				$this->smtpInfo();
				if($this->errno==334)
					$this->errno=250;
			}else{
				return $this->onError("用户有效性验证");
			}
			//用户名64位编码输入
			if($this->errno==250){
				fwrite($this->fp, (base64_encode($this->user))."\n");
				$this->smtpInfo();
				if($this->errno==334){
					$this->errno=250;
				}
			}else{
				return $this->onError("登录指令输入");
			}
			//密码64位编码输入
			if($this->errno==250){
				fwrite($this->fp, (base64_encode($this->psw))."\n");
				$this->smtpInfo();
				if($this->errno==235){
					$this->errno=250;
				}
			}else{
				return $this->onError("用户名验证");
			}
		}
	}
	//添加附件
	public function addDocument($filename){
		if(!file_exists($filename)){
			$this->onError('附件插入',601,'文件 "'.$filename.'" 不存在!');
			$this->report();
			exit;
		}else{
			$basename = basename($filename);
		}
		$headers .= 'Content-Type: '.$this->fileMime($basename).';'."\n";
		$headers .= 'Content-Transfer-Encoding: base64'."\n";
		$headers .= 'Content-Disposition: attachment;filename="'.$basename.'"'."\n\n";
		$file = $this->fileEncode($filename);
		$this->document = $headers.$file;
	}
	//返回附件Mime名
	protected function fileMime($filename){
		$mime = array(
			'php'=>'text/plain',
			'txt'=>'text/plain',
			'asc'=>'text/plain',
			'html'=>'text/plain',
			'htm'=>'text/plain',
			'js'=>'text/plain',
			'css'=>'text/plain',
			'asp'=>'text/plain',
			'java'=>'text/plain',
			'xml'=>'text/plain',
			'xsl'=>'text/plain',
			'wml'=>'text/plain',
			'wmls'=>'text/plain',
			'bin'=>'application/octet-stream',
			'dms'=>'application/octet-stream',
			'lha'=>'application/octet-stream',
			'lzh'=>'application/octet-stream',
			'exe'=>'application/octet-stream',
			'class'=>'application/octet-stream',
			'dll'=>'application/octet-stream',
			'so'=>'application/octet-stream',
			'dmg'=>'application/octet-stream',
			'doc'=>'application/msword',
			'xls'=>'application/vnd.ms-excel',
			'ppt'=>'application/vnd.ms-powerpoint',
			'pdf'=>'application/pdf',
			'rar'=>'application/rar',
			'zip'=>'application/zip',
			'tar'=>'application/x-tar',
			'gtar'=>'application/x-gtar',
			'gz'=>'application/x-gzip',
			'mid'=>'audio/midi',
			'midi'=>'audio/midi',
			'mp2'=>'audio/mpeg',
			'mp3'=>'audio/mpeg',
			'ram'=>'audio/x-pn-realaudio',
			'ra'=>'audio/x-pn-realaudio',
			'rm'=>'application/vnd.rn-realmedia',
			'rmvb'=>'application/vnd.rn-realmedia',
			'wav'=>'audio/x-wav',
			'bmp'=>'image/bmp',
			'gif'=>'image/gif',
			'jpg'=>'image/jpeg',
			'jpeg'=>'image/jpeg',
			'jpe'=>'image/jpeg',
			'png'=>'image/png',
			'ico'=>'image/x-icon',
			'avi'=>'video/x-msvideo'
		);
		$filename = explode('.',$filename);
		$extname = strtolower($filename[count($filename)-1]);
		if(empty($mime[$extname])){
			return 'application/unknow';
		}else{
			return $mime[$extname];
		}

	}
	//附件编码
	protected function fileEncode($filename){
		$handle = fopen($filename,'r+');
		$fContent = fread($handle,filesize($filename));
		fclose($handle);
		return chunk_split(base64_encode($fContent));
	}

	//发生错误时
	protected function onError($step,$errno=NULL,$error=NULL){
		if(!is_NULL($errno))
			$this->errno = $errno;
		if(!is_NULL($error))
			$this->error = $error;
		$this->step = $step;
		@fclose($this->fp);
		return false;
	}

	//输出报告
	public function report(){
		echo $this->makeReport();
	}
	
	public function close() {
		@fclose($this->fp);
		return true;
	}

	//生成报告!
	protected function makeReport(){
		return "<b>出 错 啦!</b><br />
			<b>错误步骤:</b>".$this->step."<br />
			<b>错误代码:</b>".$this->errno."<br />
			<b>错误描述:</b>".$this->error."<br />";
	}

	//获取SMTP信息!
	protected function smtpInfo(){
		$content = fgets($this->fp, 200);
		$this->errno = intval(substr($content,0,3));
		$this->error = substr($content,4,200);
	}

	//写信件
	protected function writeMail(){
		$header = '';
		$time = gmdate('D, j M Y G:i:s');
		//分隔符
		$cutter = uniqid('-=NextMailPart');
		$pri = array('h'=>1,'n'=>3,'l'=>5);
		if(!$this->sender){
			list($sender) = explode('@',$this->from);
		}else{
			$sender = $this->sender;
		}
		if(!$this->receiver){
			list($receiver) = explode('@',$this->to);
		}else{
			$receiver = $this->receiver;
		}
		$header.= 'From: '.$sender.' '.$this->from."\n";
		$header.= 'To: '.$receiver.' '.$this->to."\n";
		$header.= "Date: $time +0800\n";
		$header.= "Subject: ".$this->subject."\n";
		$header.= "X-Priority: {$pri[$this->priority]}\n";
		$header.= "MIME-Version: 1.0\n";
		$header.= 'Content-Type: Multipart/Mixed; Boundary="'.$cutter.'"'."\n\n";
		$cutter = '--'.$cutter;
		$header.= $cutter."\n";
		if(!$this->HTMLsupport){
			$header.= "Content-Type: text/plain;charset=".$this->charset.";\n";
		}else{
			$header.= "Content-Type: text/html;charset=".$this->charset.";\n";
		}
		$mail = $header."\n".$this->content."\n";
		if($this->document){
			$mail .= $cutter."\n";
			$mail .= $this->document;
		}
		$mail .= $cutter.'--';
		//echo '<pre>'.$mail.'</pre>';
		fwrite($this->fp,$mail."\n.\n");
		$this->smtpInfo();
	}
}
?>