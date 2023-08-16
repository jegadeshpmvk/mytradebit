<div class="dashboard options_board">
    <div class="dash_sec dash_sec_padd">
        <div class="c">
            <div class="dash_sec_inner">
                <div class="intra_title stocks_type_groups">
                    <label>
                        <input class="stocks_type options_board_change" name="stocks_type" type="radio" checked value="nify">
                        <span class="pre_market_radio"></span> <span>NIFTY - <?= $nifty_live; ?></span>
                    </label>
                    <label>
                        <input class="stocks_type options_board_change" name="stocks_type" type="radio" value="nifty-bank">
                        <span class="pre_market_radio"></span> <span>BANKNIFTY - <?= $bank_live; ?></span>
                    </label>
                    <div class="options_form_group">
                        <label>Form Strike Price</label>
                        <input type="text" name="from_stike_price" value="19000" class="options_form_control options_board_change" />
                    </div>
                    <div class="options_form_group">
                        <label>To Strike Price</label>
                        <input type="text" name="to_stike_price" value="20000" class="options_form_control options_board_change" />
                    </div>
                    <div class="options_form_group">
                        <label>Trade Date</label>
                        <div class="custom_date_picker">
                            <input type="text" name="trade_date" value="<?= date('Y-m-d'); ?>" max="<?= date('Y-m-d'); ?>" class="trade_date_datepicker options_form_control options_board_change" />
                        </div>
                    </div>
                    <div class="options_form_group">
                        <label>Expiry Date</label>
                        <div class="custom_date_picker">
                            <input type="text" name="expiry_date" value="<?= date('Y-m-d', strtotime('next thursday')); ?>" class="expiry_date_datepicker options_form_control options_board_change" />
                        </div>
                    </div>
                    <div class="options_form_group">
                        <label>Start Time</label>
                        <input type="time" name="start_time" value="09:15" class="options_form_control options_board_change" />
                    </div>
                    <div class="options_form_group">
                        <label>End Time</label>
                        <input type="time" name="end_time" value="15:30" class="options_form_control options_board_change" />
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="dash_sec dash_sec_padd">
        <div class="c">
            <div class="dash_sec_inner">
                <div class=""></div>
                <div class="timings">
                    <label>
                        <input class="timing" name="minutes" type="radio" checked value="5">
                        <span class="timing_button">Last 5 mins</span>
                    </label>
                    <label>
                        <input class="timing" name="minutes" type="radio" value="10">
                        <span class="timing_button">Last 10 mins</span>
                    </label>
                    <label>
                        <input class="timing" name="minutes" type="radio" value="15">
                        <span class="timing_button">Last 15 mins</span>
                    </label>
                    <label>
                        <input class="timing" name="minutes" type="radio" value="30">
                        <span class="timing_button">Last 30 mins</span>
                    </label>
                    <label>
                        <input class="timing" name="minutes" type="radio" value="">
                        <span class="timing_button">Last 1 Hrs</span>
                    </label>
                    <label>
                        <input class="timing" name="minutes" type="radio" value="">
                        <span class="timing_button">Last 2 Hrs</span>
                    </label>
                    <label>
                        <input class="timing" name="minutes" type="radio" value="">
                        <span class="timing_button">Last 3 Hrs</span>
                    </label>
                    <label>
                        <input class="timing" name="minutes" type="radio" value="">
                        <span class="timing_button">Full Day</span>
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="dash_sec dash_sec_padd">
        <div class="c">
            <div class="intra_row">
                <div class="_col _option_scope">
                    <div class="dash_sec_inner">
                        <div class="intra_title">
                            <span class="">Options Scope <span title="test">(?)</span></span>
                        </div>
                        <div class="dash_content">
                            <table class="custom_table_data">
                                <thead>
                                    <tr>
                                        <th>Calls</th>
                                        <th>Strike</th>
                                        <th>Puts</th>
                                        <th>Level Analysis</th>
                                    </tr>
                                </thead>
                                <tbody class="pre_market_data options_scope">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="_col _option_scope_center">
                    <div class="dash_sec_inner">
                        <div class="dash_content net_oi">

                        </div>
                    </div>
                </div>
                <div class="_col _option_scope_last">
                    <div class="dash_sec_inner">
                        <div class="dash_content options_sentiment">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="dash_sec dash_sec_padd">
        <div class="c">
            <div class="dash_sec_inner">
                <div class="dash_content">
                    <div class="" id="total_open"></div>
                    <div class="total_text_view">
                        <div class="total_text_left">
                            <span>TOTAL OI View</span> <span>BULLISH</span>
                        </div>
                        <div class="total_text_right">
                            <div class="">
                                <span>TOTAL CE OI</span> <span>27,85,369</span>
                            </div>
                            <div class="">
                                <span>TOTAL PE OI</span> <span>27,85,369</span>
                            </div>
                            <div class="">
                                <span>Total PCR</span> <span>27,85,369</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>