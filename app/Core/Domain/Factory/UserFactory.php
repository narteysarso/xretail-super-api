<?php

namespace Core\Domain\Factory;

use Core\Domain\Adapters\Uuid;
use Core\Domain\Entity\User;

class UserFactory extends AbstractFactory {

    public function create($array)
    {
        $user = new User($array, Uuid::class);
        return $user;
    }
}