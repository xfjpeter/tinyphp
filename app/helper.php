<?php
/**
 * 助手函数
 * File Name : helper.php
 * Created by PhpStorm.
 * User: John<fsyzxz@163.com>
 * Date: 2017/03/24
 * Time: 下午 9:41
 */

if (!function_exists('debug')) {
    /**
     * 打印调试信息
     *
     * @param      $var
     * @param bool $dump
     * @param bool $exit
     */
    function debug($var, $dump = false, $exit = true)
    {
        if ($dump) {
            $func = 'var_dump';
        } else {
            $func = (is_array($var) || is_object($var)) ? 'print_r' : 'sprintf';
        }
        echo 'debug info:<br>';
        echo '<pre>';
        echo $func($var);
        echo '</pre>';
        if ($exit) exit;
    }
}

if (!function_exists('controller')) {
    /**
     * 调用控制器
     *
     * @param        $controller
     * @param string $method
     * @param string  $params
     *
     * @return mixed
     */
    function controller($controller, $method = '', $params = '')
    {
        if ($len = strpos($controller, '@')) { // 跨模块调用
            $module     = mb_substr($controller, 0, $len);
            $controller = mb_substr($controller, $len + 1);
        } else { // 本模块调用
            $module = __MODULE__;
        }
        $class_name = 'app\\' . $module . '\\controller\\' . ucfirst($controller);
        $class      = new $class_name;
        if ( !is_array($params) ) {
            $params = [ $params ];
        }
        if (!empty($method)) {
            if (class_exists($class_name) && method_exists($class, $method)) {
                return call_user_func_array([$class, $method], $params);
            } else {
                new \tinyphp\Exception('非法操作~~');
            }
        } else {
            return $class;
        }
        return null;
    }
}

if (!function_exists('url')){
    /**
     * 解析url地址
     * @param  string $uri   
     * @param  array  $param 
     * @return string
     */
    function url($uri, $param = []) {
        return \tinyphp\Build::buildUrl($uri, $param);
    }
}

if(!function_exists('crs_token')) {
    /**
     * 表单token
     * @return string
     */
    function crs_token() {
        $crs_token = $_SESSION['crs_token'] = base64_encode(md5('john_' . uniqid() . time()));
        return '<input type="hidden" name="crs_token" in="crs_token" value="'.$crs_token.'">';
    }
}

if(!function_exists('check_crs_token')) {
    /**
     * 验证crs_token是否正确
     * @param  string $crs_token 表单提交的crs_toke
     * @return boolean
     */
    function check_crs_token($crs_token) {
        $session_crs_token = $_SESSION['crs_token'];
        if ($crs_token === $session_crs_token) {
            unset($_SESSION['crs_token']);
            return true;
        } else {
            return false;
        }
    }
}