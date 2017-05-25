<?php
namespace app\server\controller;

use tinyphp\Server;

class Push extends Server
{
    protected $socket = 'websocket://0.0.0.0:2345';
    protected $processes  = 1;

    public function onConnect( $connection )
    {
        $connection->send( '欢迎您使用群聊服务！' );
    }

    public function onMessage( $connection, $data )
    {
        parse_str( $data, $res );
        if ( isset( $res['type'] ) ) {
            switch( $res['type'] ){
                case 'all' :
                    $this->sendAll( $res );
            }
        }
        // foreach ( $this->worker->connections as $conn ) {
        //     $conn -> send( $data );
        // }
    }

    private function sendAll( $res )
    {
        $data = isset( $res['content'] ) ? $res['content'] : '';
        foreach( $this->worker->connections as $conn ) {
            $conn -> send( $data );
        }
    }

    public function onClose( $connection )
    {
        foreach ( $this->worker->connections as $conn ) {
            $conn -> send( '有人下线了' );
        }
    }
}
