<?php 


namespace Core\Domain\Service;

use Core\Domain\Factory\AbstractFactory;
use DateTime;

class Subscription {
    protected $factory;

    public function __construct(AbstractFactory $factory )
    {
        $this->setFactory($factory);
    }

    public function createSubscription(array $data): array{
        try {
            //code...
            $data['created_at'] = new DateTime();
            $data['updated_at'] = new DateTime();
            $subscription = $this->factory->create($data);
            return $subscription->toArray();
            
        } catch (\Throwable $th) {
            //throw $th;
            throw $th;
        }

    }


    public function setFactory(AbstractFactory $factory){
        $this->factory = $factory;
    }
}