<?php

namespace Core\Domain\Adapters;

use Ramsey\Uuid\Uuid as UuidUuid;

class Uuid {

    static public function isValid(String $id){
        return UuidUuid::isValid($id);
    }

    static public function makeUuid(){
        return UuidUuid::uuid4()->toString();
    }
}