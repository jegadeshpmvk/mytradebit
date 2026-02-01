<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use app\models\Page;
use app\models\OptionChain;

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
    
    public function actionJobs()
    {
        ini_set('memory_limit', '-1');
        set_time_limit(0);

        echo "Backup started...\n";

        $folder =  Yii::getAlias('@webrootmedia') . '/files/NSE_OPT_1MIN_' . date('Ymd');
        
        echo $folder;
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        /* =======================
         * 1. CSV BACKUP
         * ======================= */
        $fileHandles = [];

        foreach (OptionChain::find()->active()->each(1000) as $result) {

            $key = strtoupper(
                $result->type .
                date('Ymd', strtotime($result->expiry_date)) .
                $result->strike_price
            );

            $filePath = $folder . '/' . $key . '.csv';

            if (!isset($fileHandles[$key])) {
                $fileHandles[$key] = fopen($filePath, 'a');
            }

            if ($result->type === 'CE') {
                $line = implode(',', [
                    date('Ymd', $result->created_at),
                    date('H:i', $result->created_at),
                    $result->ce_oi,
                    $result->ce_ltp
                ]);
            } else {
                $line = implode(',', [
                    date('Ymd', $result->created_at),
                    date('H:i', $result->created_at),
                    $result->pe_oi,
                    $result->pe_ltp
                ]);
            }

            fwrite($fileHandles[$key], $line . PHP_EOL);
        }

        foreach ($fileHandles as $fh) {
            fclose($fh);
        }

        echo "CSV backup completed.\n";

        /* =======================
         * 2. SQL BACKUP
         * ======================= */
        $db = Yii::$app->db;
        echo '<pre>';
        print_r($db->username);
        preg_match('/dbname=([^;]+)/', $db->dsn, $matches);
        $dbName = $matches[1];

        $sqlFile = $folder . '/option_chain_' . date('Ymd_His') . '.sql';

        $cmd = sprintf(
            'mysqldump -u%s -p%s %s option-chain > %s',
            escapeshellarg($db->username),
            escapeshellarg($db->password),
            escapeshellarg($dbName),
            escapeshellarg($sqlFile)
        );

        exec($cmd, $output, $status);

        if ($status !== 0 || !file_exists($sqlFile) || filesize($sqlFile) === 0) {
            echo "❌ SQL backup failed. Table NOT truncated.\n";
            return Controller::EXIT_CODE_ERROR;
        }

        echo "SQL backup completed.\n";

        /* =======================
         * 3. TRUNCATE TABLE
         * ======================= */
        Yii::$app->db->createCommand('TRUNCATE TABLE `option-chain`')->execute();

        echo "Table option-chain truncated successfully.\n";
        echo "Backup job finished.\n";

        return Controller::EXIT_CODE_NORMAL;
    }
    
       public function runPdfCron($id) {
        // Pdf file generation
        $yiiPath = Yii::getAlias('@prefix').'/yii';
        $logPath = Yii::getAlias('@prefix').'/cron.log';
        // Executing command cron/pdf action
        $cmd = "php " . $yiiPath . " cron/jobs ".$id." >> " . $logPath . " &";
        $output = exec($cmd);
    }
}