<?php
/**
 * 数据库操作类
 * File Name : Db.php
 * Created by PhpStorm.
 * User: John<fsyzxz@163.com>
 * Date: 2017/03/24
 * Time: 下午 9:05
 */

namespace tinyphp;

use Medoo\Medoo;

class Db
{
    private static $_db = null; // Medoo对象

    /**
     * 构造函数
     *
     * @param array $config
     */
    private function __construct($config = [])
    {
        $config    = !empty($config) ? $config : Config::getByFile('database');
        self::$_db = new Medoo($config);
    }

    /**
     * 初始化数据库类
     *
     * @param array $config
     *
     * @return Medoo|null
     */
    public static function init($config = [])
    {
        if (!static::$_db instanceof Medoo) {
            new self($config);
        }

        return static::$_db;
    }

    /**
     * 动态调用方法
     *
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
        self::init();

        return call_user_func_array([self::$_db, $name], $arguments);
    }

    /**
     * 静态调用方法
     *
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        // TODO: Implement __callStatic() method.
        // 先调用init方法
        self::init();

        return call_user_func_array([self::$_db, $name], $arguments);
    }
}
