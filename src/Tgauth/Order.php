<?php


namespace App\Workerman\Tgauth;


class Order implements OrderInterface
{

    public ?int $id;
    public ?string $name;
    public ?Location $location;

    public function __invoke(object $order): OrderInterface
    {
        $this->id = $order->id;
        $this->name = $order->name;
        return $this;
    }

    public function toJson():string
    {
        return json_encode($this);
    }

}