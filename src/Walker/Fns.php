<?php


namespace App\Workerman\Walker;


use App\Workerman\Tgauth\Order;
use App\Workerman\Tgauth\Service;
use App\Workerman\Tgauth\User;

class Fns {

    private static ?object $payload;

    private static ?string $token;

    private static ?User $user;

    public static function intersectionOrders(array $ordersUser, array $ordersGad)
    {
        $orders = [];
        array_map(
            static function(Order $order)use(&$orders, $ordersGad):void {
                foreach($ordersGad as $orderGad) {
                    if(isset($orderGad->id) && $orderGad->id === $order->id) {
                        $service = new Service();
                        $order->service = $service($orderGad->service);
                    }
                }
                if(isset($order->service ) && $order->service !== null) {
                    $orders[] = $order;
                }
            }
            ,$ordersUser);

        return $orders;

    }

    public static function payload(string $payload = null)
    {
        if(isset(self::$payload)) {
            return self::$payload;
        }
        self::$payload = (json_decode($payload??''))->result??null;
        return self::$payload;
    }

    public static function token(string $token = null)
    {
        if(isset(self::$token)) {
            return self::$token;
        }
        self::$token = $token;
        return self::$token;
    }

    public static function user(User $user = null):?User
    {
        if(isset(self::$user)) {
            return self::$user;
        }
        self::$user = $user;
        return self::$user;
    }

    public static function rm()
    {
        self::$payload = null;
        self::$token = null;
        self::$user = null;
    }

    public static function freez():void
    {
        do{
            echo ".";
            usleep(2000);
        }while(isset(self::$user));
    }

}