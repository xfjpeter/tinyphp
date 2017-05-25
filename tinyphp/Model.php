<?php
/**
 * 模型基类
 * File Name : Model.php
 * Created by PhpStorm.
 * User: John<fsyzxz@163.com>
 * Date: 2017/03/25
 * Time: 下午 10:41
 */

namespace tinyphp;

use Medoo\Medoo;

class Model extends Medoo
{
    /**
     * Model constructor.
     */
    public function __construct()
    {
        $option = Config::getByFile('database');
        parent::__construct($option);
    }

    /**
     * 析构函数
     */
    public function __destruct()
    {
        // TODO: Implement __destruct() method.
        Log::init()->addCritical('本次执行的SQL信息:', $this->log());
    }
}
