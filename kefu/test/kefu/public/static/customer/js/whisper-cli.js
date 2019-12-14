// 客服的id
var kf_id = 0;
var kf_name = '';
// 发送锁  标识
var sendLock = 0;
// 窗口大小标识
var size = 1;
// 是否显示默认的聊天记录
var commChat = 1;
// 表情是否打开
var isShowFace = false;
// 是否打开点赞
var isShowPraise = false;
// 点赞数
var star = 0;
// 点赞唯一标识
var uuid = 0;
// 发送快捷键
var kj_post = 1;

var wait_msg = Array();

// 连接服务器
if(config != undefined && config.socket != undefined){

    // 创建一个Socket实例
    var socket = new WebSocket(config.socket);

    // 加锁
    lockTextarea();
    //showSystem({content: '连接中...'});
    document.getElementById('title').innerText = '连接中...';

    // 打开Socket
    socket.onopen = function(res) {
        console.log('握手成功');
        // 登录
        socket.send(JSON.stringify({
            type: "userInit",
            uid: config.uid,
            name: config.name,
            avatar: config.avatar,
            group: config.group
        }));

        // 解锁
        unlockTextarea();
    };

    // 监听消息
    socket.onmessage = function(res) {
        var data = eval("("+res.data+")");
        switch(data['message_type']){
            // 服务端ping客户端
            case 'ping':
                socket.send('{"type":"ping"}');
                break;
            // 已经被分配了客服
            case 'connect':
                kf_id = data.data.kf_id;
                kf_name = data.data.kf_name;
                showSystem({content: '客服 ' + data.data.kf_name + ' 为您服务'});
                document.getElementById('title').innerHTML = '与 ' + kf_name + ' 交流中';
                if(1 == commChat){
                    getChatLog(1);
                }
                unlockTextarea();

                $.getJSON('/index/index/bindPraise', {kf_id: kf_id, uid: config.uid}, function (res) {
                    if(1 == res.code) {
                        uuid = res.data;
                    }
                });

                break;
            // 排队等待
            case 'wait':

                if('暂时没有客服上班,请稍后再咨询。' == data.data.content){

                    if(isMobile()) {
                        document.getElementById("chat-box").style.display = 'none';
                        document.getElementById("leave-box").style.display = 'block';
                        socket.close();
                        break;
                    }else {
                        var obj = $('#kf_data');
                        var uid = obj.data('uid');
                        var group = obj.data('group');
                        window.location.href = '/leave/' + group + '/' + uid;
                    }
                }

                lockTextarea();
                document.getElementById('title').innerHTML = '请稍后再来';
                showSystem(data.data);
                break;
            // 监测聊天数据
            case 'chatMessage':
                showMsg(data.data);
                break;
            // 问候语
            case 'helloMessage':
                showMsg(data.data, 1);
                break;
            // 转接
            case 'relinkMessage':
                commChat = 2;
                document.getElementById('title').innerHTML = '正在转接中...';
                break;
        }
    };

    // 监听错误
    socket.onerror = function(err){
        showSystem({content: '连接失败'});
        document.getElementById('title').innerText = '连接失败';
    };
}

// 监听粘贴事件
document.getElementById('msg').addEventListener('paste', function(e){

    // 添加到事件对象中的访问系统剪贴板的接口
    var clipboardData = e.clipboardData,
        i = 0,
        items, item, types;

    if (clipboardData) {
        items = clipboardData.items;
        if (!items) {
            return;
        }
        item = items[0];
        // 保存在剪贴板中的数据类型
        types = clipboardData.types || [];
        for (; i < types.length; i++) {
            if (types[i] === 'Files') {
                item = items[i];
                break;
            }
        }

        // 判断是否为图片数据
        if (item && item.kind === 'file' && item.type.match(/^image\//i)) {

            var fileType = [
                'image/jpg',
                'image/png',
                'image/jpeg',
                'image/gif'
            ];

            if(-1 == fileType.indexOf(item.type)){
                layer.msg("只支持jpg,jpeg,png,gif");
                return false;
            }

            var fileType = item.type.lastIndexOf('/');
            var suffix = item.type.substring(fileType+1, item.type.length);

            var blob = item.getAsFile();
            var fileName =  new Date().valueOf() + '.' + suffix;

            var formData = new FormData();
            formData.append('name', fileName);
            formData.append('file', blob);

            var request = new XMLHttpRequest();

            request.onreadystatechange = function() {
                if (request.readyState == 4 && request.status == 200) {
                    var res = eval('(' + request.response + ')');
                    if(res.code == 0){
                        document.getElementById('msg').value = 'img['+ (res.data.src||'') +']';
                        //sendMessage();
                    } else {
                        layer.msg(res.msg||'粘贴失败');
                    }
                }
            };
            // upload error callback
            request.upload.onerror = function(error) {
                layer.msg(res.msg||'粘贴失败');
            };
            // upload abort callback
            request.upload.onabort = function(error) {
                layer.msg(res.msg||'粘贴失败');
            };

            request.open('POST', '/index/upload/uploadImg');
            request.send(formData);

            //imgReader(item, data.id);
        }
    }

});

// 截图提示
document.getElementById('cut').addEventListener('mouseover', function(){
    layer.tips('将您剪切好的图片粘贴到输入框即可', "#cut", {tips: 1});
});

//监控窗口尺寸变化
$(window).resize(function(){
	BoxHeight();
    // 滚动条自动定位到最底端
    wordBottom();
});

//初始化完成事件
$(document).ready(function(){
	BoxHeight();
    // 滚动条自动定位到最底端
    wordBottom();
});

// 点击或回车发送消息
$('#send').click(function(){
	sendMsginfo();
});
$(document).keydown(function (event) {
	if (kj_post == 1 && event.ctrlKey && event.keyCode == 13){
		sendMsginfo();
	}else if(kj_post == 2 && !event.ctrlKey && event.keyCode == 13){
		sendMsginfo();
		return false;
	}
});
layui.use(['form'], function () {
    var form = layui.form;
	form.on('switch(kj_post)', function(data){
		if(this.checked == true){
			kj_post = 1;
		}else{
			kj_post = 2;
		}
	});
});

// 图片 文件上传
layui.use(['upload', 'layer'], function () {
    var upload = layui.upload;
    var layer = layui.layer;

    // 执行实例
    var uploadInstImg = upload.render({
        elem: '#image' // 绑定元素
        , accept: 'images'
        , exts: 'jpg|jpeg|png|gif'
        , url: '/index/upload/uploadImg' // 上传接口
        , done: function (res) {

            sendMsg('img[' + res.data.src + ']');
            showBigPic();
        }
        , error: function () {
            // 请求异常回调
        }
    });

});

//自动聊天窗口高度
function BoxHeight(){
	$(".chat-box").height($(document).height() - 310);
}

//发送消息
function sendMsginfo(){
    if(1 == sendLock){
		layer.msg('等待中无法发送消息！');
        return false;
    }
    sendMsg();
    document.getElementById('msg').value = '';
    // 滚动条自动定位到最底端
    wordBottom();
};

// 获取时间
function getTime(){
    var myDate = new Date();
    var hour = myDate.getHours();
    var minute = myDate.getMinutes();
    if(hour < 10) hour = '0' + hour;
    if(minute < 10) minute = '0' + minute;

    return hour + ':' + minute;
}

// 展示系统消息
function showSystem(msg){
    var _html = document.getElementById('chat-list').innerHTML;
    _html += '<div class="whisper-chat-system"><span>' + msg.content + '</span></div>';

    document.getElementById('chat-list').innerHTML = _html;
}


// 发送信息
function sendMsg(sendMsg){

    if(1 == sendLock){
        return false;
    }

    var msg = (typeof(sendMsg) == 'undefined') ? document.getElementById('msg').value : sendMsg;
	var cpMsg = msg;
    if('' == msg || 0 == cpMsg.trim().length){
        return false;
    }

    var _html = document.getElementById('chat-list').innerHTML;
    var time = getTime();
    var content = replaceContent(msg);

    _html += '<li class="whisper-chat-mine">';
    _html += '<div class="whisper-chat-user">';
    _html += '<img src="' + config.avatar + '">';
    _html += '<cite><i>' + getDate() + '</i>' + config.name + '</cite>';
    _html += '</div><div class="whisper-chat-text">' + content + '</div>';
    _html += '</li>';

    // 发送消息
    socket.send(JSON.stringify({
        type: 'chatMessage',
        data: {to_id: kf_id, to_name: kf_name, content: msg, from_name: config.name,
            from_id: config.uid, from_avatar: config.avatar, group: config.group}
    }));

    document.getElementById('chat-list').innerHTML = _html;

    // 滚动条自动定位到最底端
    wordBottom();

    showBigPic();
}

// 展示发送来的消息
function showMsg(info, flag){
    // 清除系统消息
    document.getElementsByClassName('whisper-chat-system').innerHTML = '';

    var _html = document.getElementById('chat-list').innerHTML;
    var content = replaceContent(info.content);

    _html += '<li>';
    _html += '<div class="whisper-chat-user">';
    _html += '<img src="' + info.avatar + '">';
    _html += '<cite>' + info.name + '<i>' + getDate() + '</i></cite>';
    _html += '</div><div class="whisper-chat-text">' + content + '</div>';
    _html += '</li>';

    document.getElementById('chat-list').innerHTML = _html;

    showBigPic();
    // 滚动条自动定位到最底端
    wordBottom();
}

// 获取日期
function getDate() {
    var d = new Date(new Date());

    return d.getFullYear() + '-' + digit(d.getMonth() + 1) + '-' + digit(d.getDate())
        + ' ' + digit(d.getHours()) + ':' + digit(d.getMinutes()) + ':' + digit(d.getSeconds());
}

//补齐数位
var digit = function (num) {
    return num < 10 ? '0' + (num | 0) : num;
};

// 展示表情数据
function showFaces() {
    isShow = true;
    var alt = getFacesIcon();
    var _html = '<div class="layui-whisper-face"><ul class="layui-clear whisper-face-list">';
    layui.each(alt, function (index, item) {
        _html += '<li title="' + item + '" onclick="checkFace(this)"><img src="/static/service/js/layui/images/face/' + index + '.gif" /></li>';
    });
    _html += '</ul></div>';

    return _html;
}

// 选择表情
function checkFace(obj) {
    var word = $(".msg-area").val() + ' face' + $(obj).attr('title') + ' ';
    $(".msg-area").val(word).focus();
}

// 缓存聊天数据 [本地存储策略]
function cacheChat(obj){
    if(typeof(Storage) !== "undefined"){
        localStorage.setItem(obj.key, JSON.stringify(obj.data));
    }
}

// 从本地缓存中，拿出数据
function getCache(key){
    return JSON.parse(localStorage.getItem(key));
}

// 获取聊天记录
function getChatLog(page, flag) {

    $.getJSON('/index/index/getChatLog', {uid: config.uid, kf_id: kf_id, page: page}, function(res){
        if(1 == res.code && res.data.length > 0){

            if(res.msg == res.total){
                var _html = '<div class="layui-flow-more">没有更多了</div>';
            }else{
                var _html = '<div class="layui-flow-more"><a href="javascript:;" data-page="' + parseInt(res.msg + 1)
                    + '" onclick="getMore(this)"><cite>更多记录</cite></a></div>';
            }

            var len = res.data.length;

            for(var i = 0; i < len; i++){
                var v = res.data[len - i - 1];
                if ('mine' == v.type) {
                    _html += '<li class="whisper-chat-mine">';
                } else {
                    _html += '<li>';
                }
                _html += '<div class="whisper-chat-user">';
                _html += '<img src="' + v.from_avatar + '">';
                if ('mine' == v.type) {
                    _html += '<cite><i>' + v.time_line + '</i>' + v.from_name + '</cite>';
                } else {
                    _html += '<cite>' + v.from_name + '<i>' + v.time_line + '</i></cite>';
                }
                _html += '</div><div class="whisper-chat-text">' + replaceContent(v.content) + '</div>';
                _html += '</li>';
            }

            setTimeout(function () {
                // 滚动条自动定位到最底端
                if(typeof flag == 'undefined'){
                    $('#chat-list').html(_html);
                    wordBottom();
                }else{
                    $('#chat-list').prepend(_html);
                }

                showBigPic();
            }, 100);
        }
    });
}

// 获取更多聊天记录
function getMore(obj){
    $(obj).remove();

    var page = $(obj).attr('data-page');
    getChatLog(page, 1);
}

// 锁住输入框
function lockTextarea(){
    sendLock = 1;
    //document.getElementById('msg').setAttribute('readonly', 'readonly');
	document.getElementById('send').style.background = "#e8e8e8";
}

// 解锁输入框
function unlockTextarea(){
    sendLock = 0;
    //document.getElementById('msg').removeAttribute('readonly');
	document.getElementById('send').style.background = "#01AAED";
}

// 双击图片
function showBigPic(){
    layui.use('jquery', function(){
        var $ = layui.jquery;

        $(".layui-whisper-photos").on('click', function () {
            var src = this.src;
            layer.photos({
                photos: {
                    data: [{
                        "alt": "大图模式",
                        "src": src
                    }]
                }
                , shade: 0.5
                , closeBtn: 2
                , anim: 0
                , resize: false
                , success: function (layero, index) {

                }
            });
        });
    });
}

// 对话框定位到最底端
function wordBottom(){
    var box = $(".chat-box");
    box.scrollTop(box[0].scrollHeight);
}

var isMobile = function(){
    if( navigator.userAgent.match(/Android/i)
        || navigator.userAgent.match(/webOS/i)
        || navigator.userAgent.match(/iPhone/i)
        || navigator.userAgent.match(/iPad/i)
        || navigator.userAgent.match(/iPod/i)
        || navigator.userAgent.match(/BlackBerry/i)
        || navigator.userAgent.match(/Windows Phone/i)
    ){
        return true;
    } else {
        return false;
    }
};

$(function () {
    // 点击表情
    var index;
    $("#face").click(function (e) {
        e.stopPropagation();
        layui.use(['layer'], function () {
            var layer = layui.layer;

            var isShow = $(".layui-whisper-face").css('display');
            if ('block' == isShow) {
                layer.close(index);
                isShowFace = false;
                return;
            }

            if (isShowPraise) {
                $("#appraise").hide();
                isShowPraise = false;
            }

            isShowFace = true;
            var height = $(".chat-box").height() - 110;
            layer.ready(function () {
                index = layer.open({
                    type: 1,
                    offset: [height + 'px', '10%'],
                    shade: false,
                    title: false,
                    closeBtn: 0,
                    area: '395px',
                    content: showFaces()
                });
            });
        });
    });

    $(document).click(function (e) {
        layui.use(['layer'], function () {
            var layer = layui.layer;
            if (isShowFace) {
                layer.close(index);
                return false;
            }
        });
    });

    // 点赞
    $("#praise").click(function (e) {
        e.stopPropagation();
        layui.use(['layer'], function () {
            var layer = layui.layer;

            var isShow = $("#appraise").css('display');
            if ('block' == isShow) {
                $("#appraise").hide();
                isShowPraise = false;
                return;
            }

            if (isShowFace) {
                layer.close(index);
                isShowFace = false;
            }

            var height = $(".chat-box").height() - 110;
            isShowPraise = true;
            $("#appraise").css('top', height).show();
        });
    });

    // 确认评价
    $('#do-praise').click(function(e) {
        e.stopPropagation();

        $.getJSON('/index/index/dopraise', {uuid: uuid, star: star}, function (res) {
            $("#appraise").hide();
            isShowPraise = false;
            showSystem({content: '您给 ' + kf_name + ' 打出 ' + star + '星评价'});
        });
    })

});

layui.use(['element', 'rate'], function () {
    var element = layui.element;
    var rate = layui.rate;

    rate.render({
        elem: '#star'
        ,choose: function(value){
            star = value;
        }
    });
});

// 展示常见问题
function showQA(id) {

    layui.use('layer', function () {
        var layer = layui.layer;

        layer.open({
            type: 2,
            title: false,
            shadeClose: true,
            shade: 0.2,
            area: ['60%', '50%'],
            content: '/index/index/question/id/' + id
        });
    });
}

// 展示系统公告
function showNotice(id) {

    layui.use('layer', function () {
        var layer = layui.layer;

        layer.open({
            type: 2,
            title: false,
            shadeClose: true,
            shade: 0.2,
            area: ['60%', '50%'],
            content: '/index/index/notice/id/' + id
        });
    });
}