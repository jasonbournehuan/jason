<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:95:"D:\phpStudy\PHPTutorial\WWW\zj-whisper_pay\public/../application/admin\view\users\edituser.html";i:1551448400;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>编辑客服</title>
    <link rel="shortcut icon" href="favicon.ico">
    <link href="__CSS__/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="__CSS__/font-awesome.min.css?v=4.4.0" rel="stylesheet">
    <link href="__CSS__/animate.min.css" rel="stylesheet">
    <link href="__JS__/layui/css/layui.css" rel="stylesheet">
    <link href="__CSS__/style.min.css?v=4.1.0" rel="stylesheet">
</head>
<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-8">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>编辑客服</h5>
                </div>
                <div class="ibox-content">
                    <form class="form-horizontal m-t layui-form" id="commentForm" method="post" action="<?php echo url('users/edituser'); ?>">
                        <input type="hidden" value="<?php echo $info['id']; ?>" name="id"/>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">客服名称：</label>
                            <div class="input-group col-sm-4">
                                <input id="username" type="text" class="form-control" name="user_name" required="" aria-required="true" value="<?php echo $info['user_name']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">登录密码：</label>
                            <div class="input-group col-sm-4">
                                <input id="password" type="text" class="form-control" name="user_pwd" placeholder="重新输入则为修改">
                            </div>
                        </div>
                        <div class="form-group layui-form-item">
                            <label class="col-sm-3 control-label">是否启用：</label>
                            <div class="input-group col-sm-6">
                                <?php if(!empty($status)): if(is_array($status) || $status instanceof \think\Collection || $status instanceof \think\Paginator): if( count($status)==0 ) : echo "" ;else: foreach($status as $key=>$vo): ?>
                                <input type="radio" name="status" value="<?php echo $key; ?>" title="<?php echo $vo; ?>" <?php if($key == $info['status']): ?>checked<?php endif; ?>>
                                <?php endforeach; endif; else: echo "" ;endif; endif; ?>
                            </div>
                        </div>
                        <div class="form-group layui-form-item form-inline" style="height: 60px;">
                            <input type="hidden" name="user_avatar" id="user_avatar"/>
                            <label class="col-sm-3 control-label">客服头像：</label>
                            <div class="input-group col-sm-2">
                                <button type="button" class="layui-btn layui-btn-small" id="up-avatar">
                                    <i class="layui-icon"></i>上传图片</button>
                            </div>
                            <div class="input-group col-sm-3" id="avatar">
                                <img src="<?php echo $info['user_avatar']; ?>" width="40px" height="40px"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-6">
                                <button class="btn btn-primary" type="submit">提交</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
<script src="__JS__/jquery.min.js?v=2.1.4"></script>
<script src="__JS__/bootstrap.min.js?v=3.3.6"></script>
<script src="__JS__/content.min.js?v=1.0.0"></script>
<script src="__JS__/plugins/validate/jquery.validate.min.js"></script>
<script src="__JS__/plugins/validate/messages_zh.min.js"></script>
<script src="__JS__/plugins/layer/layer.min.js"></script>
<script src="__JS__/layui/layui.js"></script>
<script src="__JS__/jquery.form.js"></script>
<script type="text/javascript">

    layui.use(['form', 'upload'], function(){
        var form = layui.form;
        var upload = layui.upload;
        //执行实例
        var uploadInst = upload.render({
            elem: '#up-avatar' //绑定元素
            ,url: "<?php echo url('users/upAvatar'); ?>" //上传接口
            ,exts: 'png|jpg|jpeg|gif'
            ,done: function(res){
                //上传完毕回调
                if(0 == res.code){
                    $("#avatar").html('<img src="' + res.data.src + '" width="50px" height="50px">');
                    $("#user_avatar").val(res.data.src);
                }else{
                    layer.msg(res.msg);
                }
            }
            ,error: function(){
                //请求异常回调
            }
        });

        form.on('select(group)', function(value){
            $("#group_id").val(value.value);
        });
    });

    var index = '';
    function showStart(){
        index = layer.load(0, {shade: false});
        return true;
    }

    function showSuccess(res){

        layer.ready(function(){
            layer.close(index);
            if(1 == res.code){
               layer.alert(res.msg, {title: '友情提示', icon: 1, closeBtn: 0}, function(){
                   window.location.href = res.data;
               });
            }else if(111 == res.code){
                window.location.reload();
            }else{
                layer.msg(res.msg, {anim: 6});
            }
        });
    }

    $(document).ready(function(){
        // 添加管理员
        var options = {
            beforeSubmit:showStart,
            success:showSuccess
        };

        $('#commentForm').submit(function(){
            $(this).ajaxSubmit(options);
            return false;
        });
    });

    // 表单验证
    $.validator.setDefaults({
        highlight: function(e) {
            $(e).closest(".form-group").removeClass("has-success").addClass("has-error")
        },
        success: function(e) {
            e.closest(".form-group").removeClass("has-error").addClass("has-success")
        },
        errorElement: "span",
        errorPlacement: function(e, r) {
            e.appendTo(r.is(":radio") || r.is(":checkbox") ? r.parent().parent().parent() : r.parent())
        },
        errorClass: "help-block m-b-none",
        validClass: "help-block m-b-none"
    });

</script>
</body>
</html>
