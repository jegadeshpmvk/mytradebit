<?php

namespace app\controllers;

use Yii;
use app\components\Controller;
use app\models\Customer;
use app\models\FiiDii;
use yii\web\NotFoundHttpException;

class DashboardController extends Controller
{
    public function behaviors()
    {
        return require(__DIR__ . '/filters/LoginCheck.php');
    }

    public function actionIndex()
    {
        $this->setupMeta([], 'Dashboard');
        return $this->render('index');
    }

    public function actionAccountDetails()
    {
        $this->setupMeta([], 'Account Details');

        return $this->render('account-details', [
            "model" => $this->findModel()
        ]);
    }

    public function actionPlans()
    {
        $this->setupMeta([], 'Plans');

        return $this->render('plans', [
            "model" => $this->findModel()
        ]);
    }

    public function actionFiiDii()
    {
        $this->setupMeta([], 'FII - DII Data');
        $chat_datas = FiiDii::find()->active()->all();
        $r = [
            [
                'name' => 'Fii',
                'type' => 'column',
                'data' => []
            ],
            [
                'name' => 'Dii',
                'type' => 'column',
                'data' => []
            ],
            [
                'name' => 'Nifty',
                'type' => 'line',
                'data' => []
            ],
            [
                'name' => 'Banknifty',
                'type' => 'line',
                'data' => []
            ]
        ];
        $cat = [];
        if (!empty($chat_datas)) {
            foreach ($chat_datas as $k => $cds) {
                $r[0]['data'][] = $cds->stocks_fii;
                $r[1]['data'][] = $cds->stocks_dii;
                $r[2]['data'][] = $cds->common_nifty;
                $r[3]['data'][] = $cds->common_banknifty;
            }
        }
        if (!empty($chat_datas)) {
            foreach ($chat_datas as $k => $cds) {
                $cat[] = date('M Y', $cds->date);
            }
        }
        return $this->render('fii-dii', [
            "model" => $this->findModel(),
            "datas" => FiiDii::find()->andWhere(['date' => strtotime(date('Y-m-d'))])->active()->one(),
            "result" => json_encode($r),
            "cat" => json_encode($cat),
            "all_datas" => FiiDii::find()->active()->all(),
        ]);
    }

    public function actionIntradaySetups()
    {
        $this->setupMeta([], 'Intraday Setups');

        return $this->render('intraday-setups', [
            "model" => $this->findModel()
        ]);
    }

    public function actionPositionalSetups()
    {
        $this->setupMeta([], 'Positional Setups');

        return $this->render('positional-setups', [
            "model" => $this->findModel()
        ]);
    }

    public function actionMarketPulse()
    {
        $this->setupMeta([], 'Market Pulse');

        return $this->render('market-pulse', [
            "model" => $this->findModel()
        ]);
    }

    protected function findModel()
    {
        if (($model = Customer::findOne(Yii::$app->user->identity->id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionUpdateProfile()
    {
        $model = $this->findModel();
        $submit = Yii::$app->request->post('ajaxSubmit', "");
        $result = [
            'status' => 404
        ];

        if ($model->load(Yii::$app->request->post())) {
            if ($submit === "" && Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            } else {
                if ($model->save()) {
                    $result = [
                        'status' => 200,
                        'message' => 'Updated Successfully.'
                    ];
                } else {
                    $result = [
                        'status' => 404,
                        'message' => $model->errors
                    ];
                }
            }
        }

        echo json_encode($result);
        exit();
    }
}
