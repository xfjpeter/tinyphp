<?php

namespace tinyphp;

use Workerman\Worker;

abstract class Server
{
    protected $worker;
    protected $socket    = '';
    protected $protocol  = 'http';
    protected $host      = '0.0.0.0';
    protected $port      = '2346';
    protected $processes = 1;

    public function __construct()
    {
        // 实例化 Websocket 服务
        $this->worker = new Worker($this->socket ?: $this->protocol . '://' . $this->host . ':' . $this->port);
        // 设置进程数
        $this->worker->count = $this->processes;

        // 设置回调
        foreach (['onWorkerStart', 'onConnect', 'onMessage', 'onClose', 'onError', 'onBufferFull', 'onBufferDrain', 'onWorkerStop', 'onWorkerReload'] as $event) {
            if (method_exists($this, $event)) {
                $this->worker->$event = [$this, $event];
            }
        }
        // Run worker
        Worker::runAll();
    }

    protected function init()
    {
    }
}
