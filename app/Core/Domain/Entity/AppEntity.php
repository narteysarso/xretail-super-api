<?php 

namespace Core\Domain\Entity;

abstract class AppEntity extends AbstractEntity {
    protected $app_id;

    protected function setAppId(String $app_id){
        if(!$this->uuid::isValid($app_id))
            throw new \Exception('Invalid staff id', 422);
        $this->app_id = $app_id;
        return $this;
    }

}