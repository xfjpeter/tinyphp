<?php
/**
 * 网站配置文件
 * File Name : config.php
 * Created by PhpStorm.
 * User: John<fsyzxz@163.com>
 * Date: 2017/03/24
 * Time: 上午 8:40
 */

return [
    'APP_DEBUG' => true, // 是否开启调试模式

    'SESSION_AUTO_START' => true, // 是否自动开启session功能

    'DEFAULT_MODULE'     => 'index',  // 默认模块
    'DEFAULT_CONTROLLER' => 'Index', // 默认控制器
    'DEFAULT_ACTION'     => 'index', // 默认操作

    'VAR_MODULE'     => 'm', // 默认模块获取变量
    'VAR_CONTROLLER' => 'c', // 默认控制器获取变量
    'VAR_ACTION'     => 'a', // 默认操作获取变量

    'HELPER_FUNC' => ['helper'], // 助手函数, 用数组

    'TMPL_SUFFIX'  => '.html', // 模板文件后缀名
    'HTML_SUFFIX'  => '.shtml', // 静态html文件后缀
    'TMPL_LDELIM'  => '<%', // 左定界符
    'TMPL_RDELIM'  => '%>', // 右定界符
    'AUTO_LITERAL' => false, // 定界符两边是否有空格

    // 'TMPL_PATH'  => 'default', // 默认主题名称
    'THEME_PATH'   => '', // 默认主题名称

    'ERROR_MSG' => '页面错误~~',

    'SHOW_PAGE_TRACE' => true, // 是否显示调试信息

    'URL_MODE' => 2, // 0普通模式, 1PATHINFO模式, 2REWRITE模式

    'CACHE_MODE'       => 'file', // 缓存方式（file：文件缓存，memcached：memcached缓存方式，需要配置memcached参数）
    'CACHE_HTML_MODE'  => false, // 是否开启静态html文件缓存
    'CACHE_HTML_TIME'  => 10, // 缓存html静态文件的时间，单位s
    'CACHE_HTML_EXT'   => '.html', // 缓存html静态文件的后缀名称
    'CACHE_HTML_SPACE' => true, // 是否去除html空格和换行，true去除，false不去除


    // MEMCACHED 缓存配置项
    'MEMCACHED'        => [
        [
            'host'           => '127.0.0.1', // 主机地址
            'port'           => 11211, // 端口号
            'timeout'        => 1, // 超时时间, 默认是1s
            'persistent'     => true, // 是否持久化连接, 默认是true
            'retry_interval' => 15, // 服务器连接失败重试连接时间间隔,默认15s
            'status'         => true, // 控制此服务器是否可以被标记为在线状态
        ],
    ],

    // 微信小程序配置文件
    'wx'       => [
        'appid'          => 'wx0d01121ebb6224f7',
        'token'          => 'fcb03dc9788e5a2141dcbe4acf69aa13',
        'secret'         => '6cbde6fceb3c480b19a3c924a48583c1',
        'encodingAesKey' => 'loebnYChTpLwo34Gvqyklpurv1kkEFd3Xtpq1wEewks',
    ],

    /**
     * ========================================================
     * 以下是图灵机器人配置文件
     * ========================================================
     */
    'T_APPKEY' => 'f94113df800a4571804941a353ab46e3',
    'T_SECRET' => 'ee0dd67c02dca4c3',
    'T_APIURI' => 'http://www.tuling123.com/openapi/api',

    /**
     * ========================================================
     * 图灵机器人配置文件结束
     * ========================================================
    */

];
