var htmlData = [
    '<div id="customized-widget">',
        '<div id="cs-groups">',
            '<a href="javascript:;">',
                '<div class="cs-groups__item" id="cs-pre-sales" data-group="1" style="color: white">',
                    '<span class="widget__icon"></span>售前客服',
                '</div>',
            '</a>',
            '<div class="widget__divider"></div>',
            '<a href="javascript:;">',
                '<div class="cs-groups__item" id="cs-after-sales" data-group="2" style="color: white">',
                    '<span class="widget__icon"></span>售后客服',
                '</div>',
            '</a>',
        '</div>',
        '<div id="widget-trigger" style="display: block;"></div>',
    '</div>'
].join("");

document.write(htmlData);

var whisper = function(){

    //var isOpen = 0;
    var baseConfig = {
        obj: null,
        id: 0
        ,whisper_domain: ''
        ,title: 'whisper客服'
        ,name: ''
        ,group: 0
        ,avatar: ''
    };

    var self = this;

    self.init = function(config){

        baseConfig = self.extend(baseConfig, config || {});
        if(0 == baseConfig.id || '' == baseConfig.url || '' == baseConfig.name
            || 0 == baseConfig.group || '' == baseConfig.avatar){

            alert("参数缺失");
            return false;
        }

        var url = baseConfig.whisper_domain + '/index/index/chat' + '?group=' + baseConfig.group + '&id=' + baseConfig.id +
            '&name=' + baseConfig.name + '&avatar=' + baseConfig.avatar;

        if(self.isMobile()){
            window.location.href = url;
        }else{
            baseConfig.obj.parent('a').attr('href', url);
        }
    };

    // 合并配置项
    self.extend = function(target, source){
        for (var obj in source) {
            target[obj] = source[obj];
        }
        return target;
    };

    // 打开窗口
    self.openWindow = function(url, name){
        layer.open({
            type: 2,
            id: 'whisper', // 允许打开一次
            title: name,
            shade: 0,
            area: ['800px', '640px'],
            content: url
        });
    };

    // 是否是移动端
    self.isMobile = function(){
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
};
