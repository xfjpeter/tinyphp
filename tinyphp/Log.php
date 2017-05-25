<?php
/**
 * 日志记录类
 * File Name : Log.php
 * Created by PhpStorm.
 * User: John<fsyzxz@163.com>
 * Date: 2017/03/30
 * Time: 上午 8:01
 */

namespace tinyphp;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;


class Log extends Logger
{
    /**
     * 初始化日志记录
     *
     * @param string $name 日志记录名称
     * @param string $path 日志文件名称
     *
     * @return Logger
     */
    public static function init($name = '', $path = '')
    {
        $name = $name ? $name : 'logger_file';
        $path = $path ? $path : RUNTIME_PATH . 'Log/' . date('Y-m-d') . '/' . __MODULE__ . '_' . __CONTROLLER__ . '.log';
        $log  = new Logger($name);
        $log->pushHandler(new StreamHandler($path, Logger::WARNING));

        return $log;
    }
}