<?php
return array(
    //数据库配置
    //'配置项'=>'配置值'
    'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  '127.0.0.1', // 服务器地址
    'DB_NAME'               =>  'shop',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  'root',          // 密码
    'DB_PORT'               =>  '3306',        // 端口
    'DB_PREFIX'             =>  'sp_',    // 数据库表前缀
    //跟踪信息
    'SHOW_PAGE_TRACE'       =>  true,
    //以下是伪静态和常量配置
    'TMPL_TEMPLATE_SUFFIX'  =>  '.html',// 默认模板文件后缀
    'URL_HTML_SUFFIX'       =>  'html',  // URL伪静态后缀设置
    'URL_ROUTER_ON'         =>  true,   // 是否开启URL路由
    'URL_ROUTE_RULES'       =>  array(
        'login'             =>  'Admin/Test/index',
    ), // 默认路由规则 针对模块
    'TMPL_PARSE_STRING' => array(
                   '__HOME__'  =>  __ROOT__.'/Public/Home',
                   '__ADMIN__' =>  __ROOT__.'/Public/Admin',
                   '__PLUGINS__' => __ROOT__.'/Public/plugins',
    ),
);