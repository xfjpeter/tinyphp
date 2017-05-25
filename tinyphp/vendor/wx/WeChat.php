<?php
/**
 * User: johnxu <fsyzxz@163.com> 549716096
 * HomePage: http://www.johnxu.net
 * Date: 2017/5/17
 */

namespace tinyphp\vendor\wx;

use tinyphp\Request;

class WeChat
{
    private $appid;
    private $secret;
    private $token;

    public function __construct($appid, $secret, $token)
    {
        $this->appid  = $appid;
        $this->secret = $secret;
        $this->token  = $token;
    }

    public function valid()
    {
        $echostr = Request::get('echostr');
        if ( $this->checkSignature() ) {
            echo $echostr;
            exit;
        }
    }

    /**
     * 校验签名串
     * @return bool
     */
    private function checkSignature()
    {
        $token     = $this->token;
        $signature = Request::get('signature');
        $timestamp = Request::get('timestamp');
        $nonce     = Request::get('nonce');
        $tmpArr    = [$token, $timestamp, $nonce];
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }
}