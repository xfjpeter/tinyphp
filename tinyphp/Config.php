<?php
/**
 * 配置管理器
 * File Name : Config.php
 * Created by PhpStorm.
 * User: John<fsyzxz@163.com>
 * Date: 2017/03/24
 * Time: 下午 8:03
 */

namespace tinyphp;

class Config
{
    private static $map = []; // 所有配置项的映射

    /**
     * 获取配置文件的值
     *
     * @param string $name
     *
     * @return mixed|null
     */
    public static function get($name)
    {
        $name = strtolower($name);
        if (isset(static::$map[ $name ])) {
            return static::$map[ $name ];
        }
        return null;
    }

    /**
     * 获取整个文件的配置信息
     * @param        $file
     * @param string $ext
     *
     * @return mixed
     */
    public static function getByFile($file, $ext = EXT)
    {
        if (!empty($file)) {
            $file = APP_PATH . $file . $ext;

            /** @noinspection PhpIncludeInspection */
            $file = include $file;
        }
        return $file;
    }

    /**
     * 设置配置文件的值
     *
     * @param string $name
     * @param string $value
     */
    public static function set($name, $value)
    {
        if (!isset(static::$map[ $name ])) {
            static::$map[ $name ] = $value;
        }
    }

    /**
     * 解析配置文件
     */
    public static function parseConfig()
    {
        if (!Cache::getInstance()->read('john_config')) {

            $conver = $config = $database = [];
            // 读取系统配置文件
            $conver = include TINYPHP_PATH . 'convert.php';

            // 读取APP_PATH下面的config.php和database.php
            $config_file = APP_PATH . 'config.php';
            if (is_file($config_file)) {
                /** @noinspection PhpIncludeInspection */
                $config = include $config_file;
            }
            $database_file = APP_PATH . 'database.php';
            if (is_file($database_file)) {
                /** @noinspection PhpIncludeInspection */
                $database = include $database_file;
            }

            $configs = array_change_key_case(array_merge($conver, $config, $database), CASE_LOWER);

            foreach ($configs as $key => $value) {
                static::$map[ $key ] = $value;
            }

            // 将配置文件写入缓存
            Cache::getInstance()->write('john_config', json_encode(static::$map), 10);

            unset($config, $database);
        } else {
            static::$map = json_decode(Cache::getInstance()->read('john_config'), true);
        }
    }

}
