<?php 

namespace Core\Domain\Service;

use Core\Domain\Factory\AbstractFactory;
use DateTime;

class User{

    protected $factory;

    public function __construct(AbstractFactory $factory )
    {
        $this->factory = $factory;
    }

    public function createUser(array $data){
        try {
            //code...
            $data['created_at'] = new DateTime();
            $data['updated_at'] = new DateTime();
            
            $user = $this->factory->create($data);

            return $user->toArray();
        } catch (\Throwable $th) {
            //throw $th;
            throw $th;
        }
    }

    public function setFactory(AbstractFactory $factory){
        $this->factory = $factory;
    }

}