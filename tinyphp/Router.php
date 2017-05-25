<?php
/**
 * 路由解析
 * File Name : Router.php
 * Created by PhpStorm.
 * User: John<fsyzxz@163.com>
 * Date: 2017/03/25
 * Time: 下午 10:09
 */

namespace tinyphp;

class Router
{
    /**
     * 路由调度器
     */
    public static function dispatch()
    {
        $url_mode = Config::get('URL_MODE') ? Config::get('URL_MODE') : 0;

        switch ($url_mode) {
            case 0: //普通模式
                self::commonUri();
                break;
            case 1: // PATHINFO模式
                self::otherUri();
                break;
            case 2: // rewrite模式
                self::otherUri();
                break;
            default:
                self::commonUri();
        }
    }

    /**
     * 普通路由
     */
    private static function commonUri()
    {
        $var_module     = Config::get('VAR_MODULE') ? Config::get('VAR_MODULE') : 'm';
        $var_controller = Config::get('VAR_CONTROLLER') ? Config::get('VAR_CONTROLLER') : 'c';
        $var_action     = Config::get('VAR_ACTION') ? Config::get('VAR_ACTION') : 'a';

        $module     = Request::get($var_module);
        $module     = !empty($module) ? $module : Config::get('DEFAULT_MODULE');
        $controller = Request::get($var_controller);
        $controller = !empty($controller) ? $controller : Config::get('DEFAULT_CONTROLLER');
        $action     = Request::get($var_action);
        $action     = !empty($action) ? $action : Config::get('DEFAULT_ACTION');

        // 解析多余的参数, 绑定到操作的参数中
        $query_string = Request::exec('QUERY_STRING', 'server');
        $query_string = str_replace($var_module . '=' . $module, '', $query_string);
        $query_string = str_replace($var_controller . '=' . $controller, '', $query_string);
        $query_string = str_replace($var_action . '=' . $action, '', $query_string);
        $query_string = trim($query_string, '&,?');
        $query_string = explode('&', $query_string);
        $params = [];
        $len    = count($query_string);
        if ($len > 0) {
            for ($i = 0; $i < $len; $i++) {
                if (!empty($query_string[ $i ])) {
                    if (strstr($query_string[ $i ], '=')) {
                        $arr      = explode('=', $query_string[ $i ]);
                        $params[] = $arr[1];
                    }
                }
            }
        }

        self::exec($module, $controller, $action, $params);
    }

    /**
     * PATHINFO 和 REWRITE模式的路由
     */
    private static function otherUri()
    {
        global $argv;
        // $request_uri = Request::exec('REQUEST_URI', 'server');
        $request_uri = IS_CLI ? $argv[1] : Request::exec('REQUEST_URI', 'server');
        $rules       = Config::getByFile('route');

        // 替换路由
        if (is_array($rules) && !empty($rules)) {
            foreach ($rules as $key => $item) {
                $request_uri = str_replace($key, $item, $request_uri);
            }
        }

        $request_uri = str_replace('/index.php/', '', $request_uri);
        $request_uri = str_replace(Config::get('HTML_SUFFIX'), '', $request_uri);
        $request_uri = trim($request_uri, '/');
        $request_uri = explode('/', $request_uri);
        
        // 解析多余的为参数, 按顺序解析参数
        $params = [];
        $len    = count($request_uri);
        if ($len > 3) {
            for ($i = 3; $i < $len; $i++) {
                $params[] = $request_uri[ $i ];
            }
        }


        if ($len > 2) {
            $module     = !empty($request_uri[0]) ? $request_uri[0] : Config::get('DEFAULT_MODULE');
            $controller = !empty($request_uri[1]) ? $request_uri[1] : Config::get('DEFAULT_CONTROLLER');
            $action     = !empty($request_uri[2]) ? $request_uri[2] : Config::get('DEFAULT_ACTION');
        } elseif ($len >= 1) {
            $module     = !empty($request_uri[0]) ? $request_uri[0] : Config::get('DEFAULT_MODULE');
            $controller = !empty($request_uri[1]) ? $request_uri[1] : Config::get('DEFAULT_CONTROLLER');
            $action     = Config::get('DEFAULT_ACTION');
        } else {
            $module     = Config::get('DEFAULT_MODULE');
            $controller = !empty($request_uri[0]) ? $request_uri[0] : Config::get('DEFAULT_CONTROLLER');
            $action     = !empty($request_uri[1]) ? $request_uri[1] : Config::get('DEFAULT_ACTION');
        }
        self::exec($module, $controller, $action, $params);
    }

    /**
     * 执行操作
     *
     * @param string $module     模块名称
     * @param string $controller 控制器名称
     * @param string $action     操作名称
     * @param array  $params     参数
     */
    private static function exec($module, $controller, $action, $params = [])
    {
        // 实例化模块下面的类
        $class_file = 'app\\' . $module . '\\controller\\' . ucfirst($controller);

        if (class_exists($class_file)) {
            $class = new $class_file;
            if (method_exists($class, $action)) {
                // 设置当前的控制器名称、模块名称、操作方法
                define('__MODULE__', $module);
                define('__CONTROLLER__', ucfirst($controller));

                define('__ACTION__', $action);
                // 获取该控制器的公共方法
                $methods = get_class_methods($class);
                if (in_array($action, $methods)) {
                    $result = call_user_func_array([$class, $action], $params);
                } else {
                    new Exception('非法操作: ' . $action);
                }

                if (is_array($result) || is_object($result)) {
                    Response::json(200, '', (array)$result);
                } else {
                    Response::html(200, $result);
                }
                // 记录结束运行时间
                $GLOBALS['_endTime'] = microtime(true);
            } else {
                new Exception('非法操作: ' . $action);
            }
        } else {
            new Exception('没有找到控制器:' . $class_file);
        }

        // 显示调试信息
        if ((APP_DEBUG || Config::get('APP_DEBUG')) && Config::get('SHOW_PAGE_TRACE')) {
            Handle::show();
        }
    }
}
