var uinfo = {
    id:  'KF' + uid,
    username: uname,
    avatar: avatar,
    group: group
};

// 服务用户池
var serviceUsersPool = [];

// 是否点击显示表情的标志
var flag = 1;

// 用户协议表
var customerProtocolTable = [];

var layer = null;
layui.use('mobile', function () {

    var mobile = layui.mobile;
    layer = mobile.layer;
});

$('#title').text(uname);
var activeUser = {
    id: 1,
    name: '',
    avatar: ''
};

// 创建一个Socket实例
var socket = new WebSocket(socket_server);

// 打开Socket
socket.onopen = function (res) {
    layui.use('mobile', function () {

        var mobile = layui.mobile;
        layer = mobile.layer;

        layer.open({
            content: '链接成功'
            ,skin: 'msg'
            ,time: 1 // 1秒后自动关闭
        });
    });

    // 登录
    socket.send(JSON.stringify({
        type: 'init',
        uid: uinfo.id,
        name: uinfo.username,
        avatar: uinfo.avatar,
        group: uinfo.group
    }));
};

// 监听消息
socket.onmessage = function (res) {
    var data = eval("(" + res.data + ")");
    switch (data['message_type']) {
        // 服务端ping客户端
        case 'ping':
            socket.send('{"type":"ping"}');
            break;
        // 添加用户
        case 'connect':
            customerProtocolTable[data.data.user_info.id] = 'ws';
            if(-1 == $.inArray(data.data.user_info.id, serviceUsersPool)) {

                serviceUsersPool.push(data.data.user_info.id);
                addUser(data.data.user_info);
            }else {
                online(data.data.user_info);
            }

            break;
        // 用户离线
        case 'offline':
            offline(data.data);
            break;
        // 监测聊天数据
        case 'chatMessage':
            showMsg(data.data);
            break;
    }
};

// 监听失败
socket.onerror = function(err) {
    layer.open({
        content: '连接失败,请联系管理员'
        ,btn: '我知道了'
    });
};

$(function() {

    // 获取服务用户列表
    $.getJSON('/service/index/getUserList', function(res){
        if(1 == res.code && res.data.length > 0){
            $.each(res.data, function(k, v){
                customerProtocolTable[v.id] = v.protocol;
                serviceUsersPool.push(v.id);
                addNeedServiceUser(v);
            });
        }
    });

    // 修复IOS下输入法遮挡问题
    $('#msg').on('focus', function () {

        setTimeout(function(){
            document.getElementsByTagName('body')[0].style.height = (window.innerHeight + 500) + 'px';
            document.body.scrollTop = 500;
        }, 300);
    });

    $('#msg').on('blur', function () {
        document.getElementsByTagName('body')[0].style.height = window.innerHeight + 'px';
    });

    // 监听输入改变发送按钮
    $("#msg").bind('input porpertychange', function(){

        if($("#msg").val().length > 0){
            $(".layim-send").removeClass('layui-disabled');
        }else{
            $(".layim-send").addClass('layui-disabled');
        }
    });

    // 点击发送
    $("#send").click(function(){
        sendMsg();
    });

    // 点击表情
    $('#up-face').click(function(e){
        e.stopPropagation();

        if(1 == flag){
            showFaces();
            $('#face-box').show();
            flag = 2;
        }else{
            $('#face-box').hide();
            flag = 1;
        }
    });

    // 监听点击旁边关闭表情
    document.addEventListener("click", function(){
        if(2 == flag){
            $('#face-box').hide();
            flag = 1;
        }
    });
});

// 展示聊天框
function  showChatBox(id, name, avatar) {

    $("#chat-boxes").show();
    $("#customer").text(name);
    $("#customer-" + id).show().siblings().hide();

    activeUser.id = id;
    activeUser.name = name;
    activeUser.avatar = avatar;

    hideNew(id);

    getChatLog(id, 1);
}

// 隐藏聊天框
function hideBox() {

    $("#chat-boxes").hide();
    $("#boxes ul").hide();
}

// 添加聊天用户
function addUser(data) {

    // 聊天用户
    var _html = '<li onclick="showChatBox(\'' + data.id + '\', \'' + data.name + '\', \'' + data.avatar + '\')" id="c-' + data.id + '">';
    _html += '<div><img src="' + data.avatar + '"></div>';
    _html += '<span>' + data.name + '</span>';
    _html += '<p></p>';
    _html += '<span class="layim-msg-status">new</span></li>';

    $('#chat-list').prepend(_html);

    // 添加聊天区域
    var chat_box = '<ul id="customer-' + data.id + '" style="display: none"></ul>';
    $("#boxes").append(chat_box);
}

// 刷新重新展示待服务用户
function addNeedServiceUser(data) {

    // 聊天用户
    var _html = '<li onclick="showChatBox(\'' + data.id + '\', \'' + data.name + '\', \'' + data.avatar + '\')" id="c-' + data.id + '">';
    _html += '<div><img src="' + data.avatar + '"></div>';
    _html += '<span>' + data.name + '</span>';
    _html += '<p></p>';
    _html += '<span class="layim-msg-status">new</span></li>';

    $('#chat-list').append(_html);

    // 添加聊天区域
    var chat_box = '<ul id="customer-' + data.id + '" style="display: none"></ul>';
    $("#boxes").append(chat_box);
}

// 发送消息
function sendMsg(sendMsg){

    var msg = (typeof(sendMsg) == 'undefined') ? $('#msg').val() : sendMsg;
    var cpMsg = msg;
    if('' == msg || 0 == cpMsg.trim().length){
        return false;
    }

    var _html = $("#customer-" + activeUser.id).html();
    var time = getTime();
    var content = replaceContent(msg);

    _html += '<li class="layim-chat-system"><span>' + time + '</span></li>'
    _html += '<li class="layim-chat-li layim-chat-mine">';
    _html += '<div class="layim-chat-user">';
    _html += '<img src="' + uinfo.avatar + '"><cite>我</cite></div>';
    _html += '<div class="layim-chat-text">' + content + ' </div></li>';

    $("#customer-" + activeUser.id).html(_html);

    // 发送消息
    socket.send(JSON.stringify({
        type: 'chatMessage',
        data: {
            to_id: activeUser.id,
            to_name: activeUser.name,
            content: msg,
            from_name: uinfo.username,
            from_id: uinfo.id,
            from_avatar: uinfo.avatar
        }
    }));

    $('#msg').val('');
    $(".layim-send").addClass('layui-disabled');

    // 滚动条自动定位到最底端
    wordBottom();
}

// 展示发送来的消息
function showMsg(info, flag){

    var _html = $("#customer-" + info.id).html();
    var content = replaceContent(info.content);

    _html += '<li class="layim-chat-system"><span>' + info.time + '</span></li>';
    _html += '<li class="layim-chat-li">';
    _html += '<div class="layim-chat-user">';
    _html += '<img src="' + info.avatar + '"><cite>' + info.name + '</cite></div>';
    _html += '<div class="layim-chat-text">' + content + '</div></li>';

    $("#customer-" + info.id).html(_html);

    showNew(info.id);

    // 滚动条自动定位到最底端
    wordBottom();

    // 声音提醒
    voice();
}

// 获取时间
function getTime(){
    var myDate = new Date();
    var hour = myDate.getHours();
    var minute = myDate.getMinutes();
    if(hour < 10) hour = '0' + hour;
    if(minute < 10) minute = '0' + minute;

    return hour + ':' + minute;
}

// 消息声音提醒
function voice() {
    var audio = document.createElement("audio");
    audio.src = '/static/service/js/layui/css/modules/layim/voice/default.mp3';
    audio.play();
}

// 用户离线
function offline(data) {
    $('#c-' + data.id).addClass('layim-list-gray');
}

// 用户上线
function online(data) {
    $('#c-' + data.id).removeClass('layim-list-gray');
}

// 显示有新消息到
function showNew(id) {
    if(id != activeUser.id) {
        $('#c-' + id).find('.layim-msg-status').addClass('layui-show');
    }
}

// 移除新消息
function hideNew(id) {
    $('#c-' + id).find('.layim-msg-status').removeClass('layui-show');
}

// 对话框定位到最底端
function wordBottom() {
    // 滚动条自动定位到最底端
    var box = $(".layim-chat-main");
    box.scrollTop(box[0].scrollHeight);
}

// 展示表情数据
function showFaces(){
    var alt = getFacesIcon();
    var _html = '<ul class="layui-layim-face">';
    var len = alt.length;
    for(var index = 0; index < len; index++){
        _html += '<li title="' + alt[index] + '" onclick="checkFace(this)"><img src="/static/customer/images/face/'+ index + '.gif" /></li>';
    }
    _html += '</ul>';

    document.getElementById('face-box').innerHTML = _html;
}

// 选择表情
function checkFace(obj){
    var msg = document.getElementById('msg').value;
    document.getElementById('msg').value = 	msg + ' face' + obj.title + ' ';
    document.getElementById('face-box').style.display = 'none';
    $(".layim-send").removeClass('layui-disabled');
    flag = 1;
}

// 图片 文件上传
layui.use(['upload'], function () {
    var upload = layui.upload;
    var mobile = layui.mobile,
        index = null,
        layer = mobile.layer;

    // 执行实例
    var uploadInstImg = upload.render({
        elem: '#up-image' // 绑定元素
        , accept: 'images'
        , exts: 'jpg|jpeg|png|gif'
        , url: '/index/upload/uploadImg' // 上传接口
        , before: function () {
            index = layer.open({
                type: 2
                ,content: '上传中'
            });
        }
        , done: function (res) {
            layer.close(index);

            sendMsg('img[' + res.data.src + ']');
            showBigPic();
        }
        , error: function () {
            // 请求异常回调
        }
    });

    $('.layui-upload-file').hide();
});

// 显示大图
function showBigPic(){

    $(".layui-whisper-photos").on('click', function () {
        var src = this.src;

        layer.open({
            type: 1
            ,content: '<img src="' + src + '" width="100%" height="100%">'
            ,anim: 'up'
            ,style: 'position:fixed; left:0; top:30%; width:100%; height:10%; border: none; -webkit-animation-duration: .5s; animation-duration: .5s;'
        });
    });
}

// 退出登录
$("#loginOut").click(function () {

    layer.open({
        content: '您确定要下班？'
        ,btn: ['是的', '取消']
        ,yes: function(index){
            layer.close(index);

            layer.open({
                content: '正在关闭,未咨询完的用户'
                ,skin: 'msg'
                ,time: 50
            });

            // 关闭用户
            for(var i = 0; i < serviceUsersPool.length; i++) {

                socket.send(JSON.stringify({
                    type: 'closeUser', uid: serviceUsersPool[i]
                }));
            }

            socket.send(JSON.stringify({
                type: 'closeKf', uid: uinfo.id
            }));

            setTimeout(function () {
                window.location.href = '/service/login/loginOut';
            }, 1000);
        }
    });
});

// 获取聊天记录
function getChatLog(uid, page, flag) {

    $.getJSON('/service/index/getChatLog', {uid: uid, page: page}, function(res){
        if(1 == res.code && res.data.length > 0){

            if(res.msg == res.total){
                var _html = '<div class="layui-flow-more">没有更多了</div>';
            }else{
                var _html = '<div class="layui-flow-more"><a href="javascript:;" data-page="' + parseInt(res.msg + 1)
                    + '" onclick="getMore(this)"><cite>更多记录</cite></a></div>';
            }

            var len = res.data.length;

            for(var i = 0; i < len; i++){
                var item = res.data[len - i - 1];

                if('mine' == item.type){

                    _html += '<li class="layim-chat-system"><span>' + item.time_line + '</span></li>'
                    _html += '<li class="layim-chat-li layim-chat-mine">';
                    _html += '<div class="layim-chat-user">';
                    _html += '<img src="' + item.from_avatar + '"><cite>我</cite></div>';
                    _html += '<div class="layim-chat-text">' + replaceContent(item.content) + ' </div></li>';

                }else {

                    _html += '<li class="layim-chat-system"><span>' + item.time_line + '</span></li>';
                    _html += '<li class="layim-chat-li">';
                    _html += '<div class="layim-chat-user">';
                    _html += '<img src="' + item.from_avatar + '"><cite>' + item.from_name + '</cite></div>';
                    _html += '<div class="layim-chat-text">' + replaceContent(item.content) + '</div></li>';
                }
            }

            if(typeof flag == 'undefined'){
                $('#customer-' + uid).html(_html);
                wordBottom();
            }else{
                $('#customer-' + uid).prepend(_html);
            }
        }
    });
}

// 获取更多
function getMore(obj){
    $(obj).remove();

    var page = $(obj).attr('data-page');
    getChatLog(page, 1);
}