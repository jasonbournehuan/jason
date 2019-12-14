<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:82:"D:\phpStudy\PHPTutorial\WWW\kefu\public/../application/index\view\index\leave.html";i:1554817394;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>客服留言</title>
    <link rel="stylesheet" href="/static/service/js/layui/css/layui.css">
</head>
<body style="background-color: #f2f2f2">
<div style="height: 60%;width: 50%;margin: 10% auto;background: white;padding: 20px;box-shadow: 10px 15px 10px #c2c2c2;">
    <blockquote class="layui-elem-quote">客服不在请留言</blockquote>
    <form class="layui-form layui-form-pane">
        <input type="hidden" name="group_id" value="<?php echo $group; ?>" />
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
<script src="/static/service/js/layui/layui.js"></script>
<script>
    // 留言
    layui.use(['form', 'jquery', 'element'], function(){
        var element = layui.element;
        var form = layui.form;
        var $ = layui.jquery;

        // 监听提交
        form.on('submit(formLeave)', function(data){
            $.post('/leave/<?php echo $group; ?>', data.field, function(res){

                layer.msg(res.msg);
                $("input").val("");
                $("textarea").val("");
            });

            return false;
        });
    });
</script>
</body>
</html>