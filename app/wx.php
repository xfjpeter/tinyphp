<?php
/**
 * 微信配置文件
 * Created by PhpStorm.
 * User: johnxu
 * Date: 2017/4/2
 * Time: 16:23
 */

return [
    'TOKEN'     => '', // 微信TOKEN
    'APPID'     => '', // 微信appkey
    'APPSECRET' => '', // 微信appsecret
    
    'ACCESS_TOKEN_URI' => 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential', // 获取access_token的uri地址
    'MENU_CREATE_URI'  => 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token=', // 创建菜单uri地址
    'MENU_GET_URI'     => 'https://api.weixin.qq.com/cgi-bin/menu/get?access_token=', // 获取菜单列表uri地址
    'MENU_DEL_URI'     => 'https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=', // 删除菜单URI地址
];