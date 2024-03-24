<?php

namespace Core\Domain\Entity;

use DateTime;
use Exception;

class App extends AbstractEntity {

    protected $token;
    protected $name;
    protected $icon;
    protected $user_id;
    protected $expires_in;
    protected $invoice_num_prefix;
    protected $remote_auth_url;
    protected $remote_staff_data_url;
    protected $remote_product_data_url;

    public static function verifyAppExpiryDate(DateTime $date){
        $currentDate = new DateTime();
        
        if($currentDate > $date){
            throw new Exception('Your subscription has expired.', 401);
        }

        return $date;
    }

    public function __construct(array $appData, $uuid)
    {
        $this->setUUID($uuid);

        if(array_key_exists('id', $appData))
            $this->setId($appData['id']);
        else $this->setId();

        if(array_key_exists("token", $appData))
            $this->setToken($appData['token']);

        if(array_key_exists("remote_staff_data_url", $appData))
            $this->setRemote_staff_data_url($appData["remote_staff_data_url"]);
        if(array_key_exists("remote_product_data_url)", $appData))
            $this->setRemote_products_data_url($appData['remote_products_data_url)']);
        if(array_key_exists("remote_auth_url", $appData))
            $this->setRemote_auth_url($appData['remote_auth_url']);
        if(array_key_exists("invoice_num_prefix", $appData))
            $this->setInvoice_num_prefix($appData['invoice_num_prefix']);
        if(array_key_exists("expires_in", $appData))
            $this->setExpires_in($appData['expires_in']);
        if(array_key_exists("user_id", $appData))
            $this->setUser_id($appData['user_id']);
        
        if(array_key_exists('created_at', $appData))
            $this->setCreatedAt($appData['created_at']);
            
        if(array_key_exists('updated_at', $appData))
            $this->setUpdatedAt($appData['updated_at']);
       
        if(array_key_exists("icon", $appData))
            $this->setIcon($appData['icon']);
        if(array_key_exists("name", $appData))
            $this->setName($appData['name']);
        else
            throw new Exception("App name must be specified", 422);
            
        // if(array_key_exists("", $appData))
        //     $this->
        
    }
    

    /**
     * Set the value of remote_products_data_url
     *
     * @return  self
     */ 
    protected function setRemote_products_data_url(String $remote_product_data_url)
    {
        $this->remote_product_data_url = $remote_product_data_url;

        return $this;
    }

    /**
     * Set the value of remote_staff_data_url
     *
     * @return  self
     */ 
    protected function setRemote_staff_data_url(String $remote_staff_data_url)
    {
        $this->remote_staff_data_url = $remote_staff_data_url;

        return $this;
    }

    /**
     * Set the value of remote_auth_url
     *
     * @return  self
     */ 
    protected function setRemote_auth_url(String $remote_auth_url)
    {
        $this->remote_auth_url = $remote_auth_url;

        return $this;
    }

    /**
     * Set the value of invoice_num_prefix
     *
     * @return  self
     */ 
    protected function setInvoice_num_prefix(String $invoice_num_prefix)
    {
        $this->invoice_num_prefix = $invoice_num_prefix;

        return $this;
    }

    /**
     * Set the value of expires_in
     *
     * @return  self
     */ 
    protected function setExpires_in(String $expires_in)
    {
        $this->expires_in = $expires_in;

        return $this;
    }

    /**
     * Set the value of user_id
     *
     * @return  self
     */ 
    protected function setUser_id(String $user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * Set the value of icon
     *
     * @return  self
     */ 
    protected function setIcon(String $icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    protected function setName(String $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set the value of token
     *
     * @return  self
     */ 
    protected function setToken(String $token = "")
    {
       
        $this->token = $token || App::makeToken();

        return $this;
    }

    private static function makeToken(): String {
        $original_string = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
        $original_string = implode("", $original_string);
        return ( time() . ":" . substr(str_shuffle($original_string), 0, 32));

    }
}