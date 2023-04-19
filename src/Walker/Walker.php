<?php

namespace App\Workerman\Walker;

use App\Workerman\Config\ENV;
use App\Workerman\Geo\Geo;
use App\Workerman\Tgauth\Location;
use App\Workerman\Tgauth\Notification\Notification;
use App\Workerman\Tgauth\Notification\Type;
use App\Workerman\Tgauth\Notification\Types\OrderNotifiType;
use App\Workerman\Tgauth\Order;
use App\Workerman\Tgauth\Tgauth;
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
            $connection->onWebSocketConnect = function(TcpConnection $connection , $http_header)use(&$ws_worker)
            {
                try{
                    Fns::freez();
                    if(!isset($_GET['token'])) {
                        $connection->onClose = function (TcpConnection $connection) {
                            $connection->send('token not found');
                            echo "Connection closed - token not found\n";
                        };
                    }
                    Fns::token($_GET['token']);
                    $payload = Tgauth::init()->request(Fns::token());
                    Fns::payload($payload);


                }catch (\Throwable $ex) {
                    echo $ex->getMessage();
                    $connection->onClose = function (TcpConnection $connection) {
                        $connection->send('bad credentials');
                        echo "Connection closed - bad credentials\n";
                    };
                }

                $user = new User($connection, Fns::payload()->orders??null ,Fns::payload()->data->ownerId??null, Fns::token());
                Fns::user($user);
                Fns::rm();
            };
            echo "New connection\n";
        };
// Emitted when data received
        $ws_worker->onMessage = function (TcpConnection $connection, $data) {
            foreach (User::getUsers() as $user) {
                if(!$user instanceof User) {
                    continue;
                }
                if(is_string($data)) {
                    $data = json_decode($data);
                }
                switch ($data->text??'/default') {
                    case '/location' && ($orders = Fns::intersectionOrders($user->orders, $data->orders??[]))!== []:
                        $notifi = new Notification(Type::ORDER);
                        foreach ($orders as $order) {
                            $notifi->add($order);
                        }
                        $point = (new Location());
                        $point = $point($data->location);
                        $notifi->add($point);
                        $user->connection->send($notifi->toJson());
                        Geo::init()->request(User::getUser($connection)->getToken(), $point, $user);
                        $orders = [];
                        break;

                }

//                foreach ($data as $key=>$val) {
//                    unset($data->{$key});
//                }

                //$connect->send($data->ordersWithRoute);
            }
//             Send hello $data
            //$connection->send($data);
        };
// Emitted when connection closed
        $ws_worker->onClose = function (TcpConnection $connection) {
            User::remove($connection);
            echo "Connection closed\n";
        };

        return $ws_worker;
    }
}