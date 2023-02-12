<?php


namespace App\Workerman\Walker;


use App\Workerman\Tgauth\Order;

class Fns {

    private static object $payload;

    private static string $token;

    public static function intersectionOrders(array $ordersUser, array $ordersGad)
    {
        $orders = [];
        array_map(
            static function(Order $order)use(&$orders, $ordersGad):void {
                foreach($ordersGad as $orderGad) {
                    if(isset($orderGad->id) && $orderGad->id === $order->id) {
                        $order->name = $orderGad->name;
                    }
                }
                if(isset($order->name ) && $order->name !== null) {
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
        self::$payload = (json_decode($payload))->result;
        return self::$payload;
    }

    public static function token(string $token = '')
    {
        if(isset(self::$token)) {
            return self::$token;
        }
        self::$token = $token;
        return self::$token;
    }

}