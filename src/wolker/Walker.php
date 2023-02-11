<?php

namespace App\Workerman\Wolker;

use App\Workerman\Config\ENV;
use App\Workerman\Geo\Geo;
use App\Workerman\Tgauth\Location;
use App\Workerman\Tgauth\Notification\Notification;
use App\Workerman\Tgauth\Notification\Type;
use App\Workerman\Tgauth\Order;
use App\Workerman\Tgauth\User;
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
        $ws_worker->onConnect = function (TcpConnection $connection)use(&$ws_worker){
            $connection->onWebSocketConnect = function($connection , $http_header)use(&$ws_worker)
            {
                if(($_GET['id']??'') !== '') {
                    new User($connection, $_GET['orders']??"",$_GET['id']??0);
                }
            };
            echo "New connection\n";
        };
// Emitted when data received
        $ws_worker->onMessage = function (TcpConnection $connection, $data) {
            foreach (User::getUsers() as $user) {
                if(!$user instanceof User) {
                    continue;
                }

                $data = json_decode($data);
                switch ($data->text??'/default') {
                    case '/location' && ($orders = Fns::intersectionOrders($user->orders, $data->orders??[]))!== []:
                        Geo::init()->request($data->token);
                        $notifi = new Notification(Type::ORDER);
                        foreach ($orders as $order) {
                            $notifi->add($order);
                        }
                        $point = (new Location());
                        $point = $point($data->location);
                        $notifi->add($point);
                        $user->connection->send($notifi->toJson());
                        break;

                }



                //$connect->send($data->ordersWithRoute);
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