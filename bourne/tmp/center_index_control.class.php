<?php
!defined('FRAMEWORK_PATH') && exit('FRAMEWORK_PATH not defined.');
	include 'D:/laragon/www/tmp/control_common_control.class.php';

class index_control extends common_control
{
    function __construct()
    {
        parent::__construct();
    }

    public function on_index()
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
        $this->url->get_url($token);
    }





}
?>