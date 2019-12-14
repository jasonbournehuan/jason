<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:83:"D:\phpStudy\PHPTutorial\WWW\kefu\public/../application/index\view\index\mobile.html";i:1554818417;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>客服移动端</title>
    <link href="/static/service/js/layui/css/layui.css" rel="stylesheet" type="text/css"/>
    <link href="/static/service/js/layui/css/layui.mobile.css" rel="stylesheet"/>
    <link href="/static/service/js/layui/css/modules/layim/mobile/layim.css" rel="stylesheet"/>
    <style>
        .praise-box{display:none;width: 160px;height:90px;box-shadow:1px 1px 50px rgba(0,0,0,.3);;padding: 5px;left: 10px;position: relative;z-index:8991100}
    </style>
</head>
<body>
<div class="layim-panel layui-m-anim-left">
    <div class="layim-title" style="background-color: #36373C;">
        <p><i class="layui-icon layim-chat-back" onclick="loginOut()">&#xe603;</i> <span id="title">客服</span></p>
    </div>
    <div class="layui-unselect layim-content" id="chat-box">
        <div class="layim-chat layim-chat-friend">
            <div class="layim-chat-main">
                <ul id="chat-list">

                </ul>
            </div>
            <div class="layim-chat-footer">
                <div class="layim-chat-send">
                    <input type="text" autocomplete="off" id="msg"/>
                    <button class="layim-send layui-disabled" id="send">发送</button>
                </div>
                <div class="layim-chat-tool">
                    <span class="layui-icon layim-tool-face" title="选择表情" id="up-face">&#xe60c;</span>
                    <span class="layui-icon layim-tool-image" title="上传图片" id="up-image">&#xe60d;</span>
                    <span class="layui-icon layim-tool-image" title="点赞" id="praise">&#xe6c6;</span>
                    <!--<span class="layui-icon layim-tool-image" title="发送文件"></span>-->
                </div>
            </div>
        </div>
    </div>
</div>

<div class="layui-m-layerchild layim-layer layui-m-anim-scale">
    <div class="layui-m-layercont" style="display:none;padding:0" id="face-box">

    </div>
</div>

<div class="praise-box" id="appraise">
    <p>给客服评价： </p>
    <div id="star"></div><br/>
    <button class="layui-btn layui-btn-xs" style="float: right;background: #01AAED" id="do-praise">确定</button>
</div>

<div style="height: 60%;width: 80%;top: 20%;left: 10%;position: absolute; display: none" id="leave-box">
    <form class="layui-form layui-form-pane">
	<input type="hidden" name="group" id="group" value="<?php echo $group; ?>">
        <div class="layui-form-item">
            <label class="layui-form-label">联系人</label>
            <div class="layui-input-block">
                <input type="text" name="username" required  lay-verify="required" placeholder="请输入联系人" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">联系方式</label>
            <div class="layui-input-block">
                <input type="text" name="phone" required  lay-verify="phone" placeholder="请输入手机号" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">留言内容</label>
            <div class="layui-input-block">
                <textarea name="content" placeholder="请输入内容" class="layui-textarea" required></textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="formLeave">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
</div>

<script src="/static/service/js/jquery-1.9.0.min.js"></script>
<script src="/static/service/js/jquery.cookie.js"></script>
<script>
    var config = {
        uid: '<?php echo $id; ?>',
        name: '<?php echo $name; ?>',
        avatar: '<?php echo $avatar; ?>',
        group: '<?php echo $group; ?>',
        socket: '<?php echo $socket; ?>'
    };
</script>
<script src="/static/service/js/layui/layui.js"></script>
<script src="/static/service/js/functions.js"></script>
<script src="/static/customer/js/whisper-mobile.js"></script>
</body>
</html>