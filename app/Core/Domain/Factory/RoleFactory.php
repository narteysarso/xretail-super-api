<?php 


namespace Core\Domain\Factory;

use Core\Domain\Adapters\Uuid;
use Core\Domain\Entity\Role;

class RoleFactory extends AbstractFactory {

    public function create($data)
    {
        $role = new Role($data, Uuid::class);
        return $role;
    }
    
}