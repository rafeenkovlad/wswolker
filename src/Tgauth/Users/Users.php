<?php

namespace App\Workerman\Tgauth\Users;

use App\Workerman\Tgauth\User;
use Traversable;

class Users
{
    private static Users $class;

    private array $values;

    public static function get():self
    {
        return self::$class;
    }
    public static function init():self
    {
        self::$class = self::$class?? new self();
        return self::$class;
    }

    public static function getUsers():\Generator
    {
        yield self::$class->values;
    }

    public function add(User $user, $connectionId):void
    {
        self::$class->values[$connectionId] = $user;
    }

    public function current($connectionId):User
    {
        return self::$class->values[$connectionId];
    }

    public function remove($connectionId)
    {
        unset(self::$class->values[$connectionId]);
    }

    public function next()
    {
        ++$this->position;
    }

    public function key():int
    {
        return $this->position;
    }

    public function valid():bool
    {
        return isset($this->values[$this->position]);
    }

    public function rewind()
    {
        $this->position = 0;
    }
}