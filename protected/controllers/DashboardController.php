<?php

namespace app\controllers;

use Yii;
use app\components\Controller;

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

        throw new \yii\web\NotFoundHttpException();
    }
}
