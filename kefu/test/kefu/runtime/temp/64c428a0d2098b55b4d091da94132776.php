<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:84:"D:\phpStudy\PHPTutorial\WWW\kefu\public/../application/service\view\index\index.html";i:1554144174;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>客服工作台</title>
    <link rel="stylesheet" href="/static/service/js/layui/css/layui.css">
    <link rel="stylesheet" href="/static/service/css/whisper.css">
</head>
<body class="layui-layout-body" onbeforeunload="checkLeave()">
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="layui-logo" style="color: white">客服【工作台】</div>
		<div style="position: absolute!important;right: 180px;top: 20px;color:#fff;"><?php echo $userInfo['user_name']; ?></div>
        <ul class="layui-nav layui-layout-right">
            <li style="margin-top: 10%">
                <a href="javascript:;" onclick="loginOut()">
                    <button class="layui-btn layui-bg-red">
                        <i class="layui-icon">&#xe609;</i> 退出下班
                    </button>
                </a>
            </li>
        </ul>
    </div>

    <div class="layui-side" style="background:#f2f2f2">
        <div class="layui-side-scroll">
            <blockquote class="layui-elem-quote layui-bg-cyan" style="color: white">正在咨询的会员</blockquote>
            <ul class="layui-unselect" id="user_list">

            </ul>
        </div>
    </div>

    <div class="layui-body" style="bottom:0">
        <input type="hidden" id="active-user" data-avatar="" data-name="" data-id=""><!-- 当前对话的用户 -->
        <div class="chat-left">
            <div class="chat-box whisper-chat-main">

            </div>
            <div class="msg-send">
                <div class="tools-bar">
                    <i class="layui-icon" style="font-size: 30px;" id="face">&#xe60c;</i>
                    <i class="layui-icon" style="font-size: 30px;" id="image">&#xe60d;</i>
                    <i class="layui-icon" style="font-size: 30px;" id="file">&#xe61d;</i>
                    <span style="float: right;cursor: pointer" id="cut">怎么发截图？</span>
                </div>
                <div class="msg-box">
                    <textarea class="msg-area" id="msg-area"></textarea>
                </div>
                <div class="send-area">
                    <span style="margin-left:10px;color:gray;" class="layui-form"><input type="checkbox" name="switch" lay-skin="switch" lay-text="CTRL + 回车发送|回车发送" lay-filter="kj_post" value="1" checked=""></span>
                    <button class="layui-btn layui-btn-small layui-bg-cyan" style="float:right;margin-right:10px;height: 40px;padding: 0 15px;" id="send">
                        <i class="layui-icon">&#xe609;</i>发送
                    </button>
                </div>
            </div>
        </div>

        <div style="width:28%;height:100%;float:left;margin-left:1%">
            <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
                <ul class="layui-tab-title">
                    <li class="layui-this">访客信息</li>
                    <li>常用语</li>
                </ul>
                <div class="layui-tab-content" style="height: 100px;">
                    <div class="layui-tab-item layui-show">
                        <div class="layui-form layui-form-pane">
                            <div class="layui-form-item">
                                <label class="layui-form-label">访客名</label>
                                <div class="layui-input-block">
                                    <input type="text" id="f-user" class="layui-input" readonly>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">IP</label>
                                <div class="layui-input-block">
                                    <input type="text" id="f-ip" class="layui-input" readonly>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">地区</label>
                                <div class="layui-input-block">
                                    <input type="text" id="f-area" class="layui-input" readonly>
                                </div>
                            </div>
                            <div class="layui-form-item">
                            <?php if((1 == $status['change_status'])): ?>
                                <label class="layui-form-label layui-bg-cyan" style="cursor: pointer;color:white; margin-right:20px;" id="scroll-link">转接</label>
                            <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="layui-tab-item">
					
<style>
.wyInput {
  margin: 0px auto;
  padding: 10px 10px;
  background: #009688;
  border-radius: 5px;
  border: 1px solid #B4B3AE;
  position: relative;
}
.wyInput .wyinput-group {
  width: 100%;
  height: 30px;
  overflow: hidden;
}
.wyInput .wyinput-group input {
  width: 100%;
  height: 30px;
  line-height: 30px;
  border: 1px solid #B4B3AE;
  float: left;
  padding: 0 5px;
}
.wyInput .wyinput-group a {
  float: left;
  width: 20%;
  background: #219FB6;
  color: #fff;
  height: 30px;
  line-height: 30px;
  font-size: 14px;
  font-weight: bold;
  text-decoration: none;
  text-align: center;
  border-top-right-radius: 5px;
  border-bottom-right-radius: 5px;
}
.wyInput .wyinput-group a:hover {
	background: #35ACC1;
}
.wyInput .wyinput-drop {
	position: absolute;
	top: 38px;
	z-index: 1000;
	background: #fff;
	border: 1px solid #EEE4D8;
	border-top-color: transparent;
	width:95%;
}

.infos{
	height:28px;
	width: 260px;
	max-width: 260px;
	text-overflow:ellipsis; 
	word-break:keep-all;
	white-space:nowrap; 
	overflow:hidden;
	display:block;
	margin: 10px 5px 10px 5px;
	border-bottom: 2px solid #EEE4D8;
}
</style>
						<div class="wyInput">
							<div class="wyinput-group">
							<div style="position:absolute;right:15px;top:15px;cursor:pointer;"><button style="width:15px;" type="button" class="input_clear"> × </button></div> 
								<input type="text" id="named" placeholder="查找快捷回复">
							</div>
							<div class="wyinput-drop" id="schname"></div>
						</div>


                        <div class="layui-form">
                            <table class="layui-table">
                                <thead>
                                <tr>
                                    <th>内容</th>
                                </tr>
                                </thead>
                                <tbody id='word_page'>
                                </tbody>
                            </table>
                        </div>
                        <div class="layui-form" id="word_page_list">
						</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 转接提示层 -->
<div class="layui-form" id="change-box" style="display: none">
    <div class="layui-form-item" style="margin-top: 20px">
        <div class="layui-tab layui-tab-brief">
            <ul class="layui-tab-title" id="change-group-title">

            </ul>
            <div class="layui-tab-content" id="relink-tab">

            </div>
        </div>
    </div>
</div>
<!-- 转接提示层 -->
<div class="hidden" id="my_info" data-group="<?php echo $group_id; ?>">
</div>

<script src="/static/service/js/jquery-1.9.0.min.js"></script>
<script src="/static/service/js/layui/layui.js"></script>
<script>
    function checkLeave() {
        event.returnValue = "确定离开当前页面吗？";
    }

    var uid = "<?php echo $uinfo['id']; ?>";
    var uname = "<?php echo $uinfo['user_name']; ?>";
    var avatar = "<?php echo $uinfo['user_avatar']; ?>";
    var group = "<?php echo $uinfo['group_id']; ?>";
    var socket_server = "<?php echo $socket; ?>";
</script>
<script type="text/javascript" src="/static/service/js/functions.js"></script>
<script type="text/javascript" src="/static/service/js/whisper.js"></script>
<script type="text/javascript">
    var websites = <?php echo $words; ?>;
	var word_page = 1;
	var word_pagesize = 10;
    $(function() {
		//监听输入框
        $("#named").keyup(function (){
            var html="";
            if($("#named").val().length>0){
                var len=websites.length>10?10:websites.length;//最多显示10行
                for(var i=0;i< len;i++){
                    if(websites[i][0].toLowerCase().indexOf($("#named").val().toLowerCase())>=0){
						//html+="<p class='drop-line infos' id='infos_" + i + "' onmouseover='infos_hover(" + i + ");' onmouseout='infos_nohover(" + i + ");' onclick='sendtext(this)' data-word='"+websites[i][0]+"'>"+websites[i][0]+"</p>";
						html+="<p class='drop-line infos' id='infos_" + i + "' onmouseover='infos_hover(this);' onclick='sendtext(this)' data-word='"+websites[i][0]+"'>"+websites[i][0]+"</p>";
                    }
                }
                if(html==""){
                    html+="<tr><td >没有数据</td></tr>";
                }
                $("#schname").html(html);
                $("#schname").css("display","table");
            }else{
                $("#schname").css("display","none");
            }
        });
    });
	function infos_hover(obj){
		layer.tips($(obj).data('word'), $(obj), {tips: 1});
	}
	function word_pages(page){
		var word_html="";
		var word_end = word_page * word_pagesize;
		var word_start = word_end - word_pagesize;
		if(websites.length < word_end){
			word_end = websites.length;
		}
		for(var i=word_start;i< word_end;i++){
			word_html+='<tr><td onmouseover="infos_hover(this);" data-word="'+websites[i][0]+'" onclick="sendtext(this)">'+websites[i][0].substring(0, 20)+'</td></tr>';
		}
		if(word_html==""){
			word_html+="<tr><td>没有数据</td></tr>";
		}
		$("#word_page").html(word_html);
		word_page_list(page);
	}
	function word_page_list(page){
		var word_page_list_html="";
		var word_page_list_html1="";
		var word_page_now_num = 3;
		var total_page_num = Math.ceil(websites.length/word_pagesize);
		if(page > 1){
			word_page_list_html += '<button class="layui-btn layui-btn-sm layui-btn-primary" onclick="word_pages(' + (page-1) + ');"><</button>';
			word_page_list_html += '<button class="layui-btn layui-btn-sm layui-btn-primary" onclick="word_pages(' + (page-1) + ');">' + (page-1) + '</button>';
			word_page_now_num = 2;
		}
		for(i = 0; i < word_page_now_num; i++){
			if(page+i <= total_page_num){
				page_new = page+i;
				if(page_new == page){
					page_class = 'background: #c2c2c2;';
				}else{
					page_class = '';
				}
				word_page_list_html += '<button class="layui-btn layui-btn-sm layui-btn-primary" style="' + page_class + '" onclick="word_pages(' + page_new + ');">' + page_new + '</button>';
			}
		}
		if(page < total_page_num){
			word_page_list_html += '<button class="layui-btn layui-btn-sm layui-btn-primary" onclick="word_pages(' + (page+1) + ');">></button>';
		}
		$("#word_page_list").html(word_page_list_html);
	}
	word_pages(word_page);
</script>
</body>
</html>