<?php

namespace app\controllers;

use Yii;
use app\components\Controller;
use app\components\PhonePeCheckoutService;
use app\models\Subscription;

class PhonePayController extends Controller
{
    public function actionCreatePayment()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['login']);
        }
        try {
            $phonePe = new PhonePeCheckoutService();
            $amount = intval(799);
            $response = $phonePe->initiatePayment(
                $amount,
                Yii::$app->user->identity->username,
                Yii::$app->user->identity->email,
                Yii::$app->user->identity->mobile_number
            );
        
            // Redirect user to PhonePe checkout page
            return $this->redirect($response['redirectUrl']);
        //     return [
        //     "success" => true,
        //     "url" => $response['redirectUrl']
        // ];
        } catch (\Exception $e) {
            // echo 'wdsfds';
            print_r($e->getMessage());exit;
            return $this->render("error", [
                "message" => $e->getMessage()
            ]);
        }
    }

    public function actionPaymentSuccess($orderId)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['login']);
        }

        // Step 1: Find transaction
        // $txn = Subscription::findOne([
        //     'merchant_order_id' => $orderId,
        //     'user_id' => Yii::$app->user->id
        // ]);
        
        $txn = new Subscription();
        

        if (!$txn) {
            die("Invalid Order ID");
        }

        // Step 2: Verify Payment Status from PhonePe
        $phonePe = new PhonePeCheckoutService();
        $statusResponse = $phonePe->checkStatus($orderId);

        if (isset($statusResponse['state']) && $statusResponse['state'] == "COMPLETED") {
            // Step 3: Mark Payment Success
            
            $txn->merchant_order_id = $orderId;
            $txn->user_id = Yii::$app->user->id;
            $txn->amount = $statusResponse['amount'];
            
            $txn->status = "SUCCESS";
            $txn->start_date = strtotime("today"); // Current date timestamp
            $txn->end_date   = strtotime("+1 year");
            $txn->response_json = json_encode($statusResponse);
            $txn->save();

            // Step 5: Redirect to Dashboard
            Yii::$app->session->setFlash("success", "Payment Successful!");

            return $this->redirect(['/dashboard']);
        }

        // Payment Failed
        $txn->merchant_order_id = $orderId;
        $txn->user_id = Yii::$app->user->id;
        $txn->status = $statusResponse['state'];
        $txn->save();

        Yii::$app->session->setFlash("error", "Payment Failed!");

        return $this->redirect(['/dashboard']);
    }
}
