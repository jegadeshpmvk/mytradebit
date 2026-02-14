<?php
namespace app\components;

use Yii;

class PhonePePaymentService
{
    private $merchantId;
    private $saltKey;
    private $saltIndex;
    private $baseUrl;

    public function __construct()
    {
        $config = Yii::$app->params['phonepe'];

        $this->merchantId = $config['merchantId'];
        $this->saltKey    = $config['saltKey'];
        $this->saltIndex  = $config['saltIndex'];
        $this->baseUrl    = $config['baseUrl'];
    }

    public function initiatePayment($token, $txnId, $amount, $redirectUrl, $callbackUrl)
    {
        $payload = [
            "merchantId" => $this->merchantId,
            "merchantTransactionId" => $txnId,
            "merchantUserId" => "USER_" . time(),
            "amount" => $amount * 100,

            "redirectUrl" => $redirectUrl,
            "redirectMode" => "POST",

            "callbackUrl" => $callbackUrl,

            "paymentInstrument" => [
                "type" => "PAY_PAGE"
            ]
        ];

        $base64Payload = base64_encode(json_encode($payload));

        $checksum = hash("sha256",
            $base64Payload . "/pg/v1/pay" . $this->saltKey
        ) . "###" . $this->saltIndex;

        $url = $this->baseUrl . "/pg/v1/pay";

        $ch = curl_init($url);

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "Authorization: Bearer $token",
                "X-VERIFY: $checksum"
            ],
            CURLOPT_POSTFIELDS => json_encode([
                "request" => $base64Payload
            ])
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }
}
