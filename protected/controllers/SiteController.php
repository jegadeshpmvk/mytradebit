<?php

namespace app\controllers;

use Yii;
use app\components\Controller;
use app\models\CustomPage;
use app\models\OptionChain;
use app\models\LoginForm;
use app\models\Customer;
use app\models\ChangePasswordFront;

class SiteController extends Controller
{

    public function actionIndex()
    {
        $model = CustomPage::find()->andWhere(['url' => 'home'])->active()->one();
        if ($model && trim(@$model->parent_page) == "") {
            $title = '';
            if (trim(@$model->name) != '') {
                $title = @$model->name . ' | My Trade Bit';
            }

            $this->setupMeta(@$model->meta_tag, $title);
            return $this->render('index', [
                "model" => $model,
                'page' => $model->url,
                "contetWidgets" => $model->content_widgets
            ]);
        }
        throw new \yii\web\NotFoundHttpException();
    }

    public function actionCustomPage($model, $url, $redirect)
    {
        if ($redirect !== false)
            return $this->redirect($redirect, 301);

        $title = '';
        if (trim(@$model->name) != '') {
            $title = @$model->name . ' | My Trade Bit';
        }
        $this->setupMeta(@$model->meta_tag, $title);
        return $this->render('index', [
            "model" => $model,
            'page' => $model->url,
            "contetWidgets" => $model->content_widgets
        ]);
    }

    public function actionCronJobs()
    {

        $today_date =  strtotime(date('Y-m-d H:i'));
        $start_date = strtotime(date('Y-m-d 09:15'));
        $end_date = strtotime(date('Y-m-d 03:30'));
        
        if ($today_date > $start_date && $today_date < $end_date) {
            $model = new OptionChain();
            $model->type =  'test';
            $model->strike_price =  1650000;
            $model->expiry_date =  date('Y-m-d H:i');
            $model->save();
        }
        if ($today_date === $end_date) {
        }
    }

    public function actionLoginForm()
    {
        $model = new LoginForm();
        $model->type = 'customer';
        $submit = Yii::$app->request->post('ajaxSubmit', "");
        $result = [
            'status' => 404
        ];

        if ($model->load(Yii::$app->request->post())) {
            if ($submit === "" && Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            } else {
                if ($model->login()) {
                    Yii::$app->user->identity->updateCookie();
                    $result = [
                        'status' => 200,
                        'message' => 'Login Successfully.'
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

    public function actionRegisterForm()
    {
        $model = new Customer();
        $model->type = 'customer';
        $model->scenario = 'register';
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
                    Yii::$app->user->login($model, true ? 3600 * 24 * 30 : 0);
                    Yii::$app->user->identity->updateCookie();
                    $result = [
                        'status' => 200,
                        'message' => 'Register Successfully.'
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

    public function actionForgotPassword()
    {
        $model = new ChangePasswordFront();
        $model->scenario = 'resetEmail';
        $submit = Yii::$app->request->post('ajaxSubmit', "");
        $result = [
            'status' => 404
        ];

        if ($model->load(Yii::$app->request->post())) {
            if ($submit === "" && Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            } else if ($model->validate()) {
                $model->sendEmail();
                $result = [
                    'status' => 200,
                    'message' => "Reset password link has been sent to " . $model->email
                ];
                $model->email = NULL;
            } else {
                $result = [
                    'status' => 404,
                    'message' => $model->errors
                ];
            }
        }

        echo json_encode($result);
        exit();
    }
}
