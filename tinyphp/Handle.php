<?php
/**
 * 错误异常处理类
 * File Name : Handle.php
 * Created by PhpStorm.
 * User: John<fsyzxz@163.com>
 * Date: 2017/03/29
 * Time: 上午 8:41
 */

namespace tinyphp;

/**
 * 错误异常处理类
 * Class Handle
 * @package tinyphp
 */
class Handle
{
    private static $errors = []; // 保存错误信息

    /**
     * 错误处理类
     *
     * @param $errno      错误号
     * @param $errstr     错误类型
     * @param $errfile    错误文件
     * @param $errline    错误行
     * @param $errcontext 参数
     */
    public static function error($errno, $errstr, $errfile, $errline, $errcontext)
    {
        $errtype        = self::getErrType($errno);
        self::$errors[] = [
            'err_type'    => $errtype,
            'err_str'     => $errstr,
            'err_file'    => $errfile,
            'err_line'    => $errline,
            'err_context' => $errcontext,
        ];
    }

    /**
     * 显示提示信息页
     */
    public static function show()
    {
        $message_tpl = TINYPHP_PATH . 'tpl/message.html';
        if (is_file($message_tpl)) {
            $message_content = file_get_contents($message_tpl);
            // 替换文件列表
            $files = '';
            foreach (get_included_files() as $key => $item) {
                $key += 1;
                $size = round(filesize($item) / 1024, 2);
                $files .= "<p>{$key}: {$item} ({$size}kb)</p>";
            }
            $message_content = str_replace('{$files}', $files, $message_content);
            // 替换脚本运行时间
            $GLOBALS['_endTime'] = isset($GLOBALS['_endTime']) ? $GLOBALS['_endTime'] : microtime(true);
            $time                = round($GLOBALS['_endTime'] - $GLOBALS['_beginTime'], 4) . ' s';
            $message_content     = str_replace('{$time}', $time, $message_content);
            // 替换错误信息
            $errors = '<br>';
            foreach (self::$errors as $key => $item) {
                $errors .= "<p>错误类型: {$item['err_type']}</p>";
                $errors .= "<p>错误提示: {$item['err_str']}</p>";
                $errors .= "<p>错误行数: {$item['err_line']}</p>";
                $errors .= "<p>文件位置: {$item['err_file']}</p>";
            }
            $message_content = str_replace('{$errmsg}', $errors, $message_content);
            $context         = '';
            foreach (self::$errors as $item) {
                $params = var_export($item['err_context'], true);
                $context .= "{$params}";
            }
            $message_content = str_replace('{$context}', $context, $message_content);
            // 替换session
            $session         = '<p>' . session_name() . '=' . (session_id() ? session_id() : '没有session会话') . '</p>';
            $message_content = str_replace('{$session}', $session, $message_content);
            if (MEMORY_LIMIT_ON) $GLOBALS['_endUseMems'] = memory_get_usage();
            $memory          = '<p>一共消耗内存:' . (round((($GLOBALS['_endUseMems'] - $GLOBALS['_startUseMems']) / 1024 / 1024), 2)) . 'MB</p>';
            $message_content = str_replace('{$memory}', $memory, $message_content);
            Response::html(200, $message_content);
        }
    }

    /**
     * 通过错误号获取错误类型
     *
     * @param $errno
     *
     * @return string
     */
    private static function getErrType($errno)
    {
        switch ($errno) {
            case E_WARNING: // 运行时警告 (非致命错误)。仅给出提示信息，但是脚本不会终止运行。
            case E_CORE_WARNING: // PHP初始化启动过程中发生的警告 (非致命错误) 。类似 E_WARNING，但是是由PHP引擎核心产生的。
            case E_USER_WARNING: // 用户产生的错误信息。类似 E_ERROR, 但是是由用户自己在代码中使用PHP函数 trigger_error()来产生的。
            case E_COMPILE_WARNING: //编译时警告 (非致命错误)。类似 E_WARNING，但是是由Zend脚本引擎产生的。
                $errtype = 'WARNING';
                break;
            case E_NOTICE: // 运行时通知。表示脚本遇到可能会表现为错误的情况，但是在可以正常运行的脚本里面也可能会有类似的通知。
            case E_USER_NOTICE: // 用户产生的通知信息。类似 E_NOTICE, 但是是由用户自己在代码中使用PHP函数 trigger_error()来产生的。
                $errtype = 'NOTICE';
                break;
            case E_DEPRECATED: // 运行时通知。启用后将会对在未来版本中可能无法正常工作的代码给出警告。
            case E_USER_DEPRECATED: // 用户产少的警告信息。 类似 E_DEPRECATED, 但是是由用户自己在代码中使用PHP函数 trigger_error()来产生的。
                $errtype = 'DEPRECATED';
                break;
            case E_ERROR: // 致命的运行时错误。这类错误一般是不可恢复的情况，例如内存分配导致的问题。后果是导致脚本终止不再继续运行。
            case E_CORE_ERROR: // 在PHP初始化启动过程中发生的致命错误。该错误类似 E_ERROR，但是是由PHP引擎核心产生的。
            case E_COMPILE_ERROR: // 致命编译时错误。类似E_ERROR, 但是是由Zend脚本引擎产生的。
            case E_USER_ERROR: // 用户产生的错误信息。类似 E_ERROR, 但是是由用户自己在代码中使用PHP函数 trigger_error()来产生的。
            case E_RECOVERABLE_ERROR: // 可被捕捉的致命错误。 它表示发生了一个可能非常危险的错误，但是还没有导致PHP引擎处于不稳定的状态。 如果该错误没有被用户自定义句柄捕获 (参见 set_error_handler())，将成为一个 E_ERROR　从而脚本会终止运行。
                $errtype = 'ERROR';
                break;
            case E_STRICT: // 启用 PHP 对代码的修改建议，以确保代码具有最佳的互操作性和向前兼容性。
                $errtype = 'STRICT';
                break;
            case E_PARSE:
                $errtype = 'PARSE';
                break;
            case E_ALL:
                $errtype = 'ALL';
                break;
            default :
                $errtype = null;
        }

        return $errtype;
    }
}
