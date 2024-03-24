<?php

namespace App\Utility;

class PostCall
{
    public static function run(String $url, $postData, String $authorization_token, int $redirects = 10)
    {
        $cUrl = curl_init();

        curl_setopt($cUrl, CURLOPT_URL, $url);
        curl_setopt($cUrl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($cUrl, CURLOPT_ENCODING, "");
        curl_setopt($cUrl, CURLOPT_MAXREDIRS, $redirects);
        curl_setopt($cUrl, CURLOPT_RETURNTRANSFER, false);
        curl_setopt($cUrl, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($cUrl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt(
            $cUrl,
            CURLOPT_HTTPHEADER,
            array(
                "accept: */*",
                "authorization: Bearer " . $authorization_token
            )
        );

        $response = (curl_exec($cUrl));
    }
}
