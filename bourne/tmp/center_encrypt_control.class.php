<?php
!defined('FRAMEWORK_PATH') && exit('FRAMEWORK_PATH not defined.');
	include 'D:/laragon/www/tmp/control_common_control.class.php';

class encrypt_control extends common_control
{


    public function on_is_access()
    {

        $code = core::gpc("code",'R');
        $timestamp = core::gpc("timestamp","R");
        $sign = core::gpc("sign","R");
        $this->c("api_aes");
        $result = $this->api_aes->decrypt($code);
        /*if($_SERVER['time'] - $timestamp > 30)
        {
            $this->cmd("Request time out");
        }*/
        if($sign !== $this->api_aes->md5_Encrypt($result))
        {
            $this->cmd("Signature error!");
        }
        if(empty($result['site_id']))
        {
           $this->cmd("site_id does not exist!");
        }
        if(empty($result['game_id']))
        {
            $this->cmd("game_id does not exist!");
        }
        if(empty($result['msg']))
        {
            $this->cmd("url does not exit!");
        }
       // include BBS_PATH."control/iframe.html";
        print_r($result);exit;




         /*$result = '{"status":1,"url":"www.web.com\/goto_game.htm?code=%2Bqt18ylaaYUdCdCE4eNWReVnRyRF8AlmYFtSJDh1MNGBrVFYvCk89qhe3hM0wDTmelrIhUEQ4GHLMW3TLNZF5gf0wXsp943pv%2BjDesL2qkibdnrCph2MEG%2FzbdlW7%2Fb%2BeVb1k%2Fpz4D7OH5DK4xf6aapFTGjwyeAcm07rGE1ShCqqD9LnZHSRtEygS1M%2FvZWXGUjKvDxx9YkGCdtikm5r92SpVm807hUFjjV5cyaQ%2B%2F2PPKVTTGES%2ByKQxvyMj7q4Rp4u1rjKGYgP0Fg4UCvI1OjuUCRO6BwJGeG1DmRR398DbfPou4kfT0I2cat2VaPa&timestamp=1571561954&sign=c1a2537c88f2c83ce3f7e71332f3e950","data":"","message":""}';
         $result = json_decode($result,true);
         if(isset($result['status']) &&  $result['status'] == 1  )
         {
            $str = substr($result['url'],strpos($result['url'],"?")+1);


         }*/

    }

    private function  cmd($str)
    {
        echo json_encode($str);exit;
    }


}