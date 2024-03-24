<?php 

namespace Core\Domain\Factory;

use Core\Domain\Entity\App;
use Core\Domain\Adapters\Uuid;

class AppFactory extends AbstractFactory{

    public function create($arrayData){

        return new App($arrayData, Uuid::class);
    }


}