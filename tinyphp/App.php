<?php

/**
 * 应用类文件
 * File Name : App.php
 * Created by PhpStorm.
 * User: John<fsyzxz@163.com>
 * Date: 2017/03/25
 * Time: 下午 10:04
 */

namespace tinyphp;

class App
{
    private static $_map = [];
    /**
     * 初始化
     */
    public static function init()
    {
        // 注册自动加载
        spl_autoload_register('tinyphp\App::autoload');

        // 设置错误句柄
        set_error_handler(['tinyphp\Handle', 'error'], E_ALL);

        // 加载composer扩展
        $composer = ROOT_PATH . 'vendor/autoload.php';
        if (is_file($composer)) {
            /** @noinspection PhpIncludeInspection */
            require_once $composer;
        }

        // 加载配置文件
        Config::parseConfig();

        // 是否自动开启session
        if (Config::get('SESSION_AUTO_START')) {
            session_start();
        }

        // 加载助手函数
        if ($helper = Config::get('helper_func')) {
            if (is_array($helper)) {
                foreach ($helper as $item) {
                    $file = APP_PATH . $item . EXT;
                    if (is_file($file)) {
                        /** @noinspection PhpIncludeInspection */
                        include $file;
                        unset($file);
                    }
                }
            }
        }

        // 解析路由
        Router::dispatch();
    }

    /**
     * 自动加载类
     *
     * @param $class
     */
    public static function autoload($class)
    {
        // 实现自动加载
        $file = ROOT_PATH . str_replace('\\', '/', $class) . EXT;
        if (is_file($file)) {
            if (!isset(self::$_map[$file])) {
                /** @noinspection PhpIncludeInspection */
                include_once $file;
                unset($file);
            }
        }
    }
}
