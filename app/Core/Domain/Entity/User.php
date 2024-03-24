<?php 

namespace Core\Domain\Entity;

class User extends AppEntity {

    protected $name;
    protected $email;
    protected $phone;
    protected $is_active;
    protected $password;


    public function __construct(array $userData, $uuid)
    {
        $this->setUUID($uuid);

        if(array_key_exists('id', $userData)){
            $this->setId($userData['id']);
        }else $this->setId();
        
        if(!array_key_exists('name', $userData))
            throw new \Exception("User name is required", 422);
        
        if(!array_key_exists('email', $userData))
            throw new \Exception("User email is required", 422);
            
        if(!array_key_exists('phone', $userData))
            throw new \Exception("User phone number is required", 422);

        if(array_key_exists('password', $userData)){
            $this->setPassword($userData['password']);
        }

        if(array_key_exists('created_at', $userData))
            $this->setCreatedAt($userData['created_at']);
            
        if(array_key_exists('updated_at', $userData))
            $this->setUpdatedAt($userData['updated_at']);


        $this->setName($userData['name']);
        $this->setEmail($userData['email']);
        $this->setPhone($userData['phone']);
    }

    

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    protected function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    protected function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Set the value of phone
     *
     * @return  self
     */ 
    protected function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    protected function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

}