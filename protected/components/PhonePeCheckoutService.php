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
    private $merchantId;

    public function __construct()
    {

        $this->clientId       = $_ENV['PHONEPE_CLIENT_ID'];
        $this->clientSecret   = $_ENV['PHONEPE_CLIENT_SECRET'];
        $this->clientVersion  = $_ENV['PHONEPE_CLIENT_VERSION'];

        $this->tokenUrl       = $_ENV['PHONEPE_TOKENURL'];
        $this->payUrl         = $_ENV['PHONEPE_PAYURL'];
        $this->statusUrl = $_ENV['PHONEPE_STATUSURL'];
         $this->merchantId = $_ENV['PHONEPE_MERCHANT_ID'];
    }

    /**
     * Step 1: Generate OAuth Access Token
     */
    public function getAccessToken()
    {
       $postData = http_build_query([
            "client_id" => $this->clientId,
            "client_secret" => $this->clientSecret,
            "grant_type" => "client_credentials",
            "client_version" => $this->clientVersion
        ]);
        
        $ch = curl_init($this->tokenUrl);
        
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/x-www-form-urlencoded"
            ],
            CURLOPT_TIMEOUT => 30,
        ]);
        
        $response = curl_exec($ch);
        
        if ($response === false) {
            die("Curl Token Error: " . curl_error($ch));
        }
        
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
       
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
    // public function initiatePayment($amount, $name, $mobile, $email)
    // {
    //     $token = $this->getAccessToken();


    //     $merchantOrderId = "TX" . time();
    //     $amountPaise = intval($amount * 100);
    //     $redirectUrl = Yii::$app->urlManager->createAbsoluteUrl([
    //         'payment-success',
    //         'orderId' => $merchantOrderId
    //     ]);
    //     $payload = [
    //         "merchantOrderId" => $merchantOrderId,
    //         "amount" => $amountPaise,
    //         "expireAfter" => 1200,

    //         "metaInfo" => [
    //             "udf1" => $name,
    //             "udf2" => $mobile,
    //             "udf3" => $email,
    //             "udf5" => date("Y-m-d H:i:s")
    //         ],

    //         "paymentFlow" => [
    //             "type" => "PG_CHECKOUT",
    //             "message" => "PhonePe Payment",
    //             "merchantUrls" => [
    //                 "redirectUrl" => $redirectUrl
    //             ],
    //             "paymentModeConfig" => [
    //                 "enabledPaymentModes" => [
    //                     ["type" => "UPI_INTENT"],
    //                     ["type" => "UPI_COLLECT"],
    //                     ["type" => "UPI_QR"],
    //                     ["type" => "NET_BANKING"],
    //                     [
    //                         "type" => "CARD",
    //                         "cardTypes" => ["DEBIT_CARD", "CREDIT_CARD"]
    //                     ]
    //                 ]
    //             ]
    //         ]
    //     ];

    //     $ch = curl_init($this->payUrl);

    //     curl_setopt_array($ch, [
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_POST => true,
    //         CURLOPT_POSTFIELDS => json_encode($payload, JSON_UNESCAPED_SLASHES),
    //         CURLOPT_HTTPHEADER => [
    //             "Content-Type: application/json",
    //             "Authorization: O-Bearer " . $token
    //         ]
    //     ]);

    //     $response = curl_exec($ch);
    //     curl_close($ch);

    //     $data = json_decode($response, true);
        

    //     if (empty($data['redirectUrl'])) {
    //         throw new \Exception("PhonePe Pay Error: " . $response);
    //     }

    //     return $data;
    // }
    
    public function initiatePayment($amount, $name, $mobile, $email)
{
    $token = $this->getAccessToken();

    $merchantOrderId = "TX" . time();
    $amountPaise = intval($amount * 100);

    $redirectUrl = Yii::$app->urlManager->createAbsoluteUrl([
        'payment-success',
        'orderId' => $merchantOrderId
    ]);

    // ✅ Checkout v2 expects merchantTransactionId
    // $payload = [
    //     "merchantOrderId" => $merchantOrderId,
    //     "amount" => $amountPaise,
    //     "expireAfter" => 1200,

    //     "metaInfo" => [
    //         "udf1" => $name,
    //         "udf2" => $mobile,
    //         "udf3" => $email,
    //         "udf5" => date("Y-m-d H:i:s")
    //     ],

    //     "paymentFlow" => [
    //         "type" => "PG_CHECKOUT",
    //         "message" => "PhonePe Payment",
    //         "merchantUrls" => [
    //             "redirectUrl" => $redirectUrl
    //         ],
    //         "paymentModeConfig" => [
    //             "enabledPaymentModes" => [
    //                 ["type" => "UPI_INTENT"],
    //                 ["type" => "UPI_COLLECT"],
    //                 ["type" => "UPI_QR"],
    //                 ["type" => "NET_BANKING"],
    //                 [
    //                     "type" => "CARD",
    //                     "cardTypes" => ["DEBIT_CARD", "CREDIT_CARD"]
    //                 ]
    //             ]
    //         ]
    //     ]
    // ];
    $payload = [
    "merchantId" => $this->merchantId,
    "merchantOrderId" => $merchantOrderId,
    "amount" => $amountPaise,

    "callbackUrl" => $redirectUrl,

    "paymentFlow" => [
        "type" => "PG_CHECKOUT",
        "merchantUrls" => [
            "redirectUrl" => $redirectUrl
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
   //print_r($data);exit;
    // ✅ Checkout v2 redirect URL is inside data.redirectUrl
        if (empty($data['redirectUrl'])) {
            throw new \Exception("PhonePe Pay Error: " . $response);
        }

    // ✅ Return redirect URL directly (same flow)
    return $data;
}

    public function checkStatus($merchantOrderId)
    {
        $accessToken = $this->getAccessToken();
    
        $url = rtrim($this->statusUrl, "/") . "/" . $merchantOrderId.'/status';
    
        $ch = curl_init($url);
    
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "Authorization: O-Bearer " . $accessToken,
                 "X-MERCHANT-ID: " . $this->merchantId, 
            ],
            CURLOPT_TIMEOUT => 30
        ]);
    
        $response = curl_exec($ch);
    
        if ($response === false) {
            throw new \Exception("Curl Error: " . curl_error($ch));
        }
    
        curl_close($ch);
       
        $data = json_decode($response, true);
      
    
        return $data;
    }
}
