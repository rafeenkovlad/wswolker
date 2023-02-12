<?php


namespace App\Workerman\Tgauth;


use Workerman\Connection\TcpConnection;
use Workerman\Worker;

class User
{
    public TcpConnection $connection;
    public array $orders = [];
    public int $id;
    private static array $users = [];

    public function __construct(TcpConnection $connection, ?array $orders, ?int $id)
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
        self::$users[] = $this;
    }

    public static function getUsers()
    {
        return self::$users;
    }
}