<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:82:"D:\phpStudy\PHPTutorial\WWW\kefu\public/../application/admin\view\secret\edit.html";i:1553520498;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>编辑外部登陆信息</title>
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
                    <h5>编辑外部登陆信息</h5>
                </div>
                <div class="ibox-content">
                    <form class="form-horizontal m-t layui-form" id="commentForm" method="post" action="<?php echo url('secret/edit'); ?>">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">access key：</label>
                            <div class="input-group col-sm-4">
                                <input type="text" class="form-control" required="required" value="<?php echo $info['access_key']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">access secret：不得小于18位长度</label>
                            <div class="input-group col-sm-4">
                                <input type="text" class="form-control" name="access_secret" required="required" value="<?php echo $info['access_secret']; ?>">
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
