<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\components\Controller;
use app\models\HeaderFooter;
use yii\helpers\Html;

class HeaderFooterController extends Controller
{

    public $tab = "header-footer";

    public function behaviors()
    {
        return require(__DIR__ . '/../filters/LoginCheck.php');
    }


    public function actionIndex()
    {
        $model = HeaderFooter::find()->one();
        if (!$model) {
            $model = new HeaderFooter();
        }
        return $this->renderForm($model);
    }


    protected function renderForm($model)
    {
        $model->saveType = 'created';
        if ($model->created_at != '')
            $model->saveType = 'updated';
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Header Footer content was saved successfully.');
                return $this->redirectCheck(['index']);
            } else {
                //Html::errorSummary($model);
                Yii::$app->session->setFlash('error', 'Please fix the errors.');
            }
        }
        return $this->render('_form', [
            'model' => $model
        ]);
    }
}
