<?php
/**
 * File Name : Index.php
 * Created by PhpStorm.
 * User: John<fsyzxz@163.com>
 * Date: 2017/03/25
 * Time: 下午 10:08
 */

namespace app\index\controller;

use tinyphp\Controller;
use tinyphp\Request;

class Index extends Controller
{
    /**
     * 首页控制器
     * @method index
     */
    public function index()
    {
        return $this->render();
    }

}
