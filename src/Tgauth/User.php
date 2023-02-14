<?php


namespace App\Workerman\Tgauth;


use Workerman\Connection\TcpConnection;
use Workerman\Worker;

class User
{
    public TcpConnection $connection;
    public array $orders = [];
    public int $id;
    private string $token;
    private static array $users = [];

    public function __construct(TcpConnection $connection, ?array $orders, ?int $id, string $token)
    {
        if($id === null) {
            return;
        }

        $this->connection = $connection;
        foreach ($orders??[] as $order) {
            $newOrder = new Order;
            $newOrder->id = $order->id;
            $newOrder->type = $order->type;
            $this->orders[] = $newOrder;
        }
        $this->id = $id;
        $this->token = $token;
        self::$users[$this->connection->id] = $this;
    }

    public static function getUsers()
    {
        return self::$users;
    }

    public static function getUser(TcpConnection $connection):User
    {
        return self::$users[$connection->id];
    }

    public function getToken()
    {
        return $this->token;
    }

    public static function remove(TcpConnection $connection):void
    {
        unset(self::$users[$connection->id]);
    }
}