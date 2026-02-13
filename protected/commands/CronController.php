<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use app\models\Page;
use app\models\OptionChain;
use app\models\ExpiryDates;
use app\models\GlobalSentiments;
use app\models\PreMarketData;
use app\models\Stocks;
use app\models\Webhook;

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
    
      public function actionChecking()
    {
         echo "Checking started ".date('Y-m-d_H:i:s')."...\n";
          echo "Checking End ".date('Y-m-d_H:i:s')."...\n";
    }
    
    public function actionJobs()
    {
        ini_set('memory_limit', '-1');
        set_time_limit(0);
    
        echo "Backup started " . date('Y-m-d H:i:s') . "...\n";
    
        /* ===========================
         * Backup Folder Setup
         * =========================== */
    
        $folder = Yii::getAlias('@webrootmedia') .
            '/files/NSE_OPT_1MIN_' . date('Ymd');
    
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }
    
        echo "Backup Folder: " . $folder . "\n";
    
    
        /* ===========================
         * 1. CSV BACKUP (Safe Method)
         * =========================== */
    
        echo "CSV Backup started...\n";
    
        $buffer = [];   // store lines grouped by file
    
        foreach (OptionChain::find()->active()->each(1000) as $result) {
    
            $key = strtoupper(
                $result->type .
                date('Ymd', strtotime($result->expiry_date)) .
                $result->strike_price
            );
    
            $filePath = $folder . '/' . $key . '.csv';
    
            // Prepare CSV line
            if ($result->type === 'nifty') {
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
    
            // Add to buffer
            $buffer[$filePath][] = $line;
        }
    
        // Write all buffered data safely
        foreach ($buffer as $file => $lines) {
            file_put_contents(
                $file,
                implode(PHP_EOL, $lines) . PHP_EOL,
                FILE_APPEND
            );
        }
    
        echo "CSV backup completed " . date('Y-m-d H:i:s') . ".\n";
    
    
        /* ===========================
         * 2. SQL BACKUP (mysqldump)
         * =========================== */
    
        echo "SQL Backup started...\n";
    
        $db = Yii::$app->db;
    
        preg_match('/dbname=([^;]+)/', $db->dsn, $matches);
        $dbName = $matches[1];
    
        $sqlFile = $folder . '/option_chain_' . date('Ymd_His') . '.sql';
    
        // Correct table name with backticks
        $cmd = sprintf(
            'mysqldump -u%s -p%s %s --tables `option-chain` > %s',
            escapeshellarg($db->username),
            escapeshellarg($db->password),
            escapeshellarg($dbName),
            escapeshellarg($sqlFile)
        );
    
        exec($cmd, $output, $status);
    
        // Validate SQL backup success
        if ($status !== 0 || !file_exists($sqlFile) || filesize($sqlFile) === 0) {
            echo "❌ SQL backup failed. Table NOT truncated.\n";
            return Controller::EXIT_CODE_ERROR;
        }
    
        echo "SQL backup completed " . date('Y-m-d H:i:s') . ".\n";
    
    
        /* ===========================
         * 3. TRUNCATE TABLE (Safe)
         * =========================== */
    
        echo "Truncating table...\n";
    
        try {
            Yii::$app->db
                ->createCommand("TRUNCATE TABLE `option-chain`")
                ->execute();
    
            echo "✅ Table option-chain truncated successfully "
                . date('Y-m-d H:i:s') . ".\n";
    
        } catch (\Exception $e) {
    
            echo "❌ Truncate failed: " . $e->getMessage() . "\n";
            return Controller::EXIT_CODE_ERROR;
        }
    
    
        echo "Backup job finished successfully.\n";
    
        return Controller::EXIT_CODE_NORMAL;
    }
    
    
    public function actionBackupJobs()
        {
             ini_set('memory_limit', '-1');
        set_time_limit(0);
    
        echo "Backup started " . date('Y-m-d H:i:s') . "...\n";
        
            $server_path_to_folder  = Yii::getAlias('@webroot') . '/media/files/NSE_OPT_1MIN_' . date('Ymd');
        
            if (!file_exists($server_path_to_folder)) {
                mkdir($server_path_to_folder, 0777, true);
            }
        
            foreach (OptionChain::find()->each(100) as $result) {
        
                $key = $result->strike_price . '_' .
                       date('Ymd', strtotime($result->expiry_date)) . '_' .
                       $result->type;
        
                $csv_filename = strtoupper($result->type)
                    . date('Ymd', strtotime($result->expiry_date))
                    . $result->strike_price
                    . ".csv";
        
                $filePath = $server_path_to_folder . '/' . $csv_filename;
        
                // Build line (same format)
                if ($result->type == 'CE') {
                    $line = date('Ymd', $result->created_at) . ","
                        . date('H:i', $result->created_at) . ","
                        . $result->ce_oi . ","
                        . $result->ce_ltp . "\n";
                } else {
                    $line = date('Ymd', $result->created_at) . ","
                        . date('H:i', $result->created_at) . ","
                        . $result->pe_oi . ","
                        . $result->pe_ltp . "\n";
                }
        
                // Append directly instead of storing huge array
                file_put_contents($filePath, $line, FILE_APPEND);
            }
        
            exit;
        }
    
       public function runPdfCron($id) {
        // Pdf file generation
        $yiiPath = Yii::getAlias('@prefix').'/yii';
        $logPath = Yii::getAlias('@prefix').'/cron.log';
        // Executing command cron/pdf action
        $cmd = "php " . $yiiPath . " cron/jobs ".$id." >> " . $logPath . " &";
        $output = exec($cmd);
    }
    
     public function actionExpiryDates()
    {
         echo "Expiry Dates started ".date('Y-m-d_H:i:s')."...\n";
        $options = ['nifty', 'nifty-bank'];
        Yii::$app->db->createCommand()->truncateTable('expiry-dates')->execute();
        foreach ($options as $key => $option) {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://groww.in/v1/api/option_chain_service/v1/option_chain/' . $option,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Cookie: __cf_bm=qw475hWN2MX3st6Gs8JvspAtAsZ4YCJhdHhQUOC6QNo-1684042147-0-AVzOXMRaBgw7GSUqp/nY2C5tL21r5NrKPn3U5I6TPk5Ws6ZxZU/IMHvrciba/WjOLLUnmHRvIowXRld+oUk1WKA=; __cfruid=070d89563bc714373ffb8f573eb10717354acf70-1684042147; _cfuvid=U6WIyVka7oyfhAHoiW0ma3zdkTP9k2Fw4gapZzHqlXc-1684042147697-0-604800000'
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            $res = json_decode($response);
            if (!empty($res->optionChain->expiryDetailsDto->expiryDates)) {
                foreach ($res->optionChain->expiryDetailsDto->expiryDates as $k => $dates) {
                    $model = new ExpiryDates();
                    $model->type =  $option;
                    $model->date =  $dates;
                    $model->save();
                }
            }
        }
        echo "Expiry Dates Ended ".date('Y-m-d_H:i:s')."...\n";
        exit;
    }
    
     public function actionOptionJobs() {
          echo "Option Jobs Ended ".date('Y-m-d_H:i:s')."...\n";
        $today_date =  strtotime(date('Y-m-d H:i:s'));
        $start_date = strtotime(date('Y-m-d 09:15:00'));
        $end_date = strtotime(date('Y-m-d 15:30:00'));
        $backup_date = strtotime(date('Y-m-d 16:00:00'));
        echo 'Today'.date('Y-m-d H:i:s');echo "...\n";
        echo 'Start Date'.date('Y-m-d 09:15:00');echo "...\n";
        echo 'End Date'.date('Y-m-d 15:30:00');echo "...\n";
        $options = ['nifty', 'nifty-bank'];

        if ($today_date >= $start_date && $today_date <= $end_date) {
            $data = "";
            foreach ($options as $key => $option) {
                $expiryDates = ExpiryDates::find()->andWhere(['type' => $option])->active()->all();
                if (!empty($expiryDates)) {
                    foreach ($expiryDates as $ek => $expiryDate) {
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://groww.in/v1/api/option_chain_service/v1/option_chain/' . $option . '?expiry=' . $expiryDate->date,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'GET',
                            CURLOPT_HTTPHEADER => array(
                                'Cookie: __cf_bm=qw475hWN2MX3st6Gs8JvspAtAsZ4YCJhdHhQUOC6QNo-1684042147-0-AVzOXMRaBgw7GSUqp/nY2C5tL21r5NrKPn3U5I6TPk5Ws6ZxZU/IMHvrciba/WjOLLUnmHRvIowXRld+oUk1WKA=; __cfruid=070d89563bc714373ffb8f573eb10717354acf70-1684042147; _cfuvid=U6WIyVka7oyfhAHoiW0ma3zdkTP9k2Fw4gapZzHqlXc-1684042147697-0-604800000'
                            ),
                        ));
                        $response = curl_exec($curl);
                        curl_close($curl);
                        $res = json_decode($response);
                        if (!empty($res) && !empty($res->optionChain->optionChains)) {
                            foreach ($res->optionChain->optionChains as $k => $op) {
                                $data .= "('" . $option . "','" . ($op->strikePrice / 100) . "', '" . @$op->callOption->openInterest . "', '" . @$op->callOption->ltp . "', '" . @$op->putOption->openInterest . "', '" .  @$op->putOption->ltp . "', '" . $today_date . "', '" . $expiryDate->date . "', '0', '" . $today_date . "'),";
                            }
                        }
                    }
                }
            }
            $connection = Yii::$app->getDb();
        
            $command = $connection->createCommand("INSERT INTO `option-chain` (type,strike_price,ce_oi,ce_ltp,pe_oi,pe_ltp,created_at,expiry_date,deleted,updated_at) VALUES " . rtrim($data, ","));
            $result = $command->queryAll();
            echo "Option Jobs DB Inserted ".date('Y-m-d_H:i:s')."...\n";
            exit;
        }
         echo "Option Jobs Ended ".date('Y-m-d_H:i:s')."...\n";
        exit;
    }
    
    public function actionGlobalSentiments()
    {
         echo "Global Sentiments Started ".date('Y-m-d_H:i:s')."...\n";
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://groww.in/v1/api/stocks_data/v1/global_instruments?instrumentType=GLOBAL_INSTRUMENTS',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET'
        ]);
        $response = curl_exec($curl);
        curl_close($curl);
        $getGlobalSentiments =  json_decode($response, true);


        if (!empty($getGlobalSentiments) && !empty($getGlobalSentiments['aggregatedGlobalInstrumentDto'])) {
            Yii::$app->db->createCommand()->truncateTable('global-sentiments')->execute();
            foreach ($getGlobalSentiments['aggregatedGlobalInstrumentDto'] as $k => $getGlobalSentiment) {
                if ($getGlobalSentiment['instrumentDetailDto']['name'] === 'DOW JONES FUTURES' || $getGlobalSentiment['instrumentDetailDto']['name'] === 'GIFT NIFTY') {
                    continue;
                }

                $global = new GlobalSentiments();
                $global->logoUrl = @$getGlobalSentiment['instrumentDetailDto']['logoUrl'];
                $global->name =  @$getGlobalSentiment['instrumentDetailDto']['name'];
                $global->tsInMillis =  @$getGlobalSentiment['livePriceDto']['tsInMillis'];
                $global->close =  @$getGlobalSentiment['livePriceDto']['close'];
                $global->value =  @$getGlobalSentiment['livePriceDto']['value'];
                $global->dayChange =  @$getGlobalSentiment['livePriceDto']['dayChange'];
                $global->dayChangePerc =  @$getGlobalSentiment['livePriceDto']['dayChangePerc'];
                $global->save(false);
            }
        }
        
          echo "Global Sentiments Ended ".date('Y-m-d_H:i:s')."...\n";
        
           echo "Pre Market Data Started ".date('Y-m-d_H:i:s')."...\n";

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://www.nseindia.com/api/allIndices',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET'
        ]);
        $response = curl_exec($curl);
        curl_close($curl);
        $pre_marketdata =  json_decode($response, true);

        $cat = ['NIFTY 50', 'NIFTY BANK', 'NIFTY FINANCIAL SERVICES', 'NIFTY AUTO', 'NIFTY IT', 'NIFTY FMCG', 'NIFTY METAL', 'NIFTY PHARMA', 'NIFTY OIL & GAS'];

        if (isset($pre_marketdata['data']) && !empty($pre_marketdata['data'])) {
            Yii::$app->db->createCommand()->truncateTable('pre_market_data')->execute();
            foreach ($pre_marketdata['data'] as $k => $d) {
                if (in_array($d['index'], $cat)) {
                    $pre_market = new PreMarketData();
                    $pre_market->name = $d['index'];
                    $pre_market->open = $d['open'];
                    $pre_market->previousClose = $d['previousClose'];
                    $pre_market->percentChange = $d['percentChange'];
                    // echo '<pre>';
                    // print_r($pre_market);exit;
                    $pre_market->save(false);
                }
            }
        }
          echo "Pre Market Data Ended ".date('Y-m-d_H:i:s')."...\n";
    }
    
    protected function getOpenMarket()
    {
        $pre_close = [];
        if (fopen(Yii::getAlias('@webhook') . '/Open-Market.csv', "r")) {
            $myfile = fopen(Yii::getAlias('@webhook') . '/Open-Market.csv', "r") or die("Unable to open file!");

            while (($data = fgetcsv($myfile)) !== false) {
                $pre_close[$data[0]] = [
                    @$data[1],
                    @$data[5],
                ];
            }
            fclose($myfile);
        }
        return $pre_close;
    }
    
    public function actionHeatMap()
    {
            echo "Heat Map Started ".date('Y-m-d_H:i:s')."...\n";
        $pre_close =  $this->getOpenMarket();
        $stocks = Stocks::find()->active()->all();

        $top_gainers = Webhook::find()->andWhere(['like', 'scan_name', 'Top Gainers'])->orderBy('id desc')->active()->one();
        $top_losers = Webhook::find()->andWhere(['like', 'scan_name', 'Top Losers'])->orderBy('id desc')->active()->one();

        $top_gainers_prices =  explode(',', @$top_gainers->trigger_prices);
        $top_gainers =  explode(',', @$top_gainers->stocks);

        $top_losers_prices =  explode(',', @$top_losers->trigger_prices);
        $top_losers =  explode(',', @$top_losers->stocks);

        $stocks_p = [];
        if (!empty($top_gainers)) {
            foreach ($top_gainers as $k => $top_gainer) {
                $stocks_p[$top_gainer] = $top_gainers_prices[$k];
            }
        }

        if (!empty($top_losers)) {
            foreach ($top_losers as $k => $top_loser) {
                $stocks_p[$top_loser] = $top_losers_prices[$k];
            }
        }

        $top_ga = [];
        if (!empty($stocks)) {
            foreach ($stocks as $k => $stock) {
                if (array_key_exists($stock->name, $pre_close)) {
                    if (in_array($stock->name, $top_gainers)) {
                        $top_ga[$stock->sector][] = [
                            "rate" => number_format((float)((($stocks_p[$stock->name] - Yii::$app->function->getAmount($pre_close[$stock->name][0])) / Yii::$app->function->getAmount($pre_close[$stock->name][0])) * 100), 2, '.', ''),
                            "name" => $stock->name,
                            "value" => (int) $stocks_p[$stock->name]
                        ];
                    }
                }
            }
        }

        $top_lo = [];
        if (!empty($stocks)) {
            foreach ($stocks as $k => $stock) {
                if (array_key_exists($stock->name, $pre_close)) {
                    if (in_array($stock->name, $top_losers)) {
                        $top_lo[$stock->sector][] = [
                            "rate" => number_format((float)((($stocks_p[$stock->name] - Yii::$app->function->getAmount($pre_close[$stock->name][0])) / Yii::$app->function->getAmount($pre_close[$stock->name][0])) * 100), 2, '.', ''),
                            "name" => $stock->name,
                            "value" => (int) $stocks_p[$stock->name]
                        ];
                    }
                }
            }
        }

        $heat = [];
        if (!empty($top_ga)) {
            foreach ($top_ga as $k => $top) {
                $heat[] = [
                    'name' => $k,
                    'children' => $top
                ];
            }
        }

        // if (!empty($top_lo)) {
        //     foreach ($top_lo as $k => $top_l) {
        //         $heat[] = [
        //             'name' => $k,
        //             'children' => $top_l
        //         ];
        //     }
        // }
        
      if (!empty($top_lo)) {
        foreach ($top_lo as $k => $top_l) {
    
            $found = false;
    
            // 🔍 Search existing heat array by name
            foreach ($heat as &$h) {
                if ($h['name'] === $k) {
                    // ✅ Name found → merge children
                    $h['children'] = array_merge($h['children'], $top_l);
                    $found = true;
                    break;
                }
            }
            unset($h); // important reference cleanup
    
            // ❌ Name not found → add new entry
            if (!$found) {
                $heat[] = [
                    'name' => $k,
                    'children' => $top_l
                ];
            }
        }
    }

        $heat_map = [
            "name" => "MARKET",
            "children" => $heat,
        ];

        $server_path_to_folder  = Yii::getAlias('@webroot') . '/js/dev/data.json';
        file_put_contents($server_path_to_folder,  json_encode($heat_map));
       echo "Heat Map Ended ".date('Y-m-d_H:i:s')."...\n";
    }
    
     public function actionJobsFutures()
    {
        echo "Job Futures Started ".date('Y-m-d_H:i:s')."...\n";
        $today_date =  strtotime(date('Y-m-d H:i:s'));
        $start_date = strtotime(date('Y-m-d 09:15:00'));
        $end_date = strtotime(date('Y-m-d 15:30:00'));
        $options = ['nifty', 'nifty-bank'];

        if ($today_date >= $start_date && $today_date <= $end_date) {
            $data = "";
            foreach ($options as $key => $option) {
                $curl = curl_init();
                curl_setopt_array($curl, [
                    CURLOPT_URL => 'https://groww.in/v1/api/stocks_fo_data/v1/derivatives/' . $option . '/contract',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array(
                        'Cookie: __cf_bm=qw475hWN2MX3st6Gs8JvspAtAsZ4YCJhdHhQUOC6QNo-1684042147-0-AVzOXMRaBgw7GSUqp/nY2C5tL21r5NrKPn3U5I6TPk5Ws6ZxZU/IMHvrciba/WjOLLUnmHRvIowXRld+oUk1WKA=; __cfruid=070d89563bc714373ffb8f573eb10717354acf70-1684042147; _cfuvid=U6WIyVka7oyfhAHoiW0ma3zdkTP9k2Fw4gapZzHqlXc-1684042147697-0-604800000'
                    ),
                ]);
                $response = curl_exec($curl);
                curl_close($curl);
                $res = json_decode($response);
                if (!empty($res) && !empty($res->livePrice)) {
                    $data .= "('" . $option . "','" . $res->livePrice->volume . "', '" . $res->livePrice->openInterest . "', '" . $res->livePrice->ltp . "', '" . $res->contractDetails->expiry . "', 0,'" . $today_date . "', '" . $today_date . "'),";
                }
            }
            $connection = Yii::$app->getDb();
            $command = $connection->createCommand("INSERT INTO `futures-board` (type,volume,openInterest,ltp,expiry,deleted,created_at,updated_at) VALUES " . rtrim($data, ","));
            $result = $command->queryAll();
            echo "Job Futures DB Inserted ".date('Y-m-d_H:i:s')."...\n";
            exit;
        }
        echo "Job Futures Ended ".date('Y-m-d_H:i:s')."...\n";
        exit;
    }
}