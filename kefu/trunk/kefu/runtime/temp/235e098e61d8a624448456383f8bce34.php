<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:92:"D:\phpStudy\PHPTutorial\WWW\zj-whisper_pay\public/../application/admin\view\index\index.html";i:1553376710;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>后台首页</title>
    <link rel="shortcut icon" href="favicon.ico">
    <link href="https://cdn.bootcss.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.staticfile.org/font-awesome/4.4.0/css/font-awesome.css?v=4.4.0" rel="stylesheet">
    <link href="__CSS__/style.min.css?v=4.1.0" rel="stylesheet">
</head>
<body class="gray-bg">
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-sm-2">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-primary pull-right">今天</span>
                    <h5>会话中人数</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?php echo $data['is_talking']; ?></h1>
                    <div class="stat-percent font-bold text-navy"></div>
                    <small></small>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-primary pull-right">今天</span>
                    <h5>排队中用户</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?php echo $data['in_queue']; ?></h1>
                    <div class="stat-percent font-bold text-danger"></div>
                    <small></small>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-primary pull-right">今天</span>
                    <h5>在线客服数</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?php echo $data['online_kf']; ?></h1>
                    <div class="stat-percent font-bold text-danger"></div>
                    <small></small>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-primary pull-right">今天</span>
                    <h5>接入会话量</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?php echo $data['success_in']; ?></h1>
                    <div class="stat-percent font-bold text-danger"></div>
                    <small></small>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-primary pull-right">今天</span>
                    <h5>总会话量</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?php echo $data['total_in']; ?></h1>
                    <div class="stat-percent font-bold text-danger"></div>
                    <small></small>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-primary pull-right">今天</span>
                    <h5>总留言量</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?php echo $leave; ?></h1>
                    <div class="stat-percent font-bold text-danger"></div>
                    <small></small>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>今日数据分析</h5>
                </div>
                <div class="ibox-content no-padding">
                    <div class="ibox-content" style="height: 350px" id="main">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.staticfile.org/jquery/2.1.4/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="/static/admin/js/plugins/echarts/echarts.min.js"></script>
<script type="text/javascript">
    var data = <?php echo $show_data; ?>;
    // 基于准备好的dom，初始化echarts实例
    var myChart = echarts.init(document.getElementById('main'));

    // 指定图表的配置项和数据
    var option = {
        tooltip: {
            trigger: 'axis'
        },
        legend: {
            data:['正在咨询的会员','排队的会员','接入会话量','总会话量']
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
        },
        toolbox: {
            feature: {
                saveAsImage: {}
            }
        },
        xAxis: {
            type: 'category',
            boundaryGap: false,
            data: ['08:00','09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00',
                '18:00','19:00','20:00','21:00','22:00']
        },
        yAxis: {
            type: 'value'
        },
        series: [
            {
                name:'会话中会员',
                type:'line',
                stack: '总量1',
                data: data.is_talking
            },
            {
                name:'排队中会员',
                type:'line',
                stack: '总量2',
                data: data.in_queue
            },
            {
                name:'接入会话量',
                type:'line',
                stack: '总量3',
                data: data.success_in
            },
            {
                name:'总会话量',
                type:'line',
                stack: '总量4',
                data: data.total_in
            }
        ]
    };

    // 使用刚指定的配置项和数据显示图表。
    myChart.setOption(option);
</script>
</body>
</html>
