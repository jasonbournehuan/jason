<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:82:"D:\phpStudy\PHPTutorial\WWW\kefu\public/../application/admin\view\login\index.html";i:1553376306;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>客服后台登录</title>
    <link href="__CSS__/login.css" type="text/css" rel="stylesheet">
	 <script>
        if(window.top!==window.self){window.top.location=window.location};
    </script>
</head>
<body>

<div class="login">
    <div class="message">客服管理登录</div>
    <div id="darkbannerwrap"></div>
    <input name="user_name" placeholder="用户名" type="text" id="user_name" autocomplete="off">
    <hr class="hr15">
    <input name="password" placeholder="密码" type="password" id="password">
    <hr class="hr15">
    <input name="captcha" placeholder="验证码" type="text" id="captcha-code" autocomplete="off">
    <div style="margin-top: 5px">
        <img src="<?php echo captcha_src(); ?>" alt="captcha" onclick="this.src=this.src" id="captcha" width="100%"/>
    </div>
    <hr class="hr15">
    <input value="登录" style="width:100%;" type="button" id="login">
    <hr class="hr20">
</div>
<script src="__JS__/jquery.min.js" type="text/javascript"></script>
<script src="__JS__/layui/layui.js" type="text/javascript"></script>

<script>
    document.onkeydown=function(event){
        var e = event || window.event || arguments.callee.caller.arguments[0];
        if(e && e.keyCode==13){ // enter 键
            doLogin();
        }
    };
    $(function(){

        $('#login').click(function(){
            doLogin();
        });
    });

    function doLogin(){
        var user_name = $("#user_name").val();
        var password = $("#password").val();
        var captcha = $("#captcha-code").val();

        layui.use('layer', function(){
            var layer = layui.layer;

            layer.ready(function(){
                if('' == user_name){
                    layer.tips('用户名不能为空', '#user_name');
                    return false;
                }

                if('' == password){
                    layer.tips('密码不能为空', '#password');
                    return false;
                }

                if('' == captcha){
                    layer.tips('验证码不能为空', '#captcha-code');
                    return false;
                }

                var index = layer.load(0, {shade: false});
                $.post("<?php echo url('login/doLogin'); ?>", {user_name: user_name, password: password, captcha: captcha}, function(res){
                    layer.close(index);
                    if(1 == res.code){
                        layer.msg(res.msg);
                        window.location.href = res.data;
                    }else{
                        $("#captcha").click();
                        return layer.msg(res.msg, {anim: 6, time: 1000});
                    }
                }, 'json');
            });
        });
    }
</script>
</body>
</html>