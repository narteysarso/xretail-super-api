<?php

namespace Core\Domain\Entity;

class Staff extends AppEntity
{
    protected $name;
    protected $email;
    protected $phone;
    protected $is_active;
    protected $password;

    public function __construct(array $staffData, $uuid)
    {
        $this->setUUID($uuid);
        if(array_key_exists('id', $staffData))
            $this->setId($staffData['id']);
        else $this->setId();

        if (!array_key_exists('name', $staffData))
            throw new \Exception("Staff name is required", 422);

        if (!array_key_exists('email', $staffData))
            throw new \Exception("Staff email is required", 422);

        if (array_key_exists('phone', $staffData))
            $this->setPhone($staffData['phone']);

        if (array_key_exists('password', $staffData)) {
            $this->setPassword($staffData['password']);
        }

        if (array_key_exists('is_active', $staffData)) {
            $this->setIs_active($staffData['is_active']);
        }

        if(array_key_exists('created_at', $staffData))
        $this->setCreatedAt($staffData['created_at']);
        
        if(array_key_exists('updated_at', $staffData))
            $this->setUpdatedAt($staffData['updated_at']);

        $this->setName($staffData['name']);
        $this->setEmail($staffData['email']);
    }



    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName(String $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail(String $email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Set the value of phone
     *
     * @return  self
     */
    public function setPhone(String $phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Set the value of is_active
     *
     * @return  self
     */
    public function setIs_active(bool $is_active)
    {
        $this->is_active = $is_active;

        return $this;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */
    public function setPassword(String $password)
    {
        $this->password = $password;

        return $this;
    }
}
