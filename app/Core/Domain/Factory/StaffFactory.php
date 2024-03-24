<?php

namespace Core\Domain\Factory;

use Core\Domain\Adapters\Uuid;
use Core\Domain\Entity\Staff;

class StaffFactory extends AbstractFactory {

    public function create($array)
    {
        $staff = new Staff($array, Uuid::class);
        return $staff;
    }
}