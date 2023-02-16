<?php


namespace App\Workerman\Tgauth;


class Order implements OrderInterface
{

    public ?int $id;
    public ?Service $service;
    public ?string $type;
    public ?Location $location;

    public function __invoke(object $order): OrderInterface
    {
        $this->id = $order->id;
        $this->service = $order->service;
        return $this;
    }

    public function toJson():string
    {
        return json_encode($this);
    }

}