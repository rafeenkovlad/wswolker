<?php


namespace App\Workerman\Tgauth;


class Location implements LocationInterface
{

    public float $lat;
    public float $long;

    public function __invoke(object $location): LocationInterface
    {
        $this->lat = $location->latitude;
        $this->long = $location->longitude;
        return $this;
    }

    public function toJson():string
    {
        return json_encode($this);
    }
}