<?php 


namespace Core\Domain\Entity;

use Exception;

class Role extends AbstractEntity{
    protected $name;

    public function __construct(array $roleData, $uuid)
    {
        if(array_key_exists('id', $roleData))
            $this->setId($roleData['id']);
        else $this->setId();

        if(array_key_exists('created_at', $roleData))
        $this->setCreatedAt($roleData['created_at']);
        
        if(array_key_exists('updated_at', $roleData))
            $this->setUpdatedAt($roleData['updated_at']);

        if(!array_key_exists('name', $roleData))
            throw new Exception("Role must have a name", 422);

        $this->setName($roleData['name']);
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
}