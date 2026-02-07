<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Customer;
use app\modules\admin\models\CustomerSearch;
use app\modules\admin\components\Controller;
use yii\web\NotFoundHttpException;

class CustomerController extends Controller
{

    public $tab = "customers";

    // public function behaviors() {
    //     return require(__DIR__ . '/../filters/LoginCheck.php');
    // }

    public function actionIndex()
    {
        $searchModel = new CustomerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    protected function renderForm($model)
    {
        if ($model->load(Yii::$app->request->post())) {
            if ($model->saveType === 'created') {
                $model->email_hash = md5(time() . Yii::$app->params['salt'] . $model->id . $model->email);
            }
            if ($model->save()) {
                if ($model->saveType === 'created') {
                    Yii::$app->mailer->compose('email', ['name' => $model->fullname, 'data' => ['title' => 'Password Reset', 'user' => $model]])
                        ->setFrom(Yii::$app->params['fromEmail'])
                        ->setTo($model->email)
                        ->setSubject('Password Reset')
                        ->send();
                }
                Yii::$app->session->setFlash('success', 'Customer details were saved successfully.');
                return $this->redirectCheck(['index']);
            } else
                Yii::$app->session->setFlash('error', "Please fix the errors.");
        }

        return $this->render('_form', [
            'model' => $model
        ]);
    }

    public function actionCreate()
    {
        $model = new Customer();
        $model->type = 'customer';
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
        } else {
            $model->saveType = 'restored';
        }
        $model->save(false);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionPassword($id)
    {
        $model = Customer::findOne($id);
        $model->scenario = 'password_change';
        $model->password = '';
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->saveType = 'password changed';
                $model->password = Customer::generatePassword($model->password);
                if ($model->save(false)) {
                    Yii::$app->session->setFlash('success', 'Password was saved successfully.');
                    return $this->redirect(['password', 'id' => $model->id]);
                }
            }
        }
        return $this->render('password', [
            'model' => $model,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Customer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
