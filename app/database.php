<?php
/**
 * 数据库配置文件
 * File Name : database.php
 * Created by PhpStorm.
 * User: John<fsyzxz@163.com>
 * Date: 2017/03/24
 * Time: 上午 8:40
 */

return [
    // 必须配置项
    'database_type' => 'mysql',
    'database_name' => 'test',
    'server'        => 'localhost',
    'username'      => 'root',
    'password'      => 'root',
    'charset'       => 'utf8',
    'debug_mode'    => 'true',

    // 可选参数
    'port'          => 3306,

    // 可选，定义表的前缀
    'prefix'        => 'c_',

    // 连接参数扩展, 更多参考 http://www.php.net/manual/en/pdo.setattribute.php
    'option'        => [
        PDO::ATTR_CASE => PDO::CASE_NATURAL,
    ],
];