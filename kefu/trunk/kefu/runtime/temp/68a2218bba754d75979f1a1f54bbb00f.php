<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:95:"D:\phpStudy\PHPTutorial\WWW\zj-whisper_pay\public/../application/index\view\index\question.html";i:1553377763;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>客服常见问题</title>
    <link rel="shortcut icon" href="favicon.ico">
    <link href="https://cdn.bootcss.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.staticfile.org/font-awesome/4.4.0/css/font-awesome.css?v=4.4.0" rel="stylesheet">
    <link href="/static/admin/css/style.min.css?v=4.1.0" rel="stylesheet">

</head>

<body class="gray-bg">
<div class="wrapper wrapper-content  animated fadeInRight article">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="ibox">
                <div class="ibox-content">
                    <div class="text-center">
                        <h2>
                            <?php echo $question['question']; ?> </h2>
                    </div>
                    <?php echo $question['answer']; ?>
                </div>
            </div>
        </div>
    </div>

</div>
<script src="https://cdn.staticfile.org/jquery/2.1.4/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</body>
</html>