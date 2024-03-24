<?php 

namespace Core\Domain\Entity;

use DateTime;

abstract class AbstractEntity {
    protected $id;
    protected $created_at;
    protected $updated_at;
    protected $deleted_at;

    protected function setId(String $id = ""){
        if(!$id){
            $id = (string) $this->uuid::makeUUid();
            
        }
        if(!$this->uuid::isValid($id)){
            throw new \Exception("ID must be a valid UUID");
        }
        $this->id = $id;
        
        return $this;
    }


    protected function setStaffId(String $staff_id){
        if(!$this->uuid::isValid($staff_id))
            throw new \Exception('Invalid staff id', 422);
        $this->staff_id = $staff_id;
        return $this;
    }


   
    protected function setCreatedAt(\DateTime $created_at){
        $this->created_at = $created_at;
        return $this;
    }
    protected function setDeletedAt(\DateTime $deleted_at){
        $this->deleted_at = $deleted_at;
        return $this;
    }
    protected function setUpdatedAt(\DateTime $updated_at){
        $this->updated_at = $updated_at;
        return $this;
    }
    protected function isUUid(String $id){
        return $this->uuid::isValid($id);
    }

    public function setUUID($uuid){
        $this->uuid = $uuid;
        return $this;
    }

    public function markDeleted(){
        $this->setDeletedAt(new \DateTime());
    }


    public function toArray(){
        $array = [];
        foreach(get_object_vars($this) as $key => $value){
            if($key === 'uuid')
                continue;
            $array[$key] = $value;
        }

        return $array;
    }
}