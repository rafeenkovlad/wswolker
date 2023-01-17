<?php

namespace Rafee\Workerman\Wolker;

use Workerman\Connection\TcpConnection;
use Workerman\Worker;

class Walker
{
    public function init(): Worker
    {
        // Create a Websocket server
        $ws_worker = new Worker('websocket://0.0.0.0:2346');

// Emitted when new connection come
        $ws_worker->onConnect = function (TcpConnection $connection) {
            echo "New connection\n";
        };
// Emitted when data received
        $ws_worker->onMessage = function (TcpConnection $connection, $data) {
            // Send hello $data

            $connection->send('Hello ' . $data);
        };

// Emitted when connection closed
        $ws_worker->onClose = function (TcpConnection $connection) {
            echo "Connection closed\n";
        };

        return $ws_worker;
    }
}