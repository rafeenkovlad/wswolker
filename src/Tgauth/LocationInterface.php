<?php


namespace App\Workerman\Tgauth;


interface LocationInterface
{
    public function __invoke(object $location):self;
}