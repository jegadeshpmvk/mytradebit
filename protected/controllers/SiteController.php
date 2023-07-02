<?php

namespace app\controllers;

use app\components\Controller;
use app\models\CustomPage;
use app\models\OptionChain;

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
        $model = new OptionChain();
        $model->type =  'test';
        $model->strike_price =  1650000;
        $model->expiry_date =  '2022-12-05';
        $model->save();
    }
}
