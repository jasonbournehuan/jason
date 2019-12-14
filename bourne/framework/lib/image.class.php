<?php
class image {
	// 安全缩略，按照ID存储
	/*
		$arr = safe_thumb('abc.jpg', 123, '.jpg', BBS_PATH.'upload/', 100, 100);
		array(
			'filesize'=>1234,
			'width'=>100,
			'height'=>100,
			'fileurl' => '001/0123/1233.jpg'
		);
	*/
	public static function safe_thumb($sourcefile, $id, $ext, $dir1, $forcedwidth, $forcedheight) {
		$dir2 = self::set_dir($id, $dir1.'/');
		$filepath = "$dir1/$dir2/$id$ext";
		$arr = self::thumb($sourcefile, $filepath, $forcedwidth, $forcedheight);
		$arr['fileurl'] = "$dir2/$id$ext";
		return $arr;
	}

	/** 
		实例：
	 	thumb(APP_PATH.'xxx.jpg', APP_PATH.'xxx_thumb.jpg', 200, 200);
	 	
	 	返回：
	 	array('filesize'=>0, 'width'=>0, 'height'=>0)
	 */
	public static function thumb($sourcefile, $destfile, $forcedwidth = 80, $forcedheight = 80) {
		$return = array('filesize'=>0, 'width'=>0, 'height'=>0);
		$imgcomp = 25;
		$destext = strtolower(substr(strrchr($destfile, '.'), 1));
		if(!in_array($destext, array('gif', 'jpg', 'bmp', 'png'))) {
			return $return;
		}
	
		$imgcomp = 100 - $imgcomp;
		$imginfo = getimagesize($sourcefile);
		$src_width = $imginfo[0];
		$src_height = $imginfo[1];
		if($src_width == 0 || $src_height == 0) {
			return $return;
		}
		$src_scale = $src_width / $src_height;
		$des_scale = $forcedwidth / $forcedheight;
		
		if(!function_exists('imagecreatefromjpeg')) {
			copy($sourcefile, $destfile);
			$return = array('filesize'=>filesize($destfile), 'width'=>$src_width, 'height'=>$src_height);
			return $return;
		}
	
		// 按规定比例缩略
		if($src_width <= $forcedwidth && $src_height <= $forcedheight) {
			$des_width = $src_width;
			$des_height = $src_height;
		} elseif($src_scale >= $des_scale) {
			$des_width = ($src_width >= $forcedwidth) ? $forcedwidth : $src_width;
			$des_height = $des_width / $src_scale;
			$des_height = ($des_height >= $forcedheight) ? $forcedheight : $des_height;
		} else {
			$des_height = ($src_height >= $forcedheight) ? $forcedheight : $src_height;
			$des_width = $des_height * $src_scale;
			$des_width = ($des_width >= $forcedwidth) ? $forcedwidth : $des_width;
		}
	
		switch ($imginfo['mime']) {
			case 'image/jpeg':
				$img_src = imagecreatefromjpeg($sourcefile);
				!$img_src && $img_src = imagecreatefromgif($sourcefile);
				break;
			case 'image/gif':
				$img_src = imagecreatefromgif($sourcefile);
				!$img_src && $img_src = imagecreatefromjpeg($sourcefile);
				break;
			case 'image/png':
				$img_src = imagecreatefrompng($sourcefile);
				break;
			case 'image/wbmp':
				$img_src = imagecreatefromwbmp($sourcefile);
				break;
			default :
				return $return;
		}
	
		$img_dst = imagecreatetruecolor($des_width, $des_height);
		$img_color = imagecolorallocate($img_dst, 255, 255, 255);
		imagefill($img_dst, 0, 0 ,$img_color);
		imagecopyresampled($img_dst, $img_src, 0, 0, 0, 0, $des_width, $des_height, $src_width, $src_height);
	
		switch($destext) {
			case 'jpg': imagejpeg($img_dst, $destfile, $imgcomp); break;
			case 'gif': imagegif($img_dst, $destfile, $imgcomp); break;
			case 'png': imagepng($img_dst, $destfile, version_compare(PHP_VERSION, '5.1.2') == 1 ? 7 : 70); break;
		}
		imagedestroy($img_dst);
		return array('filesize'=>filesize($destfile), 'width'=>$des_width, 'height'=>$des_height);;
	}
	
	// 获取安全的文件名，如果文件存在，则加时间戳和随机数，避免重复
	public static function safe_name($filename, $dir) {
		// 最后一个 . 保留，其他的 . 替换
		$s1 = substr($filename, 0, strrpos($filename, '.'));
		$s2 = substr(strrchr($filename, '.'), 1);
		$s1 = preg_replace('#\W#', '_', $s1);
		$s2 = preg_replace('#\W#', '_', $s2);
		if(is_file($dir."$s1.$s2")) {
			$newname = $s1.core::gpc('time', 'S').rand(1, 1000).'.'.$s2;
		} else {
			$newname = "$s1.$s2";
		}
		return $newname;
	}
	
	// 缩略图的名字
	public static function thumb_name($filename) {
		return substr($filename, 0, strrpos($filename, '.')).'_thumb'.strrchr($filename, '.');
	}
	
	// 随即文件名
	public static function rand_name($k) {
		return core::gpc('time', 'S').'_'.rand(1000000000, 9999999999).'_'.$k;
	}
	
	/*
		实例：
		set(123, APP_PATH.'upload');
		
		000/000/1.jpg
		000/000/100.jpg
		000/000/100.jpg
		000/000/999.jpg
		000/001/1000.jpg
		000/001/001.jpg
		000/002/001.jpg
	*/
	public static function set_dir($id, $dir) {

		$id = sprintf("%09d", $id);
		$s1 = substr($id, 0, 3);
		$s2 = substr($id, 3, 3);
		$dir1 = $dir.$s1;
		$dir2 = $dir."$s1/$s2";

		!is_dir($dir1) && mkdir($dir1);
		!is_dir($dir2) && mkdir($dir2);
		return "$s1/$s2";
	}

	// 取得 user home 路径
	public static function get_dir($id) {
		$id = sprintf("%09d", $id);
		$s1 = substr($id, 0, 3);
		$s2 = substr($id, 3, 3);
		return "$s1/$s2";
	}
	/** 
	 * 图片裁切
	 *
	 * @param string $srcname	原图片路径(绝对路径/*.jpg)
	 * @param string $forcedheight 	裁切后生成新名称(绝对路径/rename.jpg)
	 * @param int $sourcefile 	被裁切图片的X坐标
	 * @param int $destfile 	被裁切图片的Y坐标
	 * @param int $destext 		被裁区域的宽度
	 * @param int $imgcomp 		被裁区域的高度
	image::clip_img('XXX/X.JPG', 'XXX/NEWX.JPG', 10, 40, 150, 150)
	 */
	public static function clip ($sourcefile, $destfile, $clipx, $clipy, $clipwidth, $clipheight) {
		$getimgsize = getimagesize($sourcefile);
		if(empty($getimgsize)) {
			return 0;
		} else {
			$imgwidth = $getimgsize[0];
			$imgheight = $getimgsize[1];
			if($imgwidth == 0 || $imgheight == 0) {
				return 0;
			}
		}
		
		if(!function_exists('imagecreatefromjpeg')) {
			copy($sourcefile, $destfile);
			$return = array('filesize'=>filesize($destfile), 'width'=>$src_width, 'height'=>$src_height);
			return $return;
		}
		switch($getimgsize[2]) {
			case 1 :
			$imgcolor = imagecreatefromgif($sourcefile);
			break;
			case 2 :
			$imgcolor = imagecreatefromjpeg($sourcefile);
			break;
			case 3 :
			$imgcolor = imagecreatefrompng($sourcefile);
			break;
		}
		//$imgcolor = imagecreatefromjpeg($sourcefile);
		$img_dst = imagecreatetruecolor($clipwidth, $clipheight);
		$img_color = imagecolorallocate($img_dst, 255, 255, 255);
		imagefill($img_dst, 0, 0, $img_color);
		imagecopyresampled($img_dst, $imgcolor, 0, 0, $clipx, $clipy, $imgwidth, $imgheight, $imgwidth, $imgheight);
		imagejpeg($img_dst, $destfile, 100);
		return filesize($destfile);
	}
}
//image::thumb('D:/image/IMG_0433.JPG', 'd:/image/xxx.gif');
?>