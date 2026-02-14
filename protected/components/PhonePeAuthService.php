<?php

namespace app\components;

use Yii;

class PhonePeAuthService
{
    private $clientId;
    private $clientSecret;
    private $clientVersion;
    private $baseUrl;

    public function __construct()
    {

        $this->clientId       = $_ENV['PHONEPE_CLIENT_ID'];
        $this->clientSecret   = $_ENV['PHONEPE_CLIENT_SECRET'];
        $this->clientVersion  = $_ENV['PHONEPE_CLIENT_VERSION'];
        $this->baseUrl        = $_ENV['PHONEPE_bASEURL'];
    }

    public function generateToken()
    {
        $url = $this->baseUrl . "/v1/oauth/token";

        $payload = [
            "client_id" => $this->clientId,
            "client_secret" => $this->clientSecret,
            "grant_type" => "client_credentials",
            "client_version" => $this->clientVersion
        ];

        $ch = curl_init($url);

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json"
            ],
            CURLOPT_POSTFIELDS => json_encode($payload)
        ]);

        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result, true);
    }
}
