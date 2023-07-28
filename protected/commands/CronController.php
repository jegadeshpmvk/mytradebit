<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use app\models\Page;

class CronController extends Controller
{

    public function actionWebHook()
    {
     header('Content-type: application/json');
        $json= file_get_contents(Yii::$app->request->getRawBody());
    
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
        echo "Email send process ended ::" . date('d/m/Y H:i:s A') . "\n";
        echo "\n";

        echo "Pdf generation process ended ::" . date('d/m/Y H:i:s A') . "\n";
        echo "\n";
    }
}