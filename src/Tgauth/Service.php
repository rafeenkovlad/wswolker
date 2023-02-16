<?php


namespace App\Workerman\Tgauth;


class Service implements ServiceInterface
{
    public ?int $id;
    public ?string $name;

    public function __invoke(object $service): ServiceInterface
    {
        $this->id = $service->id;
        $this->name = $service->name;
        return $this;
    }

    public function toJson():string
    {
        return json_encode($this);
    }
}