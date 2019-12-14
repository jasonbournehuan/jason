<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:91:"D:\phpStudy\PHPTutorial\WWW\zj-whisper_pay\public/../application/index\view\index\chat.html";i:1553376865;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>客服</title>
    <link rel="stylesheet" href="/static/service/js/layui/css/layui.css">
    <link rel="stylesheet" href="/static/customer/css/whisper-cli.css">
</head>
<body class="layui-layout-body" style="background: #f2f2f2">
<div class="layui-layout layui-layout-admin" style="width: 80%;margin: 0 auto;">
    <div class="layui-header" style="background: #01AAED;margin-top: 4%">
        <div class="layui-logo">
            <a target="_blank" href="#" style="color: white" id="title">与 客服 交流中</a>
        </div>
    </div>

    <div class="layui-body whisper-chat-area">
        <div class="chat-left">
            <div class="chat-box whisper-chat-main">
                <ul id="chat-list" style="display: block">

                </ul>
            </div>
            <div class="msg-send">
                <div class="tools-bar">
                    <i class="layui-icon" style="font-size: 30px;" id="face" title="表情">&#xe60c;</i>
                    <i class="layui-icon" style="font-size: 30px;" id="image" title="图片">&#xe60d;</i>
                    <i class="layui-icon" style="font-size: 30px;" id="praise" title="点赞">&#xe6c6;</i>
                    <span style="float: right;cursor: pointer" id="cut">怎么发截图？</span>
                </div>
                <div class="msg-box">
                    <textarea class="msg-area" id="msg"></textarea>
                </div>
                <div class="send-area">
                    <button class="layui-btn layui-btn-small send" id="send">
                        <i class="layui-icon">&#xe609;</i>发送
                    </button>
                </div>
            </div>
        </div>

        <div class="info-box">
            <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
                <ul class="layui-tab-title">
                    <li class="layui-this">常见问题</li>
                    <li>系统公告</li>
                </ul>
                <div class="layui-tab-content" style="height: 100px;">
                    <div class="layui-tab-item info-msg layui-show">
                        <?php if(!empty($question)): if(is_array($question) || $question instanceof \think\Collection || $question instanceof \think\Paginator): if( count($question)==0 ) : echo "" ;else: foreach($question as $key=>$vo): ?>
                        <p><a href="javascript:showQA(<?php echo $vo['id']; ?>);" target="_blank"><?php echo $vo['question']; ?></a></p>
                        <?php endforeach; endif; else: echo "" ;endif; endif; ?>
                    </div>
                    <div class="layui-tab-item info-msg">
                        <?php if(!empty($notice)): if(is_array($notice) || $notice instanceof \think\Collection || $notice instanceof \think\Paginator): if( count($notice)==0 ) : echo "" ;else: foreach($notice as $key=>$vo): ?>
                        <p><a href="javascript:showNotice(<?php echo $vo['id']; ?>);" target="_blank"><?php echo $vo['title']; ?></a></p>
                        <?php endforeach; endif; else: echo "" ;endif; endif; ?>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="praise-box" id="appraise">
        <p>给客服评价： </p>
        <div id="star"></div><br/>
        <button class="layui-btn layui-btn-xs" style="float: right;background: #01AAED" id="do-praise">确定</button>
    </div>
    <div style="display: none;" id="kf_data" data-uid="<?php echo $id; ?>" data-group="<?php echo $group; ?>"></div>
</div>

<script src="/static/service/js/jquery-1.9.0.min.js"></script>

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
<script src="/static/customer/js/whisper-cli.js"></script>
</body>
</html>