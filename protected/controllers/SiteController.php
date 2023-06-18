<?php

namespace app\controllers;

use app\components\Controller;
use app\models\CustomPage;

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
            "contetWidgets" => $model->content_widgets
        ]);
    }
}
