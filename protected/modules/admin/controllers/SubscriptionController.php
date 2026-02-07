<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Subscription;
use app\modules\admin\models\SubscriptionSearch;
use app\modules\admin\components\Controller;

class SubscriptionController extends Controller
{

    public $tab = "subscription";

    public function behaviors()
    {
        return require(__DIR__ . '/../filters/LoginCheck.php');
    }

    public function actionIndex()
    {
        $searchModel = new SubscriptionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    protected function renderForm($model)
    {
        if ($model->load(Yii::$app->request->post())) {
            if (trim($model->start_date) != '') {
                $model->start_date = date('Y-m-d', strtotime(str_replace('/', '-', $model->start_date)));
                $model->start_date = strtotime($model->start_date);
            }
            if (trim($model->end_date) != '') {
                $model->end_date = date('Y-m-d', strtotime(str_replace('/', '-', $model->end_date)));
                $model->end_date = strtotime($model->end_date);
            }
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Subscription was saved successfully.');
                return $this->redirectCheck(['index']);
            } else {
                Yii::$app->session->setFlash('error', 'Please fix the errors.');
            }
        }

        return $this->render('_form', [
            'model' => $model
        ]);
    }

    public function actionCreate()
    {
        $model = new Subscription();
        $model->saveType = 'created';
        return $this->renderForm($model);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->saveType = 'updated';
        return $this->renderForm($model);
    }

    public function actionDelete($id, $value)
    {
        $model = $this->findModel($id);
        $model->deleted = (int) $value;
        if ($value == 1) {
            $model->saveType = 'deleted';
            Yii::$app->session->setFlash('success', 'Subscription was deleted successfully.');
        } else {
            $model->saveType = 'restored';
            Yii::$app->session->setFlash('success', 'Subscription was restored successfully.');
        }
        $model->save();
        return $this->redirect(\Yii::$app->request->referrer);
    }

    protected function findModel($id)
    {
        if (($model = Subscription::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
