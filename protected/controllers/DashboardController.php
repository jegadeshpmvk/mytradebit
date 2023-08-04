<?php

namespace app\controllers;

use Yii;
use app\components\Controller;
use app\models\Customer;
use app\models\FiiDii;
use app\models\Webhook;

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

    public function actionGetFiiHistorical()
    {
        $r = [];
        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
            $r = $this->dataType($post['type']);
            $r[] =  [
                'name' => 'Nifty',
                'type' => 'line',
                'data' => []
            ];
            $r[] =  [
                'name' => 'Banknifty',
                'type' => 'line',
                'data' => []
            ];

            $first_day_this_month = strtotime(date($post["val"] . '-01'));
            $last_day_this_month  = strtotime(date($post["val"] . '-t'));
            $chat_datas = FiiDii::find()->andWhere(['>=', 'date', $first_day_this_month])->andWhere(['<=', 'date', $last_day_this_month])->active()->orderBy(['date' => SORT_ASC])->all();

            $cat = [];
            if (!empty($chat_datas)) {
                foreach ($chat_datas as $k => $cds) {
                    $r[0]['data'][] = $cds[$r[0]['dataName']];
                    $r[1]['data'][] = $cds[$r[1]['dataName']];
                    $r[2]['data'][] = $cds->common_nifty;
                    $r[3]['data'][] = $cds->common_banknifty;
                    $cat[] = date('d M Y', $cds->date);
                }
            }
        }
        echo json_encode([
            'result' => $r,
            'cat' => $cat
        ]);
        exit;
    }

    public function actionFiiDii()
    {
        $this->setupMeta([], 'FII - DII Data');
        $first_day_this_month = strtotime(date('Y-m-01'));
        $last_day_this_month  = strtotime(date('Y-m-t'));
        $chat_datas = FiiDii::find()->andWhere(['>=', 'date', $first_day_this_month])->andWhere(['<=', 'date', $last_day_this_month])->active()->orderBy(['date' => SORT_ASC])->all();
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
                $cat[] = date('d M Y', $cds->date);
            }
        }
        return $this->render('fii-dii', [
            "model" => $this->findModel(),
            "datas" => FiiDii::find()->active()->orderBy(['date' => SORT_DESC])->one(),
            "result" => json_encode($r),
            "cat" => json_encode($cat),
            "all_datas" => FiiDii::find()->active()->orderBy(['date' => SORT_DESC])->all(),
        ]);
    }

    public function actionIntradaySetups()
    {
        $this->setupMeta([], 'Intraday Setups');
        $datas = '';
        if (fopen(Yii::getAlias('@webroot') . '/webhook/Open-Market.csv', "r")) {
            $myfile = fopen(Yii::getAlias('@webroot') . '/webhook/open-Market.csv', "r") or die("Unable to open file!");
            $pre_close = [];
            while (($data = fgetcsv($myfile)) !== false) {
                $pre_close[$data[0]] = @$data[1];
            }
            fclose($myfile);
        }

        $bulish_momentum = Webhook::find()->andWhere(['scan_name' => 'Bullish momentum & reversal'])->orderBy(['id' => SORT_DESC])->one();
        $bearish_momentum = Webhook::find()->andWhere(['scan_name' => 'Bearish momentum & reversal'])->orderBy(['id' => SORT_DESC])->one();
        $bullish_impulse = Webhook::find()->andWhere(['scan_name' => 'Bullish impulse'])->orderBy(['id' => SORT_DESC])->one();
        $bearish_impulse = Webhook::find()->andWhere(['scan_name' => 'Bearish impulse'])->orderBy(['id' => SORT_DESC])->one();

        return $this->render('intraday-setups', [
            "model" => $this->findModel(),
            "bulish_momentum" => $bulish_momentum,
            "bearish_momentum" => $bearish_momentum,
            "bullish_impulse" => $bullish_impulse,
            "bearish_impulse" => $bearish_impulse,
            "pre_close" => $pre_close
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

    protected function dataType($type)
    {
        $r = [
            "stocks" =>  [
                [
                    'name' => 'Fii',
                    'dataName' => 'stocks_fii',
                    'type' => 'column',
                    'data' => []
                ],
                [
                    'name' => 'Dii',
                    'dataName' => 'stocks_dii',
                    'type' => 'column',
                    'data' => []
                ]
            ],
            "fif" =>  [
                [
                    'name' => 'NIFTY',
                    'type' => 'column',
                    'dataName' => 'fif_nifty',
                    'data' => []
                ],
                [
                    'name' => 'BANKNIFTY',
                    'type' => 'column',
                    'dataName' => 'fif_banknifty',
                    'data' => []
                ]
            ],
            "ffo" =>  [
                [
                    'name' => 'Change in Fut OI',
                    'type' => 'column',
                    'dataName' => 'ffo_full',
                    'data' => []
                ],
                [
                    'name' => 'Total Fut OI',
                    'type' => 'column',
                    'dataName' => 'ffo_fut',
                    'data' => []
                ]
            ],
            "ficc" =>  [
                [
                    'name' => 'Long OI Chg',
                    'type' => 'column',
                    'dataName' => 'ficc_long',
                    'data' => []
                ],
                [
                    'name' => 'Short OI Chg',
                    'type' => 'column',
                    'dataName' => 'ficc_short',
                    'data' => []
                ]
            ],
            "fipc" =>  [
                [
                    'name' => 'Long OI Chg',
                    'type' => 'column',
                    'dataName' => 'fipc_long',
                    'data' => []
                ],
                [
                    'name' => 'Short OI Chg',
                    'type' => 'column',
                    'dataName' => 'fipc_short',
                    'data' => []
                ]
            ],
            "fic" =>  [
                [
                    'name' => 'Long',
                    'type' => 'column',
                    'dataName' => 'fic_long',
                    'data' => []
                ],
                [
                    'name' => 'Short',
                    'type' => 'column',
                    'dataName' => 'fic_short',
                    'data' => []
                ]
            ],
            "fip" =>  [
                [
                    'name' => 'Long',
                    'type' => 'column',
                    'dataName' => 'fip_long',
                    'data' => []
                ],
                [
                    'name' => 'Short',
                    'type' => 'column',
                    'dataName' => 'fip_short',
                    'data' => []
                ]
            ],
        ];

        return $r[$type];
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
