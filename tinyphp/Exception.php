<?php
/**
 * 异常类
 * File Name : Exception.php
 * Created by PhpStorm.
 * User: John<fsyzxz@163.com>
 * Date: 2017/03/26
 * Time: 下午 9:23
 */

namespace tinyphp;

class Exception
{
    /**
     * Exception constructor.
     *
     * @param     $msg
     * @param int $type
     */
    public function __construct($msg, $type = E_USER_WARNING)
    {
        if ((APP_DEBUG || Config::get('APP_DEBUG')) && Config::get('SHOW_PAGE_TRACE') ) {
            trigger_error($msg, $type);
        } else {
            exit(Config::get('ERROR_MSG'));
        }
    }
}
