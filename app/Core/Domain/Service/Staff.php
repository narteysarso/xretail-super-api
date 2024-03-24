<?php 

namespace Core\Domain\Service;

use Core\Domain\Factory\AbstractFactory;
use DateTime;

class Staff{

    protected $factory;

    public function __construct(AbstractFactory $factory )
    {
        $this->factory = $factory;
    }

    public function createStaff(array $data){
        try {
            //code...
            $data['created_at'] = new DateTime();
            $data['updated_at'] = new DateTime();
            $data['is_active'] = true;
            $staff = $this->factory->create($data);

            return $staff->toArray();
        } catch (\Throwable $th) {
            //throw $th;
            throw $th;
        }
    }

    public function setFactory(AbstractFactory $factory){
        $this->factory = $factory;
    }

}