<?php
/**
 * 基类控制器
 * File Name : Controller.php
 * Created by PhpStorm.
 * User: John<fsyzxz@163.com>
 * Date: 2017/03/25
 * Time: 下午 10:32
 */

namespace tinyphp;

class Controller
{
    private $smarty = null;
    
    private $data = null;
    
    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->smarty  = new \Smarty();
        $this->data    = $this->smarty->createData();
    }
    
    /**
     * 渲染模板
     *
     * @param string $tpl
     * @param array  $params
     *
     * @return string
     */
    protected function render($tpl = null, $params = null)
    {
        $st = $this->smarty;
        
        $theme_path = trim(Config::get('THEME_PATH'), '/');
        $theme_path = $theme_path ? $theme_path . '/' : '';
        
        // 模板文件路径
        $tpl_dir  = APP_PATH . __MODULE__ . '/view/' . $theme_path . __CONTROLLER__ . '/';
        $tpl_dir1 = APP_PATH . __MODULE__ . '/view/' . $theme_path;
        // 编译文件路径
        $com_dir = RUNTIME_PATH . __MODULE__ . '/' . __CONTROLLER__ . '/';
        // 缓存文件路径
        $cac_dir = RUNTIME_PATH . 'data/html/' . __CONTROLLER__ . '/';
        
        // 模板文件
        if (!$tpl) {
            // 如果不带模板文件
            $tpl = __ACTION__ . Config::get('TMPL_SUFFIX');
        }
        // 如果存在模板文件，不存在后缀名称，加上默认后缀名称
        if (!strstr($tpl, '.')) {
            $tpl .= Config::get('TMPL_SUFFIX');
        }
        
        // 如果模板文件不存在， 提示错误
        if (!is_file($tpl_dir . $tpl) && !is_file(TINYPHP_PATH . 'tpl/' . $tpl)) {
            new Exception($tpl_dir . $tpl . ' 模板文件不存在~~');
        } else {
            // 基本配置
            $st->setTemplateDir($tpl_dir); // 设置模板路径
            $st->addTemplateDir($tpl_dir1); // 设置模板路径
            $st->addTemplateDir(TINYPHP_PATH . 'tpl/');
            $st->setCompileDir($com_dir);  // 设置编译文件路径
            $st->setCacheDir($cac_dir);    // 设置缓存文件路径
            $st->left_delimiter  = Config::get('TMPL_LDELIM'); // 设置左定界符
            $st->right_delimiter = Config::get('TMPL_RDELIM'); // 设置右定界符
            $st->auto_literal    = Config::get('AUTO_LITERAL'); // 定界符两边是否有空格
            $st->caching         = Config::get('CACHE_HTML_MODE'); // 设置是否开启缓存
            $st->cache_lifetime  = Config::get('CACHE_HTML_TIME'); // 设置缓存生存时间
            
            
            // 解析参数
            if ($params && is_array($params)) {
                foreach ($params as $key => $value) {
                    $this->data->assign($key, $value);
                }
            }

            return $st->fetch($tpl, $this->data);
        }
    }
    
    /**
     * 变量赋值
     *
     * @param      $tpl_var
     * @param null $value
     * @param bool $nocache
     */
    protected function assign($tpl_var, $value = null, $nocache = false)
    {
        $this->data->assign($tpl_var, $value, $nocache);
    }
    
    /**
     * 重定向到指定url
     *
     * @param $uri
     */
    protected function redirect($uri)
    {
        header('Location:' . $uri);
    }
    
    /**
     * 错误显示
     *
     * @param     $msg
     * @param int $time
     *
     * @return string
     */
    protected function error($msg, $time = 3)
    {
        return $this->render('error', [
            'msg'  => $msg,
            'wait' => $time,
        ]);
    }
    
    /**
     * 成功之后跳转的页面
     *
     * @param        $msg
     * @param string $url
     * @param int    $time
     *
     * @return string
     */
    protected function success($msg, $url = '', $time = 3)
    {
        $url = Build::buildUrl($url);
        
        return $this->render('success', [
            'msg'  => $msg,
            'url'  => $url,
            'wait' => $time,
        ]);
    }
}
