<?php


namespace App\Workerman\wolker;


use App\Workerman\Tgauth\Order;

class Fns {

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
}