<?php

namespace app\modules\admin\controllers;

use app\modules\admin\components\Controller;

class ChartController extends Controller
{
       public $tab = "chart";


    public function actionIndex()
    {
        return $this->render('index');
    }
}