<?php

namespace app\controllers;

use Yii;
use yii\helpers\Url;
use app\components\Controller;
use app\components\AuthHandler;
use app\models\CustomPage;
use app\models\OptionChain;
use app\models\ExpiryDates;
use app\models\LoginForm;
use app\models\Customer;
use app\models\Country;
use app\models\State;
use app\models\City;
use app\models\ChangePasswordFront;
use app\models\GlobalSentiments;
use app\models\PreMarketData;
use app\models\Stocks;
use app\models\Webhook;


class SiteController extends Controller
{

    public function actions()
    {
        return [
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    public function onAuthSuccess($client)
    {
        (new AuthHandler($client))->handle();
        return Yii::$app->response->redirect(['/dashboard/index']);
    }

    public function actionIndex()
    {
        $model = CustomPage::find()->andWhere(['url' => 'home'])->active()->one();
        if ($model && trim(@$model->parent_page) == "") {
            $title = '';
            if (trim(@$model->name) != '') {
                $title = @$model->name . ' | My Trade Bit';
            }

            $this->setupMeta(@$model->meta_tag, $title);
            return $this->render('index', [
                "model" => $model,
                'page' => $model->url,
                "contetWidgets" => $model->content_widgets
            ]);
        }
        throw new \yii\web\NotFoundHttpException();
    }



    public function actionCustomPage($model, $url, $redirect)
    {
        if ($redirect !== false)
            return $this->redirect($redirect, 301);

        $title = '';
        if (trim(@$model->name) != '') {
            $title = @$model->name . ' | My Trade Bit';
        }
        $this->setupMeta(@$model->meta_tag, $title);
        return $this->render('index', [
            "model" => $model,
            'page' => $model->url,
            "contetWidgets" => $model->content_widgets
        ]);
    }

    public function actionExpiryDates()
    {

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
        exit;
    }

    public function actionBackupJobs()
    {
        $results = OptionChain::find()->active()->all();
        $ce_arr = $pe_arr = [];
        if (!empty($results)) {
            foreach (OptionChain::find()->each(10) as $result) {
                $ce_arr[$result->strike_price . '_' . date('Ymd', strtotime($result->expiry_date)) . '_' . $result->type][] = [
                    'type' => $result->type,
                    'expiry_date' =>  date('Ymd', strtotime($result->expiry_date)),
                    'date_format' => date('Ymd', $result->created_at),
                    'time' => date('H:i', $result->created_at),
                    'ce_oi' => $result->ce_oi,
                    'ce_ltp' => $result->ce_ltp
                ];

                $pe_arr[$result->strike_price . '_' . date('Ymd', strtotime($result->expiry_date)) . '_' . $result->type][] = [
                    'type' => $result->type,
                    'expiry_date' =>  date('Ymd', strtotime($result->expiry_date)),
                    'date_format' => date('Ymd', $result->created_at),
                    'time' => date('H:i', $result->created_at),
                    'pe_oi' => $result->pe_oi,
                    'pe_ltp' => $result->pe_ltp
                ];
            }
        }

        $server_path_to_folder  = Yii::getAlias('@webroot') . '/media/files/NSE_OPT_1MIN_' . date('Ymd');
        if (!file_exists($server_path_to_folder)) {
            mkdir($server_path_to_folder, 0777, true);
        }

        $fileContent = '';

        if (!empty($ce_arr)) {
            foreach ($ce_arr as $k => $arr) {
                $fileContent = '';
                if (!empty($arr)) {
                    foreach ($arr as $kD => $aD) {
                        $fileContent .= $aD['date_format'] . "," . $aD['time'] . "," . $aD['ce_oi'] . "," . $aD['ce_ltp'] . "\n";
                    }
                }
                $val = explode('_', $k);
                $csv_filename = strtoupper($val[2]) . "" . $val[1] . "" . $val[0] . ".csv";
                $fd = fopen($server_path_to_folder . '/' . $csv_filename, "w");
                fputs($fd, $fileContent);
                fclose($fd);
            }
        }
        exit;
    }

    public function actionCronJobs()
    {
        $today_date =  strtotime(date('Y-m-d H:i:s'));
        $start_date = strtotime(date('Y-m-d 09:15:00'));
        $end_date = strtotime(date('Y-m-d 15:30:00'));
        $backup_date = strtotime(date('Y-m-d 16:00:00'));

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
            echo 'data';
            exit;
        }
        echo 'no data';
        exit;
    }

    public function actionCronGlobalSentiments()
    {
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
        echo 'Success';
        exit;
    }

    public function actionCronJobsFutures()
    {
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
            echo 'data';
            exit;
        }
        echo 'no data';
        exit;
    }

    public function actionLoginForm()
    {
        $model = new LoginForm();
        $model->type = 'customer';
        $submit = Yii::$app->request->post('ajaxSubmit', "");
        $result = [
            'status' => 404
        ];

        if ($model->load(Yii::$app->request->post())) {
            if ($submit === "" && Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            } else {
                if ($model->login()) {
                    Yii::$app->user->identity->updateCookie();
                    $result = [
                        'status' => 200,
                        'message' => 'Login Successfully.'
                    ];
                } else {
                    $result = [
                        'status' => 404,
                        'message' => $model->errors
                    ];
                }
            }
        }

        echo json_encode($result);
        exit();
    }

    public function actionRegisterForm()
    {
        $model = new Customer();
        $model->type = 'customer';
        $model->scenario = 'register';
        $submit = Yii::$app->request->post('ajaxSubmit', "");
        $result = [
            'status' => 404
        ];

        if ($model->load(Yii::$app->request->post())) {
            if ($submit === "" && Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            } else {
                if ($model->save()) {
                    Yii::$app->user->login($model, true ? 3600 * 24 * 30 : 0);
                    Yii::$app->user->identity->updateCookie();
                    $result = [
                        'status' => 200,
                        'message' => 'Register Successfully.'
                    ];
                } else {
                    $result = [
                        'status' => 404,
                        'message' => $model->errors
                    ];
                }
            }
        }

        echo json_encode($result);
        exit();
    }

    public function actionForgotPassword()
    {
        $model = new ChangePasswordFront();
        $model->scenario = 'resetEmail';
        $submit = Yii::$app->request->post('ajaxSubmit', "");
        $result = [
            'status' => 404
        ];

        if ($model->load(Yii::$app->request->post())) {
            if ($submit === "" && Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            } else if ($model->validate()) {
                $model->sendEmail();
                $result = [
                    'status' => 200,
                    'message' => "Reset password link has been sent to " . $model->email
                ];
                $model->email = NULL;
            } else {
                $result = [
                    'status' => 404,
                    'message' => $model->errors
                ];
            }
        }

        echo json_encode($result);
        exit();
    }

    public function actionGetState()
    {
        $options = '';
        if (Yii::$app->request->post()) {
            $list = State::find()->andWhere(['countryId' => Yii::$app->request->post()['id']])->active()->all();
            foreach ($list as $l) {
                $options .= '<option value="' . $l->id . '">' . $l->name . '</option>';
            }
        }
        return $options;
    }

    public function actionGetCity()
    {
        $options = '';
        if (Yii::$app->request->post()) {
            $list = City::find()->andWhere(['stateId' => Yii::$app->request->post()['id']])->active()->all();
            foreach ($list as $l) {
                $options .= '<option value="' . $l->id . '">' . $l->city_name . '</option>';
            }
        }
        echo $options;
    }


    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(['index']);
    }

    public function actionWebHooks()
    {
        $json = file_get_contents('php://input');
        $server_path_to_folder  = Yii::getAlias('@webroot') . '/media/text';
        $fname = 'stockdata-' . time() . '.dat';
        $fp = fopen($server_path_to_folder . '/' . $fname, "wb");
        fwrite($fp, $json);
        fclose($fp);
        die;
        echo "Written";
    }

    public function actionHeatMap()
    {
        $pre_close =  $this->getOpenMarket();
        $stocks = Stocks::find()->active()->all();



        $top_gainers = Webhook::find()->andWhere(['like', 'scan_name', 'Top Gainers'])->orderBy('id desc')->active()->one();
        $top_losers = Webhook::find()->andWhere(['like', 'scan_name', 'Top Losers'])->orderBy('id desc')->active()->one();

        $top_gainers_prices =  explode(',', @$top_gainers->trigger_prices);
        $top_gainers =  explode(',', @$top_gainers->stocks);

        $stocks_p = [];
        if (!empty($top_gainers)) {
            foreach ($top_gainers as $k => $top_gainer) {
                $stocks_p[$top_gainer] = $top_gainers_prices[$k];
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

        $heat = [];
        if (!empty($top_ga)) {
            foreach ($top_ga as $k => $top) {
                $heat[] = [
                    'name' => $k,
                    'children' => $top
                ];
            }
        }

        $heat_map = [
            "name" => "MARKET",
            "children" => $heat,
        ];

        $server_path_to_folder  = Yii::getAlias('@webroot') . '/js/dev/data.json';
        file_put_contents($server_path_to_folder,  json_encode($heat_map));
    }

    protected function getOpenMarket()
    {
        $pre_close = [];
        if (fopen(Yii::getAlias('@webroot') . '/webhook/Open-Market.csv', "r")) {
            $myfile = fopen(Yii::getAlias('@webroot') . '/webhook/Open-Market.csv', "r") or die("Unable to open file!");

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

    // public function actionGetCity()
    // {

    //     $states = State::find()->andWhere(['countryId' => 101])->active()->all();
    //     if(!empty($states)) {
    //         foreach(State::find()->andWhere(['countryId' => 101])->each(10) as $k => $st) {
    //             $c = Country::find()->andWhere(['id' => $st->countryId])->active()->one();
    //             $curl = curl_init();
    //             curl_setopt_array($curl, array(
    //                 CURLOPT_URL => 'https://api.countrystatecity.in/v1/countries/'.$c->iso.'/states/'.$st->iso.'/cities',
    //                 CURLOPT_RETURNTRANSFER => true,
    //                 CURLOPT_HTTPHEADER => array(
    //                     'X-CSCAPI-KEY: YTdYY05ieDN2clVFd25OVWFsNGg2RXZaalJ4QzcxRmJzRnI2Z29JcQ=='
    //                 ),
    //             ));
    //             $response = curl_exec($curl);
    //             curl_close($curl);
    //             $res = json_decode($response, true);
    //             if(!empty($res)) {
    //                 foreach($res as $k => $r){
    //                     $model = new City();
    //                     $model->city_name = $r['name'];
    //                     $model->countryId = $c->id;
    //                      $model->stateId = $st->id;
    //                      $model->save();
    //                 }
    //             }

    //         }
    //     }


    //     exit;
    // }
}
