<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\FiiDii;
use app\modules\admin\models\FiiDiiSearch;
use app\modules\admin\components\Controller;

class FiiDiiController extends Controller
{

    public $tab = "fii-dii";

    public function behaviors()
    {
        return require(__DIR__ . '/../filters/LoginCheck.php');
    }

    public function actionIndex()
    {
        $searchModel = new FiiDiiSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    protected function renderForm($model)
    {
        if ($model->load(Yii::$app->request->post())) {
            $postRequest = Yii::$app->request->post("FiiDii");
            if (trim($model->date) != '') {
                $model->date = date('Y-m-d', strtotime(str_replace('/', '-', $model->date)));
                $model->date = strtotime($model->date);
            }
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Data was saved successfully.');
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
        $model = new FiiDii();
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
            Yii::$app->session->setFlash('success', 'Page was deleted successfully.');
        } else {
            $model->saveType = 'restored';
            Yii::$app->session->setFlash('success', 'Page was restored successfully.');
        }
        $model->save();
        return $this->redirect(\Yii::$app->request->referrer);
    }

    protected function findModel($id)
    {
        if (($model = FiiDii::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
