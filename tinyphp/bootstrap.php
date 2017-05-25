<?php
/**
 * 框架引导
 * File Name : bootstrap.php
 * Created by PhpStorm.
 * User: John<fsyzxz@163.com>
 * Date: 2017/03/24
 * Time: 上午 9:14
 */

define('IS_TINYPHP', true);

// 记录开始运行时间
$GLOBALS['_beginTime'] = microtime(true);

// 记录内存初始使用
define('MEMORY_LIMIT_ON', function_exists('memory_get_usage'));
if (MEMORY_LIMIT_ON) $GLOBALS['_startUseMems'] = memory_get_usage();

// 版本信息
const VERSION = '2.4';

// 类文件后缀
const EXT = '.php';

// 设置默认时区
date_default_timezone_set('PRC');

// 设置默认的字符集编码
header('Content-Type:text/html;charset=UTF-8');

defined('ROOT_PATH') or define('ROOT_PATH', dirname(dirname(__FILE__)) . '/'); // 根路径
defined('TINYPHP_PATH') or define('TINYPHP_PATH', __DIR__ . '/'); // 核心框架路径
defined('APP_PATH') or define('APP_PATH', dirname(dirname($_SERVER['SCRIPT_FILENAME'])) . '/'); // 应用路径
defined('APP_DEBUG') or define('APP_DEBUG', false); // 是否调试模式

defined('RUNTIME_PATH') or define('RUNTIME_PATH', APP_PATH . 'Runtime/');   // 系统运行时目录

// 系统信息
if (version_compare(PHP_VERSION, '5.4.0', '<')) {
    ini_set('magic_quotes_runtime', 0);
    /** @noinspection PhpDeprecationInspection */
    define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc() ? true : false);
} else {
    define('MAGIC_QUOTES_GPC', false);
}

define('IS_CGI', (0 === strpos(PHP_SAPI, 'cgi') || false !== strpos(PHP_SAPI, 'fcgi')) ? 1 : 0);
define('IS_WIN', strstr(PHP_OS, 'WIN') ? 1 : 0);
define('IS_CLI', PHP_SAPI == 'cli' ? 1 : 0);

// 引入应用类
$path = TINYPHP_PATH . 'App' . EXT;

/** @noinspection PhpIncludeInspection */
require $path;
// 是否显示错误报告
if (defined('APP_DEBUG') && APP_DEBUG) {
    error_reporting(1);
} else {
    error_reporting(0);
}
\tinyphp\App::init();
