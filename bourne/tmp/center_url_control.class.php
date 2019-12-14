<?php
!defined('FRAMEWORK_PATH') && exit('FRAMEWORK_PATH not defined.');
	include 'D:/laragon/www/tmp/control_common_control.class.php';

class url_control extends common_control
{


    public function on_ag()
    {
        $token = core::gpc("token",'G');
        if(empty($token))
        {
            echo json_encode(array(
                    "status" => 4444,
                    "message" => "非法操作",
                ));exit;
        }
       $this->c('url');
        $this->url->test();
    }





}
?>