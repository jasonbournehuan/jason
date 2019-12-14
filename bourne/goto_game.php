<?php
class api_aes
{
    private static $aes_Key = "EqPEDFuJDRp7T8mdpauZF6FPWLrxieeJ";
    private static $aes_Method = "AES-128-ECB";
    private static $md5_Key = "uPP6287ZmsZg";
    private static $options = OPENSSL_RAW_DATA;

   static public function decrypt($str)
   {
       $result = openssl_decrypt(base64_decode($str),self::$aes_Method,self::$aes_Key,self::$options);
       return json_decode($result,true);
   }

   static public function md5_Encrypt($data)
   {
       return md5(json_encode($data).self::$md5_Key);
   }

    static public  function  cmd()
    {
      header("HTTP/1.1 404 Not Found");
      header("Status: 404 Not Found");
      exit;
    }

}

$code =  $_REQUEST["code"];
$sign = $_REQUEST["sign"];
if(empty($code) or empty($sign))
{
    api_aes::cmd();
}
$result = api_aes::decrypt($code);
if($sign !== api_aes::md5_Encrypt($result) || empty($result['game_id']) || empty($result['site_id']) || empty($result['msg']) || (time() - $result['timestamp'] > 30))
{
    api_aes::cmd();
}
?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="referrer" content="origin"/>
    <title></title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }
        body, html {
            width: 100%;
            height: 100%;
        }
    </style>
</head>
<body>
<iframe name="a_iframe" id="'a_iframe'" src="<?php echo $result['msg'];  ?>" marginwidth="0" marginheight="0" scrolling="no"
        frameborder="0" WIDTH="100%" height="100%"></iframe>
<script>
    let token= "<?php echo $result['token'];  ?>";
    let sid= "<?php echo $result['site_id'];  ?>";
    let gid= "<?php echo $result['game_id'];  ?>";
    let num = 0;
    var timer = setInterval(function () {
        let data = new URLSearchParams();
        ajaxPost('./api_heartbeat.html',data,function (res) {
            res = JSON.parse(res);
            if ((res.status == 1 && res.gid != gid) || res.status == -1) {
                top.window.close()
            }
        })
    }, 3000)
    function ajaxPost(url, data, fn) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", url, true);
        // 添加http头，发送信息至服务器时内容编码类型
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.setRequestHeader("Authorization", token);
        xhr.setRequestHeader("sid", sid);
        xhr.setRequestHeader("gid", gid);
//        xhr.setRequestHeader("sid", 1);
        xhr.timeout = 10000;
        xhr.ontimeout = function(event){
            alert('您的网络不稳定，可能出现风险，建议关闭游戏重新进入！');
        }
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200 ) {
                num = 0;
                fn.call(this, xhr.responseText);
            }else{
                ++num;
                if(num == 3){
                    alert('您的网络不稳定，可能出现风险，建议关闭游戏重新进入！');
                }
            }
        };
        xhr.send(data);
    }
</script>
</body>
</html>







 