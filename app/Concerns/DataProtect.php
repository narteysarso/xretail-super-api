<?php 

namespace App\Concerns;

/**
 * 
 */
trait DataProtect
{
    
    protected $ciphering = "AES-128-CTR";
    protected $options = 0;
    protected function encrypt($data){

        // Use openssl_encrypt() function to encrypt the data 
        $result = openssl_encrypt(
            $data,
            $this->ciphering,
            getenv("KCRYPT_API_KEY"),
            $this->options,
            getenv("KCRYPT_API_IV")
        ); 

        return $result;
    }

    protected function decrypt($data){
        //
        $result = openssl_decrypt(
            $data,
            $this->ciphering,
            getenv("KCRYPT_API_KEY"),
            $this->options,
            getenv("KCRYPT_API_IV")
        );

        return $result;
    }
    
}
