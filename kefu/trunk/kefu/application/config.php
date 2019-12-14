<?php
return [
    // +----------------------------------------------------------------------
    // | 应用设置
    // +----------------------------------------------------------------------
    // 当前系统版本
    'version' => 'v1',

    // 加密盐
    'salt' => '~ChengLonG!@#',

    // 通信协议
    'protocol' => 'wss://',

    // socket server
    'socket' => 'workerman.mingbocs.com:8282',

    // 微信或者下程序客服地址
    'wx_kf_url' => '',

    // 管理员登录时间
    'save_time' => 86400,

    // 应用命名空间
    'app_namespace'          => 'app',
    // 应用调试模式
    'app_debug'              => false,
    // 应用Trace
    'app_trace'              => false,
    // 域名部署
    'url_domain_deploy'      => true,
];
