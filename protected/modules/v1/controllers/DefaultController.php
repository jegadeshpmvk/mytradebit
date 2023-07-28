<?php

namespace app\modules\v1\controllers;

use Yii;
use yii\helpers\Html;
use app\components\ApiController;

class DefaultController extends ApiController {

    public function behaviors() {
        return [];
    }

    public function actionError() {
        header('Content-type: application/json');
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            echo json_encode([
                "status" => $exception->statusCode,
                "name" => Html::encode($exception->getMessage())
            ]);
            exit();
        }
        echo json_encode([
            "status" => 404,
            "name" => "The requested page does not exist."
        ]);
        exit();
    }
    
    public function actionWebHooks() {
        
        $json=file_get_contents('php://input');
        $payload=json_decode($json,true);
        $server_path_to_folder  = Yii::getAlias('@webroot') . '/media/text';
        $fname = 'stockdata-'.time().'.dat';
        $fp = fopen($server_path_to_folder.'/'.$fname,"wb");
        fwrite($fp,$json);
        fclose($fp);
          echo json_encode([
                "status" => 200,
                "name" => "Test"
            ]);
        die;
       
        echo "Written";
        
        //  $json = file_get_contents('php://input');
        // $payload = json_decode($json, true);
        
        //  $server_path_to_folder  = Yii::getAlias('@webroot') . '/media/text';
        // if (!file_exists($server_path_to_folder)) {
        //     mkdir($server_path_to_folder, 0777, true);
        // }
        // $myfile = fopen($server_path_to_folder."/newfile.txt", "w") or die("Unable to open file!");
        // fwrite($myfile, $payload);
        // fclose($myfile);
        // exit();
    }

}
