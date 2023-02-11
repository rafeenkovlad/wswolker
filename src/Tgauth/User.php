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

    public function __construct(TcpConnection $connection, string $orders, $id)
    {
        $this->connection = $connection;
        $orders = json_decode($orders);
        foreach ($orders as $id) {
            $order = new Order;
            $order->id = $id;
            $this->orders[] = $order;
        }
        $this->id = $id;
        self::$users[] = $this;
    }

    public static function getUsers()
    {
        return self::$users;
    }
}