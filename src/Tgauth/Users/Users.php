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

    public static function getUsers():array
    {
        return self::$class->values;
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

    public function valid($connectionId):bool
    {
        return isset($this->values[$connectionId]);
    }
}