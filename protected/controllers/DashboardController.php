<?php

namespace app\controllers;

use Yii;
use app\components\Controller;
use app\models\Customer;
use app\models\FiiDii;
use app\models\Webhook;
use app\models\Stocks;
use app\models\PreMarketData;
use app\models\GlobalSentiments;

class DashboardController extends Controller
{
    public function behaviors()
    {
        return require(__DIR__ . '/filters/LoginCheck.php');
    }

    public function actionIndex()
    {
        $this->setupMeta([], 'Dashboard');
        $details =  FiiDii::find()->active()->orderBy(['date' => SORT_DESC])->one();
        $pre_marketdata = $this->getPreMarketData();
        $open = [];
        $percentChange = [];
        $cat = ['NIFTY BANK', 'NIFTY FINANCIAL SERVICES', 'NIFTY AUTO', 'NIFTY IT', 'NIFTY FMCG', 'NIFTY METAL', 'NIFTY PHARMA', 'NIFTY OIL & GAS'];
       
         $pre_market = PreMarketData::find()->active()->all();
        if (!empty($pre_market)) {
                foreach ($pre_market as $k => $pre) {
                   // $f_data = PreMarketData::find()->andWhere(['name', ])
                    $d_open = $pre->open;
                    $d_previousClose = $pre->previousClose;
                    $open[] = number_format((float)(($d_open - $d_previousClose) / $d_previousClose) * 100, 2, '.', '');
                    $percentChange[] = (float) $pre->percentChange;
                }
            }


        $pre_market_date = '';
        if (date('N') !== 6 && date('N') !== 7) {
            $pre_market_date = date('d M y');
        }
        return $this->render('index', [
            'getGlobalSentiments' => GlobalSentiments::find()->active()->all(),
            'details' => [$details->stocks_fii, $details->stocks_dii],
            'stocks_sentiment' => $details->stocks_sentiment,
            'date' => @$details->date ? date('d M y', @$details->date) : '---',
            'percentChange' => $percentChange,
            'open' => $open,
            'cat' => $cat,
            'pre_market_date' => $pre_market_date
        ]);
    }

    public function actionOptionsBoardHistoryData()
    {
        $stocks_type =  Yii::$app->request->post('stocks_type');
        $current_date =  Yii::$app->request->post('trade_date');
        $expiry_date = Yii::$app->request->post('expiry_date');
        $start_time =  Yii::$app->request->post('start_time');
        $end_time = Yii::$app->request->post('end_time');
        $min = Yii::$app->request->post('min');
        $from_stike_price = Yii::$app->request->post('from_stike_price');
        $to_stike_price = Yii::$app->request->post('to_stike_price');
        if ($stocks_type == 'nifty-bank') {
            $type = 'BANKNIFTY';
        } else {
            $type = 'NIFTY';
        }

        for ($i = $from_stike_price; $i <= $to_stike_price; $i += 50) {
            if (fopen(Yii::getAlias('@webroot') . '/media/files/NSE_OPT_1MIN_' . date('Ymd', strtotime(str_replace('/', '-', $current_date))) . '/' . $type . '' .   date('ymd', strtotime(str_replace('/', '-', $expiry_date))) . '' . $i . 'CE.csv', "r")) {
                $myfile = fopen(Yii::getAlias('@webroot') . '/media/files/NSE_OPT_1MIN_' . date('Ymd', strtotime(str_replace('/', '-', $current_date))) . '/' . $type . '' .   date('ymd', strtotime(str_replace('/', '-', $expiry_date))) . '' . $i . 'CE.csv', "r") or die("Unable to open file!");

                while (($data = fgetcsv($myfile)) !== false) {
                    print_r($data);
                    exit;
                }
                fclose($myfile);
            }
        }
        exit;
    }

    public function actionOptionsBoardData()
    {
        $nifty_live = $this->getNiftyLiveData();
        $bank_live = $this->getBankLiveData();
        $type = Yii::$app->request->post('stocks_type');
        $current_date =  Yii::$app->request->post('trade_date');
        $expiry_date = Yii::$app->request->post('expiry_date');
        $start_time =  Yii::$app->request->post('start_time');
        $end_time = Yii::$app->request->post('end_time');
        $min = 1;
        $from_strike =  Yii::$app->request->post('from_strike_price');
        $to_strike =  Yii::$app->request->post('to_strike_price');
        
        $connection = Yii::$app->getDb();
        $nifty_data = $connection->createCommand('SELECT * FROM `option-chain` 
WHERE type= "' . $type . '" AND  strike_price BETWEEN 
' . $from_strike . ' AND ' . $to_strike . ' AND expiry_date = "' . $expiry_date . '" 
AND MOD(TIMESTAMPDIFF(MINUTE,concat(DATE(FROM_UNIXTIME(`created_at`)), " ", "09:15:00"), FROM_UNIXTIME (created_at)), ' . $min . ') = 0
AND TIMESTAMPDIFF(MINUTE,concat(DATE(FROM_UNIXTIME(`created_at`)), " ", "09:16:00"), FROM_UNIXTIME (created_at)) >= 0
AND (CONVERT(DATE_FORMAT(FROM_UNIXTIME(`created_at`), "%H"), DECIMAL) >= 9)
    AND created_at BETWEEN 
    ' . strtotime(date('Y-m-d ' . $start_time . ':00', strtotime(str_replace('/', '-', $current_date)))) . ' AND 
    ' . strtotime(date('Y-m-d ' . $end_time . ':00', strtotime(str_replace('/', '-', $current_date)))));
        
        $nifty_data = $nifty_data->queryAll();
        
        
       
        $nifty_max = $connection->createCommand('SELECT * FROM `option-chain` 
WHERE type= "' . $type . '" AND expiry_date = "' . $expiry_date . '" AND created_at BETWEEN 
    ' . strtotime(date('Y-m-d ' . $start_time . ':00', strtotime(str_replace('/', '-', $current_date)))) . ' AND 
    ' . strtotime(date('Y-m-d ' . $end_time . ':00', strtotime(str_replace('/', '-', $current_date)))));
        $nifty_max_data = $nifty_max->queryAll();
        

         $nifty_max_call = $connection->createCommand('SELECT strike_price FROM `option-chain` 
WHERE type= "' . $type . '" AND expiry_date = "' . $expiry_date . '" AND created_at BETWEEN 
    ' . strtotime(date('Y-m-d ' . $start_time . ':00', strtotime(str_replace('/', '-', $current_date)))) . ' AND 
    ' . strtotime(date('Y-m-d ' . $end_time . ':00', strtotime(str_replace('/', '-', $current_date)))) .' AND ce_oi = (SELECT MAX(ce_oi) FROM `option-chain` 
WHERE type= "' . $type . '" AND expiry_date = "' . $expiry_date . '" AND created_at BETWEEN 
    ' . strtotime(date('Y-m-d ' . $start_time . ':00', strtotime(str_replace('/', '-', $current_date)))) . ' AND 
    ' . strtotime(date('Y-m-d ' . $end_time . ':00', strtotime(str_replace('/', '-', $current_date)))).') group by strike_price');
    
        $nifty_max_call_data = $nifty_max_call->queryAll();
        
        $nifty_max_put = $connection->createCommand('SELECT strike_price FROM `option-chain` 
WHERE type= "' . $type . '" AND expiry_date = "' . $expiry_date . '" AND created_at BETWEEN 
    ' . strtotime(date('Y-m-d ' . $start_time . ':00', strtotime(str_replace('/', '-', $current_date)))) . ' AND 
    ' . strtotime(date('Y-m-d ' . $end_time . ':00', strtotime(str_replace('/', '-', $current_date)))) .' AND pe_oi = (SELECT MAX(pe_oi) FROM `option-chain` 
WHERE type= "' . $type . '" AND expiry_date = "' . $expiry_date . '" AND created_at BETWEEN 
    ' . strtotime(date('Y-m-d ' . $start_time . ':00', strtotime(str_replace('/', '-', $current_date)))) . ' AND 
    ' . strtotime(date('Y-m-d ' . $end_time . ':00', strtotime(str_replace('/', '-', $current_date)))).') group by strike_price');
        $nifty_max_put_data = $nifty_max_put->queryAll();
       
       $nifty_value= [];
        if (!empty($nifty_data)) {
            foreach ($nifty_data as $k => $res) {
                $nifty_value[$res['strike_price']][] = [
                    'strike_price' => $res['strike_price'],
                    'time' => $res['created_at'],
                    'ce_oi' => $res['ce_oi'],
                    'pe_oi' => $res['pe_oi'],
                    'ce_ltp' => $res['ce_ltp'],
                    'pe_ltp' => $res['pe_ltp'],
                    'date_format' => date('d M H:i', $res['created_at'])
                ];
            }
        }
        
        $nifty_max_arr_value= [];
        if (!empty($nifty_max_data)) {
            foreach ($nifty_max_data as $k => $res) {
                $nifty_max_arr_value[$res['strike_price']][] = [
                    'strike_price' => $res['strike_price'],
                    'time' => $res['created_at'],
                    'ce_oi' => $res['ce_oi'],
                    'pe_oi' => $res['pe_oi'],
                    'ce_ltp' => $res['ce_ltp'],
                    'pe_ltp' => $res['pe_ltp'],
                    'date_format' => date('d M H:i', $res['created_at'])
                ];
            }
        }
        
        $a = [
            'options_scope' =>  $this->render('blocks/options_scope', [
                'nifty_data' => $nifty_value, 'live_value' => $type === 'nifty' ? @$nifty_live['value'] : @$bank_live['value']
            ]),
            'net_oi' => $this->render('blocks/net_oi', [
                'nifty_data' => $nifty_value,
                'current_date' => $current_date
            ]),
            'options_sentiment' => $this->render('blocks/options_sentiment', [
                'nifty_max_call_data' => $nifty_max_call_data,
                'nifty_max_put_data' => $nifty_max_put_data,
                'nifty_max_data' => $nifty_max_arr_value,
                'current_date' => $current_date
            ]),
            'total_open' => $this->render('blocks/open_interest', [
                'nifty_data' => $nifty_value,
                'nifty_max_data' => $nifty_max_arr_value,
                'current_date' => $current_date
            ]),
        ];
        echo json_encode($a);
        exit;
    }

    public function actionOptionsBoard()
    {
        $nifty_live = $this->getNiftyLiveData();
        $bank_live = $this->getBankLiveData();
        $this->setupMeta([], 'Options Board');
        return $this->render('options-board', [
            'nifty_live' => ($nifty_live == ''  ? 0 : $nifty_live['value']),
            'bank_live' => ($bank_live == ''  ? 0 : $bank_live['value']),
        ]);
    }
    
    public function actionFuturesBoard(){
        $nifty_live = $this->getNiftyLiveData();
        $bank_live = $this->getBankLiveData();
        
        $this->setupMeta([], 'Futures Board');
         return $this->render('futures-board', [
            'nifty_live' => ($nifty_live == ''  ? 0 : $nifty_live['value']),
            'bank_live' => ($bank_live == ''  ? 0 : $bank_live['value']),
        ]);
    }
    
    public function actionFuturesBoardData(){
        $nifty_live = $this->getNiftyLiveData();
        $bank_live = $this->getBankLiveData();
        
        $a = [
            'futures_board' =>  $this->render('blocks/futures_board', [])
        ];
        echo json_encode($a);
        exit;
    }

    public function actionAccountDetails()
    {
        $this->setupMeta([], 'Account Details');

        return $this->render('account-details', [
            "model" => $this->findModel()
        ]);
    }

    public function actionPlans()
    {
        $this->setupMeta([], 'Plans');
        return $this->render('plans', [
            "model" => $this->findModel()
        ]);
    }

    public function actionGetFiiHistorical()
    {
        $r = [];
        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
            $r = $this->dataType($post['type']);
            $r[] =  [
                'name' => 'Nifty',
                'type' => 'line',
                'data' => []
            ];
            $r[] =  [
                'name' => 'Banknifty',
                'type' => 'line',
                'data' => []
            ];

            $first_day_this_month = strtotime(date($post["val"] . '-01'));
            $last_day_this_month  = strtotime(date($post["val"] . '-t'));
            $chat_datas = FiiDii::find()->andWhere(['>=', 'date', $first_day_this_month])->andWhere(['<=', 'date', $last_day_this_month])->active()->orderBy(['date' => SORT_ASC])->all();

            $cat = [];
            if (!empty($chat_datas)) {
                foreach ($chat_datas as $k => $cds) {
                    $r[0]['data'][] = $cds[$r[0]['dataName']];
                    $r[1]['data'][] = $cds[$r[1]['dataName']];
                    $r[2]['data'][] = $cds->common_nifty;
                    $r[3]['data'][] = $cds->common_banknifty;
                    $cat[] = date('d M Y', $cds->date);
                }
            }
        }
        echo json_encode([
            'result' => $r,
            'cat' => $cat
        ]);
        exit;
    }

    public function actionFiiDii()
    {
        $this->setupMeta([], 'FII - DII Data');
        $first_day_this_month = strtotime(date('Y-m-01'));
        $last_day_this_month  = strtotime(date('Y-m-t'));
        $chat_datas = FiiDii::find()->andWhere(['>=', 'date', $first_day_this_month])->andWhere(['<=', 'date', $last_day_this_month])->active()->orderBy(['date' => SORT_ASC])->all();
        $r = [
            [
                'name' => 'Fii',
                'type' => 'column',
                'data' => []
            ],
            [
                'name' => 'Dii',
                'type' => 'column',
                'data' => []
            ],
            [
                'name' => 'Nifty',
                'type' => 'line',
                'data' => []
            ],
            [
                'name' => 'Banknifty',
                'type' => 'line',
                'data' => []
            ]
        ];
        $cat = [];
        if (!empty($chat_datas)) {
            foreach ($chat_datas as $k => $cds) {
                $r[0]['data'][] = $cds->stocks_fii;
                $r[1]['data'][] = $cds->stocks_dii;
                $r[2]['data'][] = $cds->common_nifty;
                $r[3]['data'][] = $cds->common_banknifty;
            }
        }
        if (!empty($chat_datas)) {
            foreach ($chat_datas as $k => $cds) {
                $cat[] = date('d M Y', $cds->date);
            }
        }
        return $this->render('fii-dii', [
            "model" => $this->findModel(),
            "datas" => FiiDii::find()->active()->orderBy(['date' => SORT_DESC])->one(),
            "result" => json_encode($r),
            "cat" => json_encode($cat),
            "all_datas" => FiiDii::find()->active()->orderBy(['date' => SORT_DESC])->all(),
        ]);
    }

    public function actionIntradaySetups()
    {
        $this->setupMeta([], 'Intraday Setups');
        $datas = '';

        $bulish_momentum = Webhook::find()->andWhere(['scan_name' => 'Bullish momentum & reversal'])->orderBy(['id' => SORT_DESC])->one();
        $bearish_momentum = Webhook::find()->andWhere(['scan_name' => 'Bearish momentum & reversal'])->orderBy(['id' => SORT_DESC])->one();
        $bullish_impulse = Webhook::find()->andWhere(['scan_name' => 'Bullish impulse'])->orderBy(['id' => SORT_DESC])->one();
        $bearish_impulse = Webhook::find()->andWhere(['scan_name' => 'Bearish impulse'])->orderBy(['id' => SORT_DESC])->one();

        return $this->render('intraday-setups', [
            "model" => $this->findModel(),
            "bulish_momentum" => $bulish_momentum,
            "bearish_momentum" => $bearish_momentum,
            "bullish_impulse" => $bullish_impulse,
            "bearish_impulse" => $bearish_impulse,
            "pre_close" => $this->getOpenMarket()
        ]);
    }

    public function actionPositionalSetups()
    {
        $this->setupMeta([], 'Positional Setups');

        return $this->render('positional-setups', [
            "model" => $this->findModel()
        ]);
    }

    public function actionMarketPulse()
    {
        $this->setupMeta([], 'Market Pulse');
        $stocks = Stocks::find()->andWhere(['like', 'types', 'Nifty 50'])->andWhere(['like', 'market_cap', 'Large Cap'])->active()->all();
        $gap_up = Webhook::find()->andWhere(['like', 'scan_name', 'Gap up'])->orderBy('id desc')->active()->one();
        $gap_down = Webhook::find()->andWhere(['like', 'scan_name', 'Gap down'])->orderBy('id desc')->active()->one();
        $open_high = Webhook::find()->andWhere(['like', 'scan_name', 'Open = High'])->orderBy('id desc')->active()->one();
        $open_low = Webhook::find()->andWhere(['like', 'scan_name', 'Open = Low'])->orderBy('id desc')->active()->one();
        $orb_30_h = Webhook::find()->andWhere(['like', 'scan_name', '4. ORB 30H'])->orderBy('id desc')->active()->one();
        $orb_30_l = Webhook::find()->andWhere(['like', 'scan_name', '6. ORB 30L'])->orderBy('id desc')->active()->one();
        $orb_60_h = Webhook::find()->andWhere(['like', 'scan_name', '7. ORB 60H'])->orderBy('id desc')->active()->one();
        $orb_60_l = Webhook::find()->andWhere(['like', 'scan_name', '8. ORB 60L'])->orderBy('id desc')->active()->one();
        $l1 = Webhook::find()->andWhere(['like', 'scan_name', '13. TrForma - L1'])->orderBy('id desc')->active()->one();
        $l2 = Webhook::find()->andWhere(['like', 'scan_name', '11. Trforma - L2'])->orderBy('id desc')->active()->one();
        $l3 = Webhook::find()->andWhere(['like', 'scan_name', '12. Trforma - L3'])->orderBy('id desc')->active()->one();
        $nr4 = Webhook::find()->andWhere(['like', 'scan_name', '9. NR4 + Ins'])->orderBy('id desc')->active()->one();
        $nr7 = Webhook::find()->andWhere(['like', 'scan_name', '10. NR7 + Ins'])->orderBy('id desc')->active()->one();
        $insrk = Webhook::find()->andWhere(['like', 'scan_name', '14. Insrk32'])->orderBy('id desc')->active()->one();
        $inside = Webhook::find()->andWhere(['like', 'scan_name', 'Inside Prev'])->orderBy('id desc')->active()->one();
        $top_gainers = Webhook::find()->andWhere(['like', 'scan_name', 'Top Gainers'])->orderBy('id desc')->active()->one();
        $top_losers = Webhook::find()->andWhere(['like', 'scan_name', 'Top Losers'])->orderBy('id desc')->active()->one();
        //  print_r($gap_up);exit;
        return $this->render('market-pulse', [
            "stocks" => $stocks,
            "gap_up" => $gap_up,
            "gap_down" => $gap_down,
            "open_high" => $open_high, "open_low" => $open_low,
            "orb_30_h" => $orb_30_h,
            "orb_30_l" => $orb_30_l,
            "orb_60_h" => $orb_60_h,
            "orb_60_l" => $orb_60_l,
            "l1" => $l1,
            "l2" => $l2,
            "l3" => $l3,
            "nr4" => $nr4,
            "nr7" => $nr7,
            "insrk" => $insrk,
            "inside" => $inside,
            "top_gainers" => $top_gainers,
            "top_losers" => $top_losers,
            "pre_close" => $this->getOpenMarket()
        ]);
    }

    public function actionGetMarketPulse()
    {
        $pre_market_data = '';
        $market_cheat_sheet = '';
        if (Yii::$app->request->post()) {
            if (Yii::$app->request->post()['types'] === 'all') {
                $stocks = Stocks::find()->andWhere(['like', 'market_cap', Yii::$app->request->post()['cap']])->active()->all();
            } else {
                $stocks = Stocks::find()->andWhere(['like', 'types', Yii::$app->request->post()['types']])->andWhere(['like', 'market_cap', Yii::$app->request->post()['cap']])->active()->all();
            }
            $pre_close =  $this->getOpenMarket();

            if (!empty($stocks)) {
                foreach ($stocks as $s) {
                    if (array_key_exists($s->name, $pre_close)) {
                        $number = ((Yii::$app->function->getAmount(@$pre_close[$s->name][1]) - Yii::$app->function->getAmount(@$pre_close[$s->name][0])) / Yii::$app->function->getAmount(@$pre_close[$s->name][0])) * 100;
                        $change =  number_format((float)$number, 2, '.', '');
                        $pre_market_data .= '<tr><td>' . $s->name . '</td><td align="center">' . @$pre_close[$s->name][0] . '</td><td align="center">' . @$pre_close[$s->name][1] . '</td><td align="center">' . $change . '</td><td>' . $s->sector . '</td></tr>';
                    }
                }
            } else {
                $pre_market_data = '';
            }

            $gap_up = Webhook::find()->andWhere(['like', 'scan_name', 'Gap up'])->orderBy('id desc')->active()->one();
            $gap_down = Webhook::find()->andWhere(['like', 'scan_name', 'Gap down'])->orderBy('id desc')->active()->one();
            $open_high = Webhook::find()->andWhere(['like', 'scan_name', 'Open = High'])->orderBy('id desc')->active()->one();
            $open_low = Webhook::find()->andWhere(['like', 'scan_name', 'Open = Low'])->orderBy('id desc')->active()->one();
            $orb_30_h = Webhook::find()->andWhere(['like', 'scan_name', '4. ORB 30H'])->orderBy('id desc')->active()->one();
            $orb_30_l = Webhook::find()->andWhere(['like', 'scan_name', '6. ORB 30L'])->orderBy('id desc')->active()->one();
            $orb_60_h = Webhook::find()->andWhere(['like', 'scan_name', '7. ORB 60H'])->orderBy('id desc')->active()->one();
            $orb_60_l = Webhook::find()->andWhere(['like', 'scan_name', '8. ORB 60L'])->orderBy('id desc')->active()->one();
            $l1 = Webhook::find()->andWhere(['like', 'scan_name', '13. TrForma - L1'])->orderBy('id desc')->active()->one();
            $l2 = Webhook::find()->andWhere(['like', 'scan_name', '11. Trforma - L2'])->orderBy('id desc')->active()->one();
            $l3 = Webhook::find()->andWhere(['like', 'scan_name', '12. Trforma - L3'])->orderBy('id desc')->active()->one();
            $nr4 = Webhook::find()->andWhere(['like', 'scan_name', '9. NR4 + Ins'])->orderBy('id desc')->active()->one();
            $nr7 = Webhook::find()->andWhere(['like', 'scan_name', '10. NR7 + Ins'])->orderBy('id desc')->active()->one();
            $insrk = Webhook::find()->andWhere(['like', 'scan_name', '14. Insrk32'])->orderBy('id desc')->active()->one();
            $inside = Webhook::find()->andWhere(['like', 'scan_name', 'Inside Prev'])->orderBy('id desc')->active()->one();
            $top_gainers = Webhook::find()->andWhere(['like', 'scan_name', 'Top Gainers'])->orderBy('id desc')->active()->one();
            $top_losers = Webhook::find()->andWhere(['like', 'scan_name', 'Top Losers'])->orderBy('id desc')->active()->one();

            $gap_up = explode(',', @$gap_up->stocks);
            $gap_down = explode(',', @$gap_down->stocks);
            $open_high = explode(',', @$open_high->stocks);
            $open_low = explode(',', @$open_low->stocks);
            $orb_30_h = explode(',', @$orb_30_h->stocks);
            $orb_30_l = explode(',', @$orb_30_l->stocks);
            $orb_60_h = explode(',', @$orb_60_h->stocks);
            $orb_60_l = explode(',', @$orb_60_l->stocks);
            $l1 = explode(',', @$l1->stocks);
            $l2 = explode(',', @$l2->stocks);
            $l3 = explode(',', @$l3->stocks);
            $nr4 = explode(',', @$nr4->stocks);
            $nr7 = explode(',', @$nr7->stocks);
            $insrk = explode(',', @$insrk->stocks);
            $inside = explode(',', @$inside->stocks);
            if (!empty($stocks)) {
                foreach ($stocks as $s) {
                    if (array_key_exists($s->name, $pre_close)) {
                        $gap = '---';
                        if (in_array($s->name, $gap_up)) {
                            $gap = 'Gap Up';
                        } else if (in_array($s->name, $gap_down)) {
                            $gap = 'Gap Down';
                        }
                        $open = '---';
                        if (in_array($s->name, $open_high)) {
                            $open = 'O = H';
                        } else if (in_array($s->name, $open_low)) {
                            $open = 'O = L';
                        }
                        $orb = '';
                        if (in_array($s->name, $orb_30_h)) {
                            $orb = '30 Mins - High,';
                        }
                        if (in_array($s->name, $orb_30_l)) {
                            $orb .= '30 Mins - Low,';
                        }
                        if (in_array($s->name, $orb_60_h)) {
                            $orb .= '60 Mins - High,';
                        }
                        if (in_array($s->name, $orb_60_l)) {
                            $orb .= '60 Mins - Low';
                        }
                        $nr = '';
                        if (in_array($s->name, $nr4)) {
                            $nr .= 'NR4/';
                        }
                        if (in_array($s->name, $nr7)) {
                            $nr .= 'NR7';
                        }
                        $tri = '';
                        if (in_array($s->name, $l1) || in_array($s->name, $l2) || in_array($s->name, $l3)) {
                            if (in_array($s->name, $l1)) {
                                $tri .= '<span class="triangle_box color_l1"></span>';
                            }
                            if (in_array($s->name, $l2)) {
                                $tri .=  '<span class="triangle_box color_l1"></span><span class="triangle_box color_l2"></span>';
                            }
                            if (in_array($s->name, $l3)) {
                                $tri .=  '<span class="triangle_box color_l1"></span><span class="triangle_box color_l2"></span><span class="triangle_box color_l3"></span>';
                            }
                        } else {
                            $tri =  '---';
                        }
                        $number = ((Yii::$app->function->getAmount($pre_close[$s->name][1]) - Yii::$app->function->getAmount($pre_close[$s->name][0])) / Yii::$app->function->getAmount($pre_close[$s->name][0])) * 100;
                        $change =  number_format((float)$number, 2, '.', '');
                        $in = '';
                        if (in_array($s->name, @$insrk)) {
                            $in .= 'SHARK 32,';
                        }
                        if (in_array($s->name, @$inside)) {
                            $in .= '1D INS';
                        }
                        $market_cheat_sheet .= '<tr>
                <td>' . $s->name . '</td>
                <td>' . $gap . '</td>
                <td>' . $change . '</td>
                <td>' . $open . '</td>
                <td>' . ($orb !== '' ? rtrim($orb, ',') : '---') . '</td>
                <td>' . ($nr !== '' ? rtrim($nr, '/') : '---') . '</td>
                <td>' . $tri . '</td>
                <td>' . ($in !== '' ? rtrim($in, ',') : '---') . '</td></tr>';
                    }
                }
            } else {
                $market_cheat_sheet = '';
            }
        }

        $categories = [];
        $gainers_prices = [];
        $top_gainers_cat = [];
        $top_gainers_prices =  explode(',', @$top_gainers->trigger_prices);
        $top_gainers =  explode(',', @$top_gainers->stocks);

        $stocks_p = [];
        if (!empty($top_gainers)) {
            foreach ($top_gainers as $k => $top_gainer) {
                $stocks_p[$top_gainer] = $top_gainers_prices[$k];
            }
        }

        if (!empty($stocks)) {
            foreach ($stocks as $k => $stock) {
                if (array_key_exists($stock->name, $pre_close)) {
                    if (in_array($stock->name, $top_gainers)) {
                        $categories[$stock->name] = (($stocks_p[$stock->name] - Yii::$app->function->getAmount($pre_close[$stock->name][0])) / Yii::$app->function->getAmount($pre_close[$stock->name][0])) * 100;
                    }
                }
            }
        }

        arsort($categories);
        $i = 0;
        if (!empty($categories)) {
            foreach ($categories as $k => $category) {
                if ($i > 10) {
                    continue;
                }
                $top_gainers_cat[] = $k;
                $gainers_prices[] = number_format((float)$category, 2, '.', '');
                $i++;
            }
        }


        $categories = [];
        $losers_prices = [];
        $top_losers_cat = [];
        $top_losers_prices =  explode(',', @$top_losers->trigger_prices);
        $top_losers =  explode(',', @$top_losers->stocks);

        $stocks_p = [];
        if (!empty($top_losers)) {
            foreach ($top_losers as $k => $top_loser) {
                $stocks_p[$top_loser] = $top_losers_prices[$k];
            }
        }

        if (!empty($stocks)) {
            foreach ($stocks as $k => $stock) {
                if (array_key_exists($stock->name, $pre_close)) {
                    if (in_array($stock->name, $top_losers)) {
                        $categories[$stock->name] = (($stocks_p[$stock->name] - Yii::$app->function->getAmount($pre_close[$stock->name][0])) / Yii::$app->function->getAmount($pre_close[$stock->name][0])) * 100;
                    }
                }
            }
        }
        asort($categories);
        $i = 0;
        if (!empty($categories)) {
            foreach ($categories as $k => $category) {
                if ($i > 10) {
                    continue;
                }
                $top_losers_cat[] = $k;
                $losers_prices[] = number_format((float)$category, 2, '.', '');
                $i++;
            }
        }


        echo json_encode([
            'pre_market_data' => $pre_market_data,
            'market_cheat_sheet' => $market_cheat_sheet,
            'top_gainers_cat' => $top_gainers_cat,
            'gainers_prices' => $gainers_prices,
            'top_losers_cat' => $top_losers_cat,
            'losers_prices' => $losers_prices
        ]);
        exit;
    }

    protected function getOpenMarket()
    {
        $pre_close = [];
        if (fopen(Yii::getAlias('@webroot') . '/webhook/Open-Market.csv', "r")) {
            $myfile = fopen(Yii::getAlias('@webroot') . '/webhook/Open-Market.csv', "r") or die("Unable to open file!");

            while (($data = fgetcsv($myfile)) !== false) {
                $pre_close[$data[0]] = [
                    @$data[1],  @$data[5],
                ];
            }
            fclose($myfile);
        }
        return $pre_close;
    }

    protected function dataType($type)
    {
        $r = [
            "stocks" =>  [
                [
                    'name' => 'Fii',
                    'dataName' => 'stocks_fii',
                    'type' => 'column',
                    'data' => []
                ],
                [
                    'name' => 'Dii',
                    'dataName' => 'stocks_dii',
                    'type' => 'column',
                    'data' => []
                ]
            ],
            "fif" =>  [
                [
                    'name' => 'NIFTY',
                    'type' => 'column',
                    'dataName' => 'fif_nifty',
                    'data' => []
                ],
                [
                    'name' => 'BANKNIFTY',
                    'type' => 'column',
                    'dataName' => 'fif_banknifty',
                    'data' => []
                ]
            ],
            "ffo" =>  [
                [
                    'name' => 'Change in Fut OI',
                    'type' => 'column',
                    'dataName' => 'ffo_full',
                    'data' => []
                ],
                [
                    'name' => 'Total Fut OI',
                    'type' => 'column',
                    'dataName' => 'ffo_fut',
                    'data' => []
                ]
            ],
            "ficc" =>  [
                [
                    'name' => 'Long OI Chg',
                    'type' => 'column',
                    'dataName' => 'ficc_long',
                    'data' => []
                ],
                [
                    'name' => 'Short OI Chg',
                    'type' => 'column',
                    'dataName' => 'ficc_short',
                    'data' => []
                ]
            ],
            "fipc" =>  [
                [
                    'name' => 'Long OI Chg',
                    'type' => 'column',
                    'dataName' => 'fipc_long',
                    'data' => []
                ],
                [
                    'name' => 'Short OI Chg',
                    'type' => 'column',
                    'dataName' => 'fipc_short',
                    'data' => []
                ]
            ],
            "fic" =>  [
                [
                    'name' => 'Long',
                    'type' => 'column',
                    'dataName' => 'fic_long',
                    'data' => []
                ],
                [
                    'name' => 'Short',
                    'type' => 'column',
                    'dataName' => 'fic_short',
                    'data' => []
                ]
            ],
            "fip" =>  [
                [
                    'name' => 'Long',
                    'type' => 'column',
                    'dataName' => 'fip_long',
                    'data' => []
                ],
                [
                    'name' => 'Short',
                    'type' => 'column',
                    'dataName' => 'fip_short',
                    'data' => []
                ]
            ],
        ];

        return $r[$type];
    }

    protected function findModel()
    {
        if (($model = Customer::findOne(Yii::$app->user->identity->id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    

    protected function getPreMarketData()
    {
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
        return json_decode($response, true);
    }

    protected function getNiftyLiveData()
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://groww.in/v1/api/stocks_data/v1/accord_points/exchange/NSE/segment/CASH/latest_indices_ohlc/NIFTY',
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
        return json_decode($response, true);
    }

    protected function getBankLiveData()
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://groww.in/v1/api/stocks_data/v1/accord_points/exchange/NSE/segment/CASH/latest_indices_ohlc/BANKNIFTY',
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
        return json_decode($response, true);
    }

    public function actionUpdateProfile()
    {
        $model = $this->findModel();
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
                    $result = [
                        'status' => 200,
                        'message' => 'Updated Successfully.'
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
}
