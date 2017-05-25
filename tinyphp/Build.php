<?php
/**
 * 生成器
 * File Name : Build.php
 * Created by PhpStorm.
 * User: John<fsyzxz@163.com>
 * Date: 2017/03/25
 * Time: 下午 10:33
 */

namespace tinyphp;

class Build
{
    /**
     * 生成url
     *
     * @param $uri
     * @param array $params
     *
     * @return string|void
     */
    public static function buildUrl($uri, $params = [])
    {
        $url_mode    = Config::get('URL_MODE');
        $html_suffix = Config::get('HTML_SUFFIX');
        switch ($url_mode) {
            case 0: // 普通模式
                return self::buildCommonUri($uri, $params);
                break;
            case 1: // PATHINFO 模式
                return self::buildUri($uri, $html_suffix, 1, $params);
                break;
            case 2: // REWRITE 模式
                return self::buildUri($uri, $html_suffix, 2, $params);
                break;
            default: // 默认模式
        }
    }

    /**
     * 普通模式url生成
     * @param  string $uri    uri地址
     * @param  array  $params 参数
     * @return string         生成的url地址
     */
    private static function buildCommonUri($uri, $params = [])
    {
        // 一下是不跨模块的操作
        $uri = trim($uri, '/');
        $uri = explode('/', $uri);
        $len = count($uri);

        $module     = ($len>2) ? $uri[0] : Config::get('DEFAULT_MODULE');
        $controller = ($len>2) ? $uri[1] : $uri[0];
        $action     = ($len>2) ? $uri[2] : ($len>1 ? $uri[1] : Config::get('DEFAULT_ACTION'));

        $query = [
            Config::get('VAR_MODULE')     => $module,
            Config::get('VAR_CONTROLLER') => $controller,
            Config::get('VAR_ACTION')     => $action,
        ];
        $query = array_merge($query, $params);
        $query = http_build_query($query);
        return '?' . $query;
    }

    /**
     * PATHINFO 和 REWRITE模式
     *
     * @param $uri
     * @param $html_suffix
     * @param $type
     *
     * @return string
     */
    private static function buildUri($uri, $html_suffix, $type = 2, $params = [])
    {
        // 一下是不跨模块的操作
        $uri = trim($uri, '/');
        $uri = explode('/', $uri);
        $len = count($uri);
        if ($len > 2) { // 当大于2的时候说明传入了模块, 默认是当前模块
            $res = ($type == 2) ? '/' : '/index.php/';
            foreach ($uri as $item) {
                $res .= $item . '/';
            }
        } else { // 小于2的时候说明没有传入模块, 那么默认是当前模块
            $res = (($type == 2) ? '/' : '/index.php/') . __MODULE__ . '/';
            foreach ($uri as $item) {
                $res .= $item . '/';
            }
        }
        if (is_array($params) && !empty($params)) {
            foreach($params as $key=>$value) {
                $res .= $value . '/';
            }
        }
        $res = rtrim($res, '/') . $html_suffix;
        return $res;
        // TODO 暂时不支持跨模块调用
    }
}
