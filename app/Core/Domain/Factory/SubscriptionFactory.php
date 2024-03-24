<?php 

namespace Core\Domain\Factory;

use Core\Domain\Entity\SubscriptionCode;
use Core\Domain\Adapters\Uuid;

class SubscriptionFactroy extends AbstractFactory {

    public function create($data){
        
        return new SubscriptionCode($data, UUid::class);
    }
}