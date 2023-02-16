<?php


namespace App\Workerman\Tgauth;


interface ServiceInterface
{
    public function __invoke(object $service): ServiceInterface;

}