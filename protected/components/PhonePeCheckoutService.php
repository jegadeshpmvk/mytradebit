<?php

namespace app\components;

use Yii;
use app\models\Subscription;

class PhonePeCheckoutService
{
    private $clientId;
    private $clientSecret;
    private $clientVersion;
    private $tokenUrl;
    private $payUrl;
    private $statusUrl;

    public function __construct()
    {

        $this->clientId       = $_ENV['PHONEPE_CLIENT_ID'];
        $this->clientSecret   = $_ENV['PHONEPE_CLIENT_SECRET'];
        $this->clientVersion  = $_ENV['PHONEPE_CLIENT_VERSION'];

        $this->tokenUrl       = $_ENV['PHONEPE_TOKENURL'];
        $this->payUrl         = $_ENV['PHONEPE_PAYURL'];
        $this->statusUrl = $_ENV['PHONEPE_STATUSURL'];;
    }

    /**
     * Step 1: Generate OAuth Access Token
     */
    public function getAccessToken()
    {
        $payload = [
            "client_id" => $this->clientId,
            "client_secret" => $this->clientSecret,
            "grant_type" => "client_credentials",
            "client_version" => $this->clientVersion
        ];

        $ch = curl_init($this->tokenUrl);

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json"
            ],
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_TIMEOUT => 30,
        ]);

        $response = curl_exec($ch);

        if ($response === false) {
            die("Curl Token Error: " . curl_error($ch));
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        print_r($response);
        exit;
        $data = json_decode($response, true);

        if ($httpCode != 200 || !isset($data['access_token'])) {
            die("Token Failed: " . $response);
        }

        if (!isset($data['access_token'])) {
            throw new \Exception("PhonePe Token Error: " . $response);
        }

        return $data['access_token'];
    }

    /**
     * Step 2: Initiate Payment
     */
    public function initiatePayment($amount, $name, $mobile, $email)
    {
        $token = $this->getAccessToken();


        $merchantOrderId = "TX" . time();
        $amountPaise = intval($amount * 100);
        $redirectUrl = Yii::$app->urlManager->createAbsoluteUrl([
            'payment-success',
            'orderId' => $merchantOrderId
        ]);
        $payload = [
            "merchantOrderId" => $merchantOrderId,
            "amount" => $amountPaise,
            "expireAfter" => 1200,

            "metaInfo" => [
                "udf1" => $name,
                "udf2" => $mobile,
                "udf3" => $email,
                "udf4" => "Yii2 Checkout Payment",
                "udf5" => date("Y-m-d H:i:s")
            ],

            "paymentFlow" => [
                "type" => "PG_CHECKOUT",
                "message" => "PhonePe Payment",
                "merchantUrls" => [
                    "redirectUrl" => $redirectUrl
                ],
                "paymentModeConfig" => [
                    "enabledPaymentModes" => [
                        ["type" => "UPI_INTENT"],
                        ["type" => "UPI_COLLECT"],
                        ["type" => "UPI_QR"],
                        ["type" => "NET_BANKING"],
                        [
                            "type" => "CARD",
                            "cardTypes" => ["DEBIT_CARD", "CREDIT_CARD"]
                        ]
                    ]
                ]
            ]
        ];

        $ch = curl_init($this->payUrl);

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($payload, JSON_UNESCAPED_SLASHES),
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "Authorization: O-Bearer " . $token
            ]
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);

        $txn = new Subscription();
        $txn->merchant_order_id = $merchantOrderId;
        $txn->user_id = Yii::$app->user->id;
        $txn->amount = $amount;
        $txn->status = "PENDING";
        $txn->save();

        if (empty($data['redirectUrl'])) {
            throw new \Exception("PhonePe Pay Error: " . $response);
        }

        return $data;
    }

    public function checkStatus($merchantOrderId)
    {
        // Step 1: Get OAuth Token
        $accessToken = $this->getAccessToken();;

        // Step 2: Call Status API
        $url = $this->statusUrl . $merchantOrderId;

        $ch = curl_init($url);

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "Authorization: O-Bearer " . $accessToken
            ]
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);

        if (!$data) {
            throw new \Exception("Invalid status response: " . $response);
        }

        return $data;
    }
}
