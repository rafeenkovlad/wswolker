<?php


namespace App\Workerman\Tgauth;


use App\Workerman\Tgauth\Users\Users;
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
        Users::init()->add($this, $this->connection->id);
        //self::$users[$this->connection->id] = $this;
    }

    public static function getUsers():array
    {
        return Users::get()->getUsers();
        //return self::$users;
    }

    public static function getUser(TcpConnection $connection):User
    {
        return Users::get()->current($connection->id);
       // return self::$users[$connection->id];
    }

    public function getToken()
    {
        return $this->token;
    }

    public static function remove(TcpConnection $connection):void
    {
        Users::get()->remove($connection->id);
        //unset(self::$users[$connection->id]);
    }
}