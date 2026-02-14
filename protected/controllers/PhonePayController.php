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
        try {
            $phonePe = new PhonePeCheckoutService();
            $amount = intval(799 * 100);
            $response = $phonePe->initiatePayment(
                $amount,
                Yii::$app->user->identity->username,
                Yii::$app->user->identity->email,
                Yii::$app->user->identity->mobile_number
            );

            // Redirect user to PhonePe checkout page
            return $this->redirect($response['redirectUrl']);
        } catch (\Exception $e) {
            print_r($e->getMessage());exit;
            return $this->render("error", [
                "message" => $e->getMessage()
            ]);
        }
    }

    public function actionPaymentSuccess($orderId)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        // Step 1: Find transaction
        $txn = Subscription::findOne([
            'merchant_order_id' => $orderId,
            'user_id' => Yii::$app->user->id
        ]);

        if (!$txn) {
            die("Invalid Order ID");
        }

        // Step 2: Verify Payment Status from PhonePe
        $phonePe = new PhonePeStatusService();
        $statusResponse = $phonePe->checkStatus($orderId);

        if (
            $statusResponse['success'] == true &&
            $statusResponse['data']['state'] == "COMPLETED"
        ) {

            // Step 3: Mark Payment Success
            $txn->status = "SUCCESS";
            $txn->response_json = json_encode($statusResponse);
            $txn->save();

            // Step 4: Update Subscription Table
            $this->activateSubscription($txn->user_id);

            // Step 5: Redirect to Dashboard
            Yii::$app->session->setFlash("success", "Payment Successful!");

            return $this->redirect(['dashboard/index']);
        }

        // Payment Failed
        $txn->status = "FAILED";
        $txn->save();

        Yii::$app->session->setFlash("error", "Payment Failed!");

        return $this->redirect(['dashboard/index']);
    }
}
