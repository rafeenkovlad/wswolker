<?php

namespace App\Workerman\Tgauth\Users;

use App\Workerman\Tgauth\User;
use Traversable;

class UsersCollection implements \IteratorAggregate
{

    private array $users = [];

    public function getIterator()
    {
        // TODO: Implement getIterator() method.
    }

    public function add(User $user)
    {

    }

    public function get()
    {

    }
}