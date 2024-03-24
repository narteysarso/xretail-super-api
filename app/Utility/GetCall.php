<?php

namespace App\Utility;


class GetCall
{

    public static function run(String $url, String $authorization_token = "", int $redirects = 10)
    {
        $cUrl = curl_init();

        curl_setopt($cUrl, CURLOPT_URL, $url);
        curl_setopt($cUrl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($cUrl, CURLOPT_ENCODING, "");
        curl_setopt($cUrl, CURLOPT_MAXREDIRS, $redirects);
        curl_setopt($cUrl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cUrl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt(
            $cUrl,
            CURLOPT_HTTPHEADER,
            array(
                "accept: */*",
                "accept-language: en-US, en;q=0.8",
                "content-type: application/json",
                "authorization: Bearer " . $authorization_token
            )
        );

        $response = (curl_exec($cUrl));
        $error = curl_error($cUrl);
        $status_code = curl_getinfo($cUrl, CURLINFO_HTTP_CODE);
        curl_close($cUrl);

        return array('response' => $response, 'error' => $error, 'status_code' => $status_code);
    }

}
