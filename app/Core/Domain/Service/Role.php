<?php 

namespace Core\Domain\Service;

use Core\Domain\Factory\AbstractFactory;

use DateTime;

class Role {
    protected $factory;

    public function __construct(AbstractFactory $factory )
    {
        $this->factory = $factory;
    }


    public function createRole($data){
        try {
            //code...
            $data['created_at'] = new DateTime();
            $data['updated_at'] = new DateTime();
            $role = $this->factory->create($data);
            return $role->toArray();
        } catch (\Throwable $th) {
            //throw $th;
            throw $th;
        }
    }

    public function setFactory(AbstractFactory $factory){
        $this->factory = $factory;
    }

}