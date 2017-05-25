<?php
/**
 * File Name : Hook.php
 * Created by PhpStorm.
 * User: John<fsyzxz@163.com>
 * Date: 2017/03/28
 * Time: 下午 7:19
 */

namespace tinyphp;

class Hook
{
    # 钩子列表
    private static $action = [];

    /**
     * 添加钩子
     *
     * @param string $hook     钩子名称
     * @param string $function 具体的方法
     *
     * @return boolean
     */
    public static function add_action($hook, $function)
    {
        $hook = mb_strtolower($hook);
        if (!self::exists_action($hook)) {
            self::$action[ $hook ] = [];
        }

        if (is_callable($function)) {
            self::$action[ $hook ][] = $function;

            return true;
        }

        return false;
    }

    /**
     * 执行钩子
     *
     * @param string $hook   钩子名称
     * @param mixed  $params 参数
     *
     * @return bool
     */
    public static function do_action($hook, $params = null)
    {
        $hook = mb_strtolower($hook);
        if (isset(self::$action[ $hook ])) {
            foreach (self::$action[ $hook ] as $function) {
                if (is_array($params)) {
                    call_user_func_array($function, $params);
                } else {
                    call_user_func($function, $params);
                }
            }

            return true;
        }

        return false;
    }

    /**
     * 获取钩子列表
     *
     * @param string $hook 钩子名称
     *
     * @return bool | string
     */
    public static function get_action($hook)
    {
        $hook = mb_strtolower($hook);

        return (isset(self::$action[ $hook ])) ? self::$action[ $hook ] : false;
    }

    /**
     * 判断钩子是否存在
     *
     * @param string $hook 钩子名称
     *
     * @return boolean
     */
    public static function exists_action($hook)
    {
        $hook = mb_strtolower($hook);

        return (isset(self::$action[ $hook ])) ? true : false;
    }
}

/**
 * 快捷添加钩子函数
 * @param $hook 钩子名称
 * @param $function
 *
 * @return bool
 */
function add_action($hook, $function)
{
    return Hook::add_action($hook, $function);
}

/**
 * 快捷执行钩子函数
 * @param $hook 钩子名称
 *
 * @return bool
 */
function do_action($hook)
{
    return Hook::do_action($hook);
}
