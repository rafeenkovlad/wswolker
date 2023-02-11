<?php


namespace App\Workerman\Tgauth;


interface OrderInterface
{
    public function __invoke(object $order): OrderInterface;
}