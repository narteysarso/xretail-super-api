<?php 

namespace Core\Domain\Adapters;


use ParagonIE\EasyRSA\KeyPair;
use ParagonIE\EasyRSA\EasyRSA;

class RSA {

    private $privateKey;
    private $publicKey;

    function __construct()
    {
        $keyPair = KeyPair::generateKeyPair(4096);

        $this->privateKey = $keyPair->getPrivateKey();
        $this->publicKey = $keyPair->getPublicKey();
    }

    function getPublicKey(){
        return $this->publicKey;
    }

    function decrypt($ciphertext = ""){
        if(!$ciphertext)
            return $ciphertext;

        return EasyRSA::decrypt($ciphertext, $this->privateKey);
    }

    function encrypt($message = ""){
        if(!$message)
            return $message;

        return EasyRSA::encrypt($message, $this->publicKey);
    }

}