<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:85:"D:\phpStudy\PHPTutorial\WWW\kefu\public/../application/service\view\index\mobile.html";i:1553377861;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>客服工作台移动版</title>
    <link href="/static/service/js/layui/css/layui.css" rel="stylesheet" type="text/css"/>
    <link href="/static/service/js/layui/css/layui.mobile.css" rel="stylesheet"/>
    <link href="/static/service/js/layui/css/modules/layim/mobile/layim.css" rel="stylesheet"/>
</head>
<body>
    <div class="layui-m-layer layui-m-layer1" style="z-index: 0">
        <div class="layui-m-layermain">
            <div class="layui-m-layersection">
                <div class="layui-m-layerchild  layui-m-anim--1">
                    <div class="layui-m-layercont">
                        <div class="layim-panel">
                            <div class="layim-title" style="background-color: #36373C;">
                                <p id="title">客服小王</p>
                            </div>
                            <div class="layui-unselect layim-content">
                                <div class="layui-layim">
                                    <div class="layim-tab-content layui-show">
                                        <ul class="layim-list-friend">
                                            <li>
                                                <h5>
                                                    <i class="layui-icon"></i>
                                                    <span>咨询的用户</span>
                                                </h5>
                                                <ul class="layui-layim-list layui-show" id="chat-list">

                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <ul class="layui-unselect layui-layim-tab">
                                    <li title="咨询用户" class="layim-this" style="width: 49%">
                                        <i class="layui-icon"></i><span>咨询用户</span>
                                        <i class="layim-new" id="LAY_layimNewList"></i>
                                    </li>
                                    <li title="退出登录" style="width: 49%" id="loginOut">
                                        <i class="layui-icon"></i><span>退出下班</span>
                                        <i class="layim-new" id="LAY_layimNewMore"></i>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 聊天框组 -->
    <div class="layim-panel layui-m-anim-left" id="chat-boxes" style="display: none">
        <div class="layim-title" style="background-color: #36373C;">
            <p><i class="layui-icon layim-chat-back" onclick="hideBox()">&#xe603;</i> <span id="customer"></span></p>
        </div>
        <div class="layui-unselect layim-content" id="chat-box">
            <div class="layim-chat layim-chat-friend">
                <div class="layim-chat-main" id="boxes">

                </div>

                <div class="layim-chat-footer">
                    <div class="layim-chat-send">
                        <input type="text" autocomplete="off" id="msg" />
                        <button class="layim-send layui-disabled" id="send">发送</button>
                    </div>
                    <div class="layim-chat-tool">
                        <span class="layui-icon layim-tool-face" title="选择表情" id="up-face">&#xe60c;</span>
                        <span class="layui-icon layim-tool-image" title="上传图片" id="up-image">&#xe60d;</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="layui-m-layerchild layim-layer layui-m-anim-scale">
        <div class="layui-m-layercont" style="display:none;padding:0" id="face-box">

        </div>
    </div>

    <script src="/static/service/js/jquery-1.9.0.min.js"></script>
    <script src="/static/service/js/layui/layui.js"></script>
    <script>

        var uid = "<?php echo $uinfo['id']; ?>";
        var uname = "<?php echo $uinfo['user_name']; ?>";
        var avatar = "<?php echo $uinfo['user_avatar']; ?>";
        var group = "<?php echo $uinfo['group_id']; ?>";
        var socket_server = "<?php echo $socket; ?>";
    </script>
    <script type="text/javascript" src="/static/service/js/functions.js"></script>
    <script type="text/javascript" src="/static/service/js/mwhisper.js"></script>
</body>
</html>