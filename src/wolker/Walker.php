<?php

namespace App\Workerman\Wolker;

use App\Workerman\Config\ENV;
use Symfony\Component\Dotenv\Dotenv;
use Workerman\Connection\TcpConnection;
use Workerman\Worker;

class Walker
{
    public function init(): Worker
    {
        // Create a Websocket server
        ENV::init();

        $ws_worker = new Worker($_ENV['WEBSOCKET']);

// Emitted when new connection come
        $ws_worker->onConnect = function (TcpConnection $connection) {

            echo "New connection\n";
        };
// Emitted when data received
        $ws_worker->onMessage = function (TcpConnection $connection, $data)use($ws_worker) {

            foreach ($ws_worker->connections as $connect) {
                if(!$connect instanceof TcpConnection) {
                    continue;
                }
                $connect->send($data);
            }
//             Send hello $data
            //$connection->send($data);
        };
// Emitted when connection closed
        $ws_worker->onClose = function (TcpConnection $connection) {
            echo "Connection closed\n";
        };

        return $ws_worker;
    }
}