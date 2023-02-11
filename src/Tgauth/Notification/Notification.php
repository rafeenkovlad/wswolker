<?php


namespace App\Workerman\Tgauth\Notification;


use App\Workerman\Tgauth\Location;
use App\Workerman\Tgauth\Order;

class Notification implements NotificationInterface
{
    public ?string $type;

    public ?array $orders;

    public function __construct(string $type)
    {
        $this->type = $type;
    }

    public function add(object $object):self
    {
        switch ($this->type) {
            case Type::ORDER :
                [$this, 'order']($object);
        }
        return $this;
    }

    private function order(object $object):void
    {
        if($object instanceof Location) {
            foreach($this->orders as &$order) {
                if($order instanceof Order) {
                    $order->location = $object;
                }
            }
        }

        if($object instanceof Order) {
            $this->orders[] = $object;
        }
    }

    public function toJson():string
    {
        return json_encode($this);
    }
}