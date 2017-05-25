<?php
/**
 * File Name : index.php
 * Created by PhpStorm.
 * User: John<fsyzxz@163.com>
 * Date: 2017/03/24
 * Time: 上午 8:38
 */

// 关闭xss攻击

if (version_compare(PHP_VERSION, '5.4.0', '<')) {
    exit('请升级PHP版本到5.4.0以上再使用~~');
}

define('APP_PATH', dirname(dirname(__FILE__)) . '/app/');

define('APP_DEBUG', true);

require '../tinyphp/bootstrap.php';
