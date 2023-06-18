<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\CustomPage;
use app\modules\admin\models\CustomPageSearch;
use app\modules\admin\components\Controller;

class CustomPageController extends Controller {

    public $tab = "custom-page";

    public function behaviors() {
        return require(__DIR__ . '/../filters/LoginCheck.php');
    }

    public function actionIndex() {
        $searchModel = new CustomPageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    protected function renderForm($model) {
        if ($model->load(Yii::$app->request->post())) {
            $postRequest = Yii::$app->request->post("CustomPage");
            $content_widgets = isset($postRequest["content_widgets"]) && count($postRequest["content_widgets"]) > 0 ? $postRequest["content_widgets"] : false;
            if (!$content_widgets) {
                $model->content_widgets = array();
            }
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Page was saved successfully.');
                return $this->redirectCheck(['index']);
            } else {
                Yii::$app->session->setFlash('error', 'Please fix the errors.');
            }
        }

        return $this->render('_form', [
                    'model' => $model
        ]);
    }

    public function actionCreate() {
        $model = new CustomPage();
        $model->saveType = 'created';
        return $this->renderForm($model);
    }

    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $model->saveType = 'updated';
        return $this->renderForm($model);
    }

    public function actionDelete($id, $value) {
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

    protected function findModel($id) {
        if (($model = CustomPage::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
