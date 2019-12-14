<?php
!defined('FRAMEWORK_PATH') && exit('FRAMEWORK_PATH not defined.');
	include 'D:/laragon/www/tmp/control_common_control.class.php';

class bat_control extends common_control {

    function __construct() {
        parent::__construct();
    }

    //��������BAT�������ļ�
    public function on_update(){
        $cron_list = $bat_list = array();
        $cron_files = BBS_PATH;

        $bat_files = BBS_PATH."script/bat";
        if(!is_dir($cron_files) or !is_dir($bat_files)){
            echo "Ŀ¼������";exit;
        }


        $c_list = scandir($cron_files);
        foreach($c_list as $k => $v){
            $file_name = explode(".", $v);
            if(!empty($file_name[0]) && strpos($file_name[0],"data_") == 1)
            {
                if(!empty($file_name[1]) and $file_name[1] == 'php'  ){
                    $cron_list[$file_name[0]] = 1;
                }
            }
        }

        $b_list = scandir($bat_files);
        foreach($b_list as $k => $v){
            $file_name = explode(".", $v);
            if(!empty($cron_list[$file_name[0]])){
                unset($cron_list[$file_name[0]]);
            }else if(!empty($file_name[0]) and $file_name[0] != '1'){
                unlink($bat_files.'/'.$v);
            }
        }
        if(!empty($cron_list)){
            foreach($cron_list as $k => $v){
                $bat_info = $this->make_bat($k);
                file_put_contents($bat_files.'/'.$k.'.bat', $bat_info);
            }
            //$this->iconv_file($bat_files, 'utf-8', 'gbk');
        }
        echo "OK";exit;
    }

    //����ɾ��BATĿ¼�³������ļ�����ļ�
    public function del_bat(){
        $bat_files = BBS_PATH."bat";
        if(!is_dir($bat_files)){
            echo "Ŀ¼������";exit;
        }
        $b_list = scandir($bat_files);
        foreach($b_list as $k => $v){
            $file_name = explode(".", $v);
            if(!empty($file_name[0]) and $file_name[0] != '1'){
                unlink($bat_files.'/'.$v);
            }
        }
        echo "OK";exit;
    }

    //����BAT�������ļ�
    public function make_bat($name){
        /*  ����cmd�˿ڵ�
        if "%1" == "h" goto begin
        mshta vbscript:createobject("wscript.shell").run("""%~nx0"" h",0)(window.close)&&exit
        :begin
        REM*/
        $bat_info = '@echo off
        set n=0
        :abc
        set /a n+=1
        D:
        cd D:\phpStudy\PHPTutorial\php\php-5.6.27-nts
        echo  ��%n%�� >>  D:/phpStudy/PHPTutorial/WWW/script/logo/'.$name.'.txt
        php.exe '.BBS_PATH.$name.'.php  >>  D:/phpStudy/PHPTutorial/WWW/script/logo/'.$name.'.txt
        echo.  >>  D:/phpStudy/PHPTutorial/WWW/script/logo/'.$name.'.txt
        ping 127.0.0.1 -n 60 >nul
        goto abc';
        return $bat_info;
    }

    /**
     * ��һ���ļ�������ļ�ȫ��ת�� ֻ��תһ�� ����ȫ��������
     * @param string $filename
     */
    public function iconv_file($filename, $input_encoding='gbk', $output_encoding='utf-8'){
        if(file_exists($filename)){
            if(is_dir($filename)){
                foreach (glob("$filename/*") as $key=>$value){
                    $this->iconv_file($value, $input_encoding, $output_encoding);
                }
            }else{
                $contents_before = file_get_contents($filename);
                $contents_after = iconv($input_encoding,$output_encoding,$contents_before);
                file_put_contents($filename, $contents_after);
            }
        }else{
            echo '��������';
            return false;
        }
    }
}
?>